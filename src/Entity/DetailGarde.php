<?php

namespace App\Entity;

use App\Repository\DetailGardeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailGardeRepository::class)
 */
class DetailGarde
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_debut;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_fin;

    /**
     * @ORM\OneToOne(targetEntity=Garde::class, mappedBy="detailGarde", cascade={"persist", "remove"})
     */
    private $garde;

//    /**
//     * @ORM\OneToOne(targetEntity=Pharmacie::class, mappedBy="detailGarde", cascade={"persist", "remove"})
//     */
//    private $pharmacie;

    public function __construct()
    {
        $this->date_debut =new \DateTime();
        $this->date_fin =new \DateTime();
        $this->heure_debut =new \DateTime();
        $this->heure_fin =new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getGarde(): ?Garde
    {
        return $this->garde;
    }

    public function setGarde(Garde $garde): self
    {
        // set the owning side of the relation if necessary
        if ($garde->getDetailGarde() !== $this) {
            $garde->setDetailGarde($this);
        }

        $this->garde = $garde;

        return $this;
    }

//    public function getPharmacie(): ?Pharmacie
//    {
//        return $this->pharmacie;
//    }
//
//    public function setPharmacie(Pharmacie $pharmacie): self
//    {
//        // set the owning side of the relation if necessary
//        if ($pharmacie->getDetailGarde() !== $this) {
//            $pharmacie->setDetailGarde($this);
//        }
//
//        $this->pharmacie = $pharmacie;
//
//        return $this;
//    }

    public function __toString()
    {
        return $this->date_debut . ' ' . $this->date_fin;
        // TODO: Implement __toString() method.
    }
}
