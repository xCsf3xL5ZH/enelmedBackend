<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DateRangeRepository")
 */
class DateRange
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    /**
     * @var CustomerPackageDateRange $customerPackageDateRange
     *
     * @ORM\OneToMany(targetEntity="CustomerPackageDateRange", mappedBy="dateRange")
     */
    private $customerPackageDateRanges;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

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
