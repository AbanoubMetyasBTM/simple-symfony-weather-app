<?php

namespace App\Controller;

use App\Adapters\Weather\WeatherResultType;
use App\Dtos\GetCityWeatherRequest;
use App\Helpers\StaticData;
use App\Helpers\ValidationHelper;
use App\Services\HomeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HomeController extends AbstractController
{

    private HomeService         $homeService;
    private SerializerInterface $serializer;
    private ValidatorInterface  $validator;

    public function __construct(
        HomeService         $homeService,
        SerializerInterface $serializer,
        ValidatorInterface  $validator
    )
    {
        $this->homeService = $homeService;
        $this->serializer  = $serializer;
        $this->validator   = $validator;
    }

    private function validateRequestAndGetDate(Request $request)
    {

        $dto    = $this->serializer->deserialize(json_encode($request->request->all()), GetCityWeatherRequest::class, 'json');
        $errors = $this->validator->validate($dto);
        $errors = ValidationHelper::convertErrorsToArray($errors);
        $this->addFlash("errors", implode(",<br>", $errors));

        if (count($errors) > 0) {
            return null;
        }

        $countryName = $dto->countryCode;
        $cityName    = $dto->cityName;

        $weatherData = $this->homeService->getWeatherData($countryName, $cityName);
        return $weatherData->getForecastDays();
    }


    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request): Response
    {

        return $this->render('home/index.html.twig', [
            "countries"    => StaticData::listCountryCodes(),
            'request_data' => (object)$request->query->all(),
        ]);
    }

    /**
     * @Route("/get-result", name="app_get_result", methods={"POST"})
     */
    public function getAjaxResult(Request $request): Response
    {

        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('general_csrf', $submittedToken)) {
            return new Response(
                '<div class="alert alert-danger">csrf invalid</div>',
                200
            );
        }

        /**
         * @var WeatherResultType|null $weatherData
         */
        $weatherData = $this->validateRequestAndGetDate($request);

        return $this->render('home/weather.html.twig', [
            'request_data' => (object)$request->request->all(),
            'weather_days' => $weatherData,
        ]);
    }


}
