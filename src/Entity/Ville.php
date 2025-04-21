<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class Ville
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
    private $nom_ville;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="ville")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\OneToMany(targetEntity=Commune::class, mappedBy="no")
     */
    private $commune;

    public function __construct()
    {
        $this->commune = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNomVille(): ?string
    {
        return $this->nom_ville;
    }

    public function setNomVille(string $nom_ville): self
    {
        $this->nom_ville = $nom_ville;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|commune[]
     */
    public function getCommune(): Collection
    {
        return $this->commune;
    }

    public function addCommune(commune $commune): self
    {
        if (!$this->commune->contains($commune)) {
            $this->commune[] = $commune;
            $commune->setVille($this);
        }

        return $this;
    }

    public function removeCommune(commune $commune): self
    {
        if ($this->commune->removeElement($commune)) {
            // set the owning side to null (unless already changed)
            if ($commune->getVille() === $this) {
                $commune->setVille(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom_ville;
        // TODO: Implement __toString() method.
    }
}
