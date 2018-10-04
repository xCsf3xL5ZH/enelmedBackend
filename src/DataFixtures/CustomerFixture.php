<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as [
            $firstname, $lastname, $email, $birthdate, $address, $postalCode, $city, $isActive
        ]) {
            $customer = new Customer();
            $customer->setFirstname($firstname);
            $customer->setLastname($lastname);
            $customer->setEmail($email);
            $customer->setBirthdate($birthdate);
            $customer->setAddress($address);
            $customer->setPostalCode($postalCode);
            $customer->setCity($city);
            $customer->setIsActive($isActive);

            $manager->persist($customer);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            // [$firstname, $lastname, $email, $birthdate, $address, $postalCode, $city, $isActive];
            ['Jan', 'Kowalski', 'jan@poczta.com', new \DateTime('1989-08-11'), 'Warszawska 1/2', '22-333', "Warszawa", true],
            ['Maria', 'Bielawska', 'maria@poczta.com', new \DateTime('1976-12-03'), 'Okrężna 11', '33-111', "Poznań", false],
            ['Dariusz', 'Szpak', 'darek.sz@poczta.com', new \DateTime('1990-02-15'), 'Świętokrzyska 2/122', '02-332', "Warszawa", true],
            ['Julian', 'Mączyński', 'julek.m@poczta.com', new \DateTime('1948-06-28'), 'Katowicka 40', '11-140', "Gdańsk", true],
        ];
    }
}