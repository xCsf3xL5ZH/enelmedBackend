<?php

namespace App\Controller\Api;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * Returns an array of MedicalPackage objects
     *
     * @Route("/api/customer", name="api_customer_get_all", methods={"GET"})
     */
    public function getAll()
    {
        $customers = $this->getDoctrine()->getManager()->getRepository(Customer::class)->findAll();

        $data = [];

        /** @var Customer $customer */
        foreach ($customers as $customer) {
            $data[] = [
                'firstname' => $customer->getFirstname(),
                'lastname' => $customer->getLastname(),
                'email' => $customer->getEmail(),
                'birthdate' => $customer->getBirthdate()->format('Y-m-d'),
                'address' => $customer->getAddress(),
                'postalCode' => $customer->getPostalCode(),
                'city' => $customer->getCity(),
                'isActive' => $customer->getAktywny(),
            ];
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
        $customer = $this->getDoctrine()->getManager()->getRepository(Customer::class)->findOneById($customer->getId());

        $data = [
            'firstname' => $customer->getFirstname(),
            'lastname' => $customer->getLastname(),
            'email' => $customer->getEmail(),
            'birthdate' => $customer->getBirthdate()->format('Y-m-d'),
            'address' => $customer->getAddress(),
            'postalCode' => $customer->getPostalCode(),
            'city' => $customer->getCity(),
            'isActive' => $customer->getAktywny(),
        ];

        return $this->json($data);
    }

    /**
     * Create new customer
     *
     * @Route("/api/customer", name="api_customer_put", methods={"PUT"})
     */
    public function create(Request $request)
    {
        $data = CustomerController::getJsonRequestContentAsArray($request);

        $customer = new Customer();
        $customer->setFirstname($data['firstname']);
        $customer->setLastname($data['lastname']);
        $customer->setEmail($data['email']);
        $customer->setBirthdate(\DateTime::createFromFormat('Y-m-d', $data['birthdate']));
        $customer->setAddress($data['address']);
        $customer->setPostalCode($data['postalCode']);
        $customer->setCity($data['city']);
        $customer->setAktywny($data['isActive']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->flush();

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
        $data = CustomerController::getJsonRequestContentAsArray($request);

        /** @var CustomerRepository $repository */
        $repository = $this->getDoctrine()->getManager()->getRepository(Customer::class);

        $customer = $repository->findOneById($id);

        if(!$customer) {
            throw $this->createNotFoundException();
        }

        $customer->setFirstname($data['firstname']);
        $customer->setLastname($data['lastname']);
        $customer->setEmail($data['email']);
        $customer->setBirthdate(\DateTime::createFromFormat('Y-m-d', $data['birthdate']));
        $customer->setAddress($data['address']);
        $customer->setPostalCode($data['postalCode']);
        $customer->setCity($data['city']);
        $customer->setAktywny($data['isActive']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);

        return $this->json(null, 200);
    }

    public static function getJsonRequestContentAsArray(Request $request) : array
    {
        $content = $request->getContent();

        if(empty($content)){
            throw new BadRequestHttpException();
        } else {
            $params = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new BadRequestHttpException();
            }
        }

        return $params;
    }
}
