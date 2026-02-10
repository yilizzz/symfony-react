<?php

namespace App\DataFixtures;

use App\Entity\WaterMeter;
use App\Entity\Reading;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1. 先创建一个水表设备
        $meter = new WaterMeter();
        $meter->setSerialNumber('WM-2026-001');
        $meter->setLocation('Kitchen Main Pipe');
        $manager->persist($meter);
      
        $currentReading = 0;
        for ($month = 5; $month >= 0; $month--) {
            $reading = new Reading();
            $currentReading += rand(10, 30); // 模拟每月增加的用水量
            $reading->setValue($currentReading);
            // 模拟过去的日期
            $date = new \DateTimeImmutable("-$month month");
            $reading->setCreatedAt($date);
            $reading->setWaterMeter($meter); // 关联外键
            
            $manager->persist($reading);
        }

        $manager->flush();
    }
}
