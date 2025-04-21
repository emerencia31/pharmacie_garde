<?php

namespace App\Entity;

use App\Repository\GardeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GardeRepository::class)
 */
class Garde
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_garde;

    /**
     * @ORM\OneToOne(targetEntity=DetailGarde::class, inversedBy="garde", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $detailGarde;

    /**
     * @ORM\ManyToOne(targetEntity=Pharmacie::class, inversedBy="gardes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pharmacie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNomGarde(): ?string
    {
        return $this->nom_garde;
    }

    public function setNomGarde(string $nom_garde): self
    {
        $this->nom_garde = $nom_garde;

        return $this;
    }

    public function getDetailGarde(): ?DetailGarde
    {
        return $this->detailGarde;
    }

    public function setDetailGarde(DetailGarde $detailGarde): self
    {
        $this->detailGarde = $detailGarde;

        return $this;
    }

    public function getPharmacie(): ?Pharmacie
    {
        return $this->pharmacie;
    }

    public function setPharmacie(?Pharmacie $pharmacie): self
    {
        $this->pharmacie = $pharmacie;

        return $this;
    }

}
