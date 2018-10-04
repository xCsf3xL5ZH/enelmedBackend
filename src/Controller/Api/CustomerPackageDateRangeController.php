<?php

namespace App\Controller\Api;

use App\Entity\Customer;
use App\Entity\CustomerPackageDateRange;
use App\Entity\DateRange;
use App\Repository\CustomerPackageDateRangeRepository;
use App\Repository\CustomerRepository;
use App\Repository\DateRangeRepository;
use App\Repository\MedicalPackageRepository;
use App\Service\JsonRequestToArrayConventer;
use App\Service\ObjectSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use ReflectionClass;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CustomerPackageDateRangeController extends AbstractController
{

    /**
     * @var CustomerRepository $customerRepository
     */
    private $customerRepository;

    /**
     * @var MedicalPackageRepository $medicalPackageRepository
     */
    private $medicalPackageRepository;

    /**
     * @var DateRangeRepository $dateRangeRepository
     */
    private $dateRangeRepository;

    /**
     * @var CustomerPackageDateRangeRepository $customerPackageDateRangeRepository
     */
    private $customerPackageDateRangeRepository;

    /**
     * @var ObjectSerializer $objectSerializer
     */
    private $objectSerializer;

    /**
     * @var JsonRequestToArrayConventer $jsonRequestToArrayConventer
     */
    private $jsonRequestToArrayConventer;

    /**
     *
     */
    const _CUSTOMER_MAPPING_ =  array('firstname', 'lastname', 'email',
        'birthdate', 'address', 'postalCode', 'city');


    const _MEDICAL_PACKAGE_MAPPING_ = array('name');

    const _DATE_DATE_MAPPING = array('dateStart', 'dateEnd');

    /**
     * CustomerPackageDateRangeController constructor.
     * @param CustomerRepository $customerRepository
     * @param MedicalPackageRepository $medicalPackageRepository
     * @param DateRangeRepository $dateRangeRepository
     * @param CustomerPackageDateRangeRepository $customerPackageDateRangeRepository
     * @param ObjectSerializer $objectSerializer
     * @param JsonRequestToArrayConventer $jsonRequestToArrayConventer
     */
    public function __construct(CustomerRepository $customerRepository, MedicalPackageRepository $medicalPackageRepository, DateRangeRepository $dateRangeRepository, CustomerPackageDateRangeRepository $customerPackageDateRangeRepository, ObjectSerializer $objectSerializer, JsonRequestToArrayConventer $jsonRequestToArrayConventer)
    {
        $this->customerRepository = $customerRepository;
        $this->medicalPackageRepository = $medicalPackageRepository;
        $this->dateRangeRepository = $dateRangeRepository;
        $this->customerPackageDateRangeRepository = $customerPackageDateRangeRepository;
        $this->objectSerializer = $objectSerializer;
        $this->jsonRequestToArrayConventer = $jsonRequestToArrayConventer;
    }


    /**
     * @Route("/api/medicalpackagetocustomeradd", name="medical_package_to_customer_add", methods={"PUT"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(Request $request)
    {

        $data = $this->jsonRequestToArrayConventer->getJsonRequestContentAsArray($request);

        $dateEnd = (\DateTime::createFromFormat('Y-m-d', $data['dateEnd']));

        $dateStart = (\DateTime::createFromFormat('Y-m-d', $data['dateStart']));

        if (false === ($dateEnd && $dateStart) || 1 === $dateStart->diff($dateEnd)->{'invert'}) {
            return $this->json([
                'message' => 'wrong dates!',
            ]);
        };

        $customer = $this->customerRepository->findOneBy(array('id' => $data['customerId']));

        $medicalPackage = $this->medicalPackageRepository->findOneBy(array('id' => $data['medicalPackageId']));

        if (false === $customer || false === $medicalPackage) {
            return $this->json([
                'message' => 'Wrong data!',
            ]);
        }

        $dateRange = new DateRange();

        $dateRange->setDateEnd($dateEnd)->setDateStart($dateEnd);

        $this->dateRangeRepository->save($dateRange);

        $customerPackageDateRange = new CustomerPackageDateRange();

        $customerPackageDateRange->setCustomer($customer)
            ->setMedicalPackage($medicalPackage)
            ->setDateRange($dateRange);

        $this->customerPackageDateRangeRepository->save($customerPackageDateRange);


        return $this->json([
            'message' => 'success!',
        ]);
    }

    /**
     * Returns a serialized joined object of a CustomerPackageDateRange by Customer object
     *
     * @Route("/api/customer/{id}/packages", name="api_customer_get_with_packages", requirements={"id": "\d+"}, methods={"GET"})
     * @ParamConverter("customer")
     *
     * @param Customer $customer
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getByUser(Customer $customer)
    {
        $data = array();

        $customerSerialized = $this->objectSerializer->serialize($customer, self::_CUSTOMER_MAPPING_);

        $data[$customer->getId()] = $customerSerialized;

        if (!isset($data[$customer->getId()]['medicalPakages'])) {
            $data[$customer->getId()]['medicalPakages'] = array();
        }

        $test = $customer->getCustomerPackageDateRanges();

        foreach ($customer->getCustomerPackageDateRanges() as $cpdr) {

            $medicalPakage = $this->objectSerializer->serialize($cpdr->getMedicalPackage(), self::_MEDICAL_PACKAGE_MAPPING_);

            $dateRange = $this->objectSerializer->serialize($cpdr->getDateRange(), self::_DATE_DATE_MAPPING);

            $data[$customer->getId()]['medicalPakages'][] =
                array('medicalPakage' => $medicalPakage,'dateRange' => $dateRange);
        }

        return $this->json($data);

    }
}
