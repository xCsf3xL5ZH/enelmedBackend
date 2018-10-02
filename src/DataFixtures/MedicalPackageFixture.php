<?php

namespace App\DataFixtures;

use App\Entity\MedicalPackage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MedicalPackageFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as [
             $name, $isActive
        ]) {
            $medicalPackage = new MedicalPackage();
            $medicalPackage->setName($name);
            $medicalPackage->setIsActive($isActive);

            $manager->persist($medicalPackage);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            // [$name, $isActive];
            ['PAKIET STANDARD', true],
            ['PAKIET STANDARD PLUS', true],
            ['PAKIET VIP', true],
            ['PAKIET RODZINNY', false],
            ['PAKIET STOMATOLOGICZNY', true],
        ];
    }
}
