<?php

namespace App\Entity;

use App\Repository\ResponsableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponsableRepository::class)
 */
class Responsable
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\ManyToMany(targetEntity=Pharmacie::class, mappedBy="responsable")
     */
    private $pharmacies;

    /**
     * @ORM\OneToOne(targetEntity=DetailRespo::class, inversedBy="responsable", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $detailRespo;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="responsable")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->pharmacies = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection|Pharmacie[]
     */
    public function getPharmacies(): Collection
    {
        return $this->pharmacies;
    }

    public function addPharmacy(Pharmacie $pharmacy): self
    {
        if (!$this->pharmacies->contains($pharmacy)) {
            $this->pharmacies[] = $pharmacy;
            $pharmacy->addResponsable($this);
        }

        return $this;
    }

    public function removePharmacy(Pharmacie $pharmacy): self
    {
        if ($this->pharmacies->removeElement($pharmacy)) {
            $pharmacy->removeResponsable($this);
        }

        return $this;
    }

    public function getDetailRespo(): ?detailRespo
    {
        return $this->detailRespo;
    }

    public function setDetailRespo(detailRespo $detailRespo): self
    {
        $this->detailRespo = $detailRespo;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom() . ' ' . $this->getPrenom();
        // TODO: Implement __toString() method.
    }
}
