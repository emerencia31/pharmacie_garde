<?php

namespace App\Entity;

use App\Repository\PharmacieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PharmacieRepository::class)
 */
class Pharmacie
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
    private $nom_pharma;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;


    /**
     * @ORM\ManyToMany(targetEntity=Responsable::class, inversedBy="pharmacies")
     */
    private $responsables;

    /**
     * @ORM\OneToMany(targetEntity=Localisation::class, mappedBy="pharmacie", orphanRemoval=true)
     */
    private $localisation;

    /**
     * @ORM\OneToMany(targetEntity=Garde::class, mappedBy="pharmacie", orphanRemoval=true)
     */
    private $gardes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;


    public function __construct()
    {
        $this->responsables = new ArrayCollection();
        $this->localisation = new ArrayCollection();
        $this->gardes = new ArrayCollection();
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

    public function getNomPharma(): ?string
    {
        return $this->nom_pharma;
    }

    public function setNomPharma(string $nom_pharma): self
    {
        $this->nom_pharma = $nom_pharma;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|Responsable[]
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Responsable $responsable): self
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables[] = $responsable;
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): self
    {
        $this->responsables->removeElement($responsable);

        return $this;
    }

    /**
     * @return Collection|localisation[]
     */
    public function getLocalisation(): Collection
    {
        return $this->localisation;
    }

    public function addLocalisation(localisation $localisation): self
    {
        if (!$this->localisation->contains($localisation)) {
            $this->localisation[] = $localisation;
            $localisation->setPharmacie($this);
        }

        return $this;
    }

    public function removeLocalisation(localisation $localisation): self
    {
        if ($this->localisation->removeElement($localisation)) {
            // set the owning side to null (unless already changed)
            if ($localisation->getPharmacie() === $this) {
                $localisation->setPharmacie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Garde[]
     */
    public function getGardes(): Collection
    {
        return $this->gardes;
    }

    public function addGarde(Garde $garde): self
    {
        if (!$this->gardes->contains($garde)) {
            $this->gardes[] = $garde;
            $garde->setPharmacie($this);
        }

        return $this;
    }

    public function removeGarde(Garde $garde): self
    {
        if ($this->gardes->removeElement($garde)) {
            // set the owning side to null (unless already changed)
            if ($garde->getPharmacie() === $this) {
                $garde->setPharmacie(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function __toString()
    {
        return $this->getNomPharma();
        // TODO: Implement __toString() method.
    }
}
