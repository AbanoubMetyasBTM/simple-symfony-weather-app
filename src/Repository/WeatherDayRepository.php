<?php

namespace App\Repository;

use App\Adapters\Weather\WeatherResultType;
use App\Entity\WeatherDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<WeatherDay>
 *
 * @method WeatherDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeatherDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeatherDay[]    findAll()
 * @method WeatherDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherDayRepository extends ServiceEntityRepository
{

    private SerializerInterface $serializer;


    public function __construct(
        ManagerRegistry     $registry,
        SerializerInterface $serializer
    )
    {
        parent::__construct($registry, WeatherDay::class);

        $this->serializer = $serializer;
    }

    public function add(WeatherDay $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WeatherDay $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param string $countryName
     * @param string $cityName
     * @param string $date
     * @return WeatherDay|null
     */
    public function findCityWeatherForaCertainDay(string $countryName, string $cityName, string $date): ?WeatherDay
    {
        return $this->createQueryBuilder('weatherObj')
            ->andWhere('weatherObj.countryName = :countryName')
            ->setParameter('countryName', $countryName)
            ->andWhere('weatherObj.cityName = :cityName')
            ->setParameter('cityName', $cityName)
            ->andWhere('weatherObj.dayKey = :dayKey')
            ->setParameter('dayKey', $date)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }


    /**
     * @param string $countryName
     * @param string $cityName
     * @param WeatherResultType[] $WeatherResult
     * @return WeatherDay
     */
    public function createNewRow(string $countryName, string $cityName, array $WeatherResult): WeatherDay
    {
        $dayObj = new WeatherDay();

        $dayObj
            ->setCountryName($countryName)
            ->setCityName($cityName)
            ->setDayKey(date("Y-m-d H"))
            ->setForecastDays($this->serializer->serialize($WeatherResult,"json"));

        $this->getEntityManager()->persist($dayObj);
        $this->getEntityManager()->flush();

        return $dayObj;
    }


}
