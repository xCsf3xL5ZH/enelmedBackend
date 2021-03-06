<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicalPackageRepository")
 */
class MedicalPackage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @var CustomerPackageDateRange $customerPackageDateRange
     *
     * @ORM\OneToMany(targetEntity="CustomerPackageDateRange", mappedBy="medicalPackage")
     */
    private $customerPackageDateRanges;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->customerPackageDateRanges = new PersistentCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getCustomerPackageDateRanges(): PersistentCollection
    {
        return $this->customerPackageDateRanges;
    }

    /**
     * @param PersistentCollection $customerPackageDateRanges
     */
    public function setCustomerPackageDateRanges(PersistentCollection $customerPackageDateRanges): void
    {
        $this->customerPackageDateRanges = $customerPackageDateRanges;
    }


}
