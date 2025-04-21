<?php

namespace App\Entity;

use App\Repository\DetailRespoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailRespoRepository::class)
 */
class DetailRespo
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
     * @ORM\Column(type="string", length=255)
     */
    private $clause;


    /**
     * @ORM\OneToOne(targetEntity=Responsable::class, mappedBy="detailRespo", cascade={"persist", "remove"})
     */
    private $responsable;

    public function __construct()
    {
        $this->date_debut =new \DateTime();
        $this->date_fin =new \DateTime();
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

    public function getClause(): ?string
    {
        return $this->clause;
    }

    public function setClause(string $clause): self
    {
        $this->clause = $clause;

        return $this;
    }


    public function getResponsable(): ?Responsable
    {
        return $this->responsable;
    }

    public function setResponsable(Responsable $responsable): self
    {
        // set the owning side of the relation if necessary
        if ($responsable->getDetailRespo() !== $this) {
            $responsable->setDetailRespo($this);
        }

        $this->responsable = $responsable;

        return $this;
    }
}
