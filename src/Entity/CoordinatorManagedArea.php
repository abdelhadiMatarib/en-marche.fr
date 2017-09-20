<?php

namespace AppBundle\Entity;

use Algolia\AlgoliaSearchBundle\Mapping\Annotation as Algolia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="coordinator_managed_areas")
 * @ORM\Entity
 *
 * @Algolia\Index(autoIndex=false)
 */
class CoordinatorManagedArea
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Adherent", inversedBy="coordinatorManagedArea")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $adherent;

    /**
     * The codes of the managed zones.
     *
     * @var array
     *
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $codes;

    public function getId()
    {
        return $this->id;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(Adherent $adherent = null)
    {
        $this->adherent = $adherent;
    }

    public function getCodes(): array
    {
        return $this->codes;
    }

    public function setCodes(array $codes)
    {
        $this->codes = $codes;
    }

    public function getCodesAsString(): string
    {
        return implode(', ', $this->codes);
    }

    public function setCodesAsString(?string $codes)
    {
        $this->codes = $codes ? array_map('trim', explode(',', $codes)) : [];
    }
}
