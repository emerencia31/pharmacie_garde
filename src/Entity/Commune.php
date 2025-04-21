<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommuneRepository::class)
 */
class Commune
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
    private $nom_com;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="commune")
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Localisation::class, mappedBy="no")
     */
    private $localisation;

    public function __construct()
    {
        $this->localisation = new ArrayCollection();
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

    public function getNomCom(): ?string
    {
        return $this->nom_com;
    }

    public function setNomCom(string $nom_com): self
    {
        $this->nom_com = $nom_com;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

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
            $localisation->setCommune($this);
        }

        return $this;
    }

    public function removeLocalisation(localisation $localisation): self
    {
        if ($this->localisation->removeElement($localisation)) {
            // set the owning side to null (unless already changed)
            if ($localisation->getCommune() === $this) {
                $localisation->setCommune(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom_com;
        // TODO: Implement __toString() method.
    }
}
