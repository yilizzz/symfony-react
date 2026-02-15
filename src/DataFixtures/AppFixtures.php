<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Street;
use App\Entity\Owner;
use App\Entity\Location;
use App\Entity\WaterMeter;
use App\Entity\Reading;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1. 创建城市 (Cities)
        $citiesData = ['Troyes', 'Bar-sur-Aube', 'Bréviandes', 'Chaource'];
        $cities = [];
        foreach ($citiesData as $name) {
            $city = new City();
            $city->setName($name);
            $manager->persist($city);
            $cities[] = $city;
        }

        // 2. 创建街道 (Streets) - 每个城市分配几条街道
        $streets = [];
        $streetNames = ['Rue de la Paix', 'Avenue des Champs-Élysées', 'Rue de la République', 'Place Bellecour'];
        foreach ($cities as $city) {
            foreach ($streetNames as $sName) {
                $street = new Street();
                $street->setName($sName);
                $street->setCity($city);
                $manager->persist($street);
                $streets[] = $street;
            }
        }

        // 3. 创建业主 (Owners)
        $owners = [];
        $ownerNames = ['Jean Dupont', 'Marie Curie', 'Pierre Martin', 'Lucie Bernard'];
        foreach ($ownerNames as $oName) {
            $owner = new Owner();
            $owner->setName($oName);
            $owner->setPhone('+33 6 ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99));
            $owner->setIdCard(rand(1000000000, 9999999999));
            $lower_case = strtolower($oName);
            $no_spaces = str_replace(' ', '', $lower_case);
            $owner->setEmail($no_spaces . rand(1, 50) . '@gmail.com');
            $manager->persist($owner);
            $owners[] = $owner;
        }

        // 4. 创建位置 (Locations) & 水表 (WaterMeters) & 读数 (Readings)
        foreach ($streets as $index => $street) {
            // 为每条街道随机分配一个业主
            $randomOwner = $owners[array_rand($owners)];

            $location = new Location();
            $location->setStreet($street);
            $location->setOwner($randomOwner);
            $location->setBuildingNumber(rand(1, 150) . ' bis');
            $location->setUnitRoom('Appartement ' . rand(1, 20));
            $manager->persist($location);

            // 为该位置创建一个水表
            $meter = new WaterMeter();
            $meter->setSerialNumber('FR-MET-' . $index . '-' . rand(100, 999));
            $meter->setLocation($location);
            $manager->persist($meter);

            // 为该水表生成过去 3 个月的随机读数
            $baseValue = rand(100, 500);
            for ($i = 0; $i < 3; $i++) {
                $reading = new Reading();
                $reading->setWaterMeter($meter);
                $reading->setValue($baseValue + ($i * rand(10, 30))); // 读数递增
                $reading->setCreatedAt(new \DateTimeImmutable("-" . (3 - $i) . " month"));
                $manager->persist($reading);
            }
        }

        // 5. 统一提交到数据库
        $manager->flush();
    }
}