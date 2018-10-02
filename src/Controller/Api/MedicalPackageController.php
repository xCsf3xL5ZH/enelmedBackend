<?php

namespace App\Controller\Api;

use App\Entity\MedicalPackage;
use App\Repository\MedicalPackageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MedicalPackageController extends AbstractController
{
    /**
     * Returns an array of MedicalPackage objects
     *
     * @Route("/api/medicalPackage", name="api_medical_package_get_all", methods={"GET"})
     */
    public function getAll()
    {
        /** @var MedicalPackageRepository $repository */
        $repository = $this->getDoctrine()->getManager()->getRepository(MedicalPackage::class);
        $medical_packages = $repository->pobierzWszystkieAktywne();

        $data = [];

        /** @var Customer $customer */
        foreach ($medical_packages as $medical_package) {
            $data[] = [
                'id' => $medical_package->getId(),
                'name' => $medical_package->getName(),
                'isActive' => $medical_package->getIsActive(),
            ];
        }

        return $this->json($data);
    }

    /**
     * Returns an array of MedicalPackage objects
     *
     * @Route("/api/medicalPackage/{id}", name="api_medical_package_get", requirements={"id": "\d+"}, methods={"GET"})
     * @ParamConverter("medicalPackage")
     *
     * @param MedicalPackage $medicalPackage
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getOne(MedicalPackage $medicalPackage)
    {
        $data = $this->transform($medicalPackage);

        return $this->json($data);
    }

    protected function transform($medical_package) : array
    {
        /**
         * @var MedicalPackage $medical_package
         */
        return [
            'id' => $medical_package->getId(),
            'name' => $medical_package->getName(),
            'is_active' => $medical_package->getIsActive() ? true : false,
        ];
    }
}
