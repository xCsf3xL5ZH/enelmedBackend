<?php

namespace App\Controller\Api;

use App\Entity\MedicalPackage;
use App\Repository\MedicalPackageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Service\JsonRequestToArrayConventer;
use App\Service\ObjectSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class MedicalPackageController extends AbstractController
{

    /**
     * @var ObjectSerializer $objectSerializer
     */
    private $objectSerializer;

    const _MEDICAL_PACKAGE_MAPPING_ = array('id', 'name', 'isActive');

    /**
     * MedicalPackageController constructor.
     * @param ObjectSerializer $objectSerializer
     */
    public function __construct(ObjectSerializer $objectSerializer)
    {
        $this->objectSerializer = $objectSerializer;
    }


    /**
     * Returns an array of MedicalPackage objects
     *
     * @Route("/api/medicalPackage", name="api_medical_package_get_all", methods={"GET"})
     */
    public function getAll()
    {
        /** @var MedicalPackageRepository $repository */
        $repository = $this->getDoctrine()->getManager()->getRepository(MedicalPackage::class);
        $medical_packages = $repository->getAllActive();

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
        $data =  $this->objectSerializer->serialize($medicalPackage, self::_MEDICAL_PACKAGE_MAPPING_);

        return $this->json($data);
    }

}
