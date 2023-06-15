<?php

namespace App\Exceptions;

use App\Helpers\SiteLogger;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\RouterInterface;

class ExceptionHandler
{

    public RequestStack       $requestStack;
    public ContainerInterface $container;
    public RouterInterface    $router;
    public SiteLogger         $logger;

    public function __construct(
        RequestStack       $requestStack,
        ContainerInterface $container,
        RouterInterface    $router,
        SiteLogger         $logger
    )
    {
        $this->requestStack = $requestStack;
        $this->router       = $router;
        $this->container    = $container;
        $this->logger       = $logger;
    }

    private function logError(\Throwable $exception)
    {

        $message = sprintf(
            'My Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        dd($message);

        //TODO send email to the developers, or at slack, or we can use sentry
        $this->logger->logError($message, $exception);

    }

    public function __invoke(ExceptionEvent $event): void
    {

        $currentRequest = $this->requestStack->getCurrentRequest();

        $exception = $event->getThrowable();
        $this->logError($exception);

        $message = "try again later";
        if ($exception->getCode() == 322) {
            $message = $exception->getMessage();
        }

        if ($currentRequest->isXmlHttpRequest()) {
            $response = new Response(
                '<div class="alert alert-danger">Please Refresh</div>',
                200
            );

            $event->setResponse($response);
            return;
        }

        $this->container->get('request_stack')->getSession()->getFlashBag()->add("errors", $message);

        $url      = $this->router->generate('app_home');
        $response = new RedirectResponse($url . "?message=" . $message);
        $event->setResponse($response);
    }

}