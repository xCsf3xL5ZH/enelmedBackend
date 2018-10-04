<?php

namespace App\Controller\Api;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\JsonRequestToArrayConventer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Service\ObjectSerializer;

class CustomerController extends AbstractController
{
    const _CUSTOMER_MAPPING_ = array(
        'firstname',
        'lastname',
        'email',
        'birthdate',
        'address',
        'postalCode',
        'city',
        'isActive',
        'id',
    );

    /**
     * @var CustomerRepository $customerRepository
     */
    private $customerRepository;

    /**
     * @var JsonRequestToArrayConventer $jsonRequestToArrayConventer
     */
    private $jsonRequestToArrayConventer;

    /**
     * @var ObjectSerializer $objectSerializer
     */
    private $objectSerializer;


    /**
     * CustomerController constructor.
     * @param CustomerRepository $customerRepository
     * @param JsonRequestToArrayConventer $jsonRequestToArrayConventer
     * @param ObjectSerializer $objectSerializer
     */
    public function __construct(CustomerRepository $customerRepository, JsonRequestToArrayConventer $jsonRequestToArrayConventer, ObjectSerializer $objectSerializer)
    {
        $this->customerRepository = $customerRepository;
        $this->jsonRequestToArrayConventer = $jsonRequestToArrayConventer;
        $this->objectSerializer = $objectSerializer;
    }


    /**
     * Returns an array of MedicalPackage objects
     *
     * @Route("/api/customer", name="api_customer_get_all", methods={"GET"})
     */
    public function getAll()
    {
        $customers = $this->customerRepository->findAll();

        $data = [];

        /** @var Customer $customer */
        foreach ($customers as $customer) {
            $data[] = $this->objectSerializer->serialize($customer, self::_CUSTOMER_MAPPING_);
        }

        return $this->json($data);
    }

    /**
     * Returns an Customer object
     *
     * @Route("/api/customer/{id}", name="api_customer_get", requirements={"id": "\d+"}, methods={"GET"})
     * @ParamConverter("customer")
     *
     * @param Customer $customer
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getOne(Customer $customer)
    {
        $customer = $this->customerRepository->findOneById($customer->getId());

        $data = $this->objectSerializer->serialize($customer, self::_CUSTOMER_MAPPING_)
        ;

        return $this->json($data);
    }

    /**
     * Create new customer
     *
     * @Route("/api/customer", name="api_customer_put", methods={"PUT"})
     */
    public function create(Request $request)
    {
        $data = $this->jsonRequestToArrayConventer->getJsonRequestContentAsArray($request);

        $customer = new Customer();
        $customer->setFirstname($data['firstname'])
                 ->setLastname($data['lastname'])
                 ->setEmail($data['email'])
                 ->setBirthdate(\DateTime::createFromFormat('Y-m-d', $data['birthdate']))
                 ->setAddress($data['address'])
                 ->setPostalCode($data['postalCode'])
                 ->setCity($data['city'])
                 ->setIsActive($data['isActive']);

        $this->customerRepository->save($customer);

        return $this->json(null, 200, [
            'Location' => $this->generateUrl('api_customer_get', ['id' => $customer->getId()])
        ]);
    }

    /**
     * Update customer
     *
     * @Route("/api/customer/{id}", name="api_customer_update", methods={"POST"})
     */
    public function update(Request $request, $id)
    {
        $data = $this->jsonRequestToArrayConventer->getJsonRequestContentAsArray($request);

        $customer = $this->customerRepository->findOneById($id);

        if(!$customer) {
            throw $this->createNotFoundException();
        }

        $customer->setFirstname($data['firstname'])
                 ->setLastname($data['lastname'])
                 ->setEmail($data['email'])
                 ->setBirthdate(\DateTime::createFromFormat('Y-m-d', $data['birthdate']))
                 ->setAddress($data['address'])
                 ->setPostalCode($data['postalCode'])
                 ->setCity($data['city'])
                 ->setIsActive($data['isActive']);

        $this->customerRepository->save($customer);

        return $this->json(null, 200);
    }

}
