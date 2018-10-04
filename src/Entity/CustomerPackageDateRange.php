<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Customer;
use App\Entity\DateRange;
use App\Entity\MedicalPackage;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerPackageDateRangeRepository")
 */
class CustomerPackageDateRange
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $customerId;

    /**
     * @ORM\Column(type="integer")
     */
    private $medicalPackageId;

    /**
     * @ORM\Column(type="integer")
     */
    private $dateRangeId;

    /**
     * @var Customer $customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="customerPackageDateRanges", fetch="LAZY")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=false)
     */
    private $customer;

    /**
     * @var DateRange $dateRange
     *
     * @ORM\ManyToOne(targetEntity="DateRange", inversedBy="customerPackageDateRanges", fetch="LAZY")
     * @ORM\JoinColumn(name="date_range_id", referencedColumnName="id", nullable=false)
     */
    private $dateRange;


    /**
     * @var MedicalPackage $medicalPackage
     *
     * @ORM\ManyToOne(targetEntity="MedicalPackage", inversedBy="customerPackageDateRanges", fetch="LAZY")
     * @ORM\JoinColumn(name="medical_package_id", referencedColumnName="id", nullable=false)
     */
    private $medicalPackage;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMedicalPackageId()
    {
        return $this->medicalPackageId;
    }

    /**
     * @param mixed $medicalPackageId
     */
    public function setMedicalPackageId($medicalPackageId): self
    {
        $this->medicalPackageId = $medicalPackageId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateRangeId()
    {
        return $this->dateRangeId;
    }

    /**
     * @param mixed $dateRangeId
     */
    public function setDateRangeId($dateRangeId): self
    {
        $this->dateRangeId = $dateRangeId;

        return $this;
    }

    /**
     * @return \App\Entity\Customer
     */
    public function getCustomer(): \App\Entity\Customer
    {
        return $this->customer;
    }

    /**
     * @param \App\Entity\Customer $customer
     */
    public function setCustomer(\App\Entity\Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return \App\Entity\DateRange
     */
    public function getDateRange(): \App\Entity\DateRange
    {
        return $this->dateRange;
    }

    /**
     * @param \App\Entity\DateRange $dateRange
     */
    public function setDateRange(\App\Entity\DateRange $dateRange): self
    {
        $this->dateRange = $dateRange;

        return $this;
    }

    /**
     * @return \App\Entity\MedicalPackage
     */
    public function getMedicalPackage(): \App\Entity\MedicalPackage
    {
        return $this->medicalPackage;
    }

    /**
     * @param \App\Entity\MedicalPackage $medicalPackage
     */
    public function setMedicalPackage(\App\Entity\MedicalPackage $medicalPackage): self
    {
        $this->medicalPackage = $medicalPackage;

        return $this;
    }

    


}
