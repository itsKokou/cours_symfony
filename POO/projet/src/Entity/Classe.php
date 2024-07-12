<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 20)]
    // #[Assert\NotBlank]
    // #[Assert\Unique]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?bool $isArchived = false;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Filiere $filiere = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveau $niveau = null;

    #[ORM\ManyToMany(targetEntity: Professeur::class, mappedBy: 'classes')]
    private Collection $professeurs;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Inscription::class)]
    private Collection $inscriptions;

    public function __construct()
    {
        $this->professeurs = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function isIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): static
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): static
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection<int, Professeur>
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): static
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs->add($professeur);
            $professeur->addClass($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): static
    {
        if ($this->professeurs->removeElement($professeur)) {
            $professeur->removeClass($this);
        }

        return $this;
    }
    
//     function __toString(): string{
//         return $this->getLibelle();
//     }

/**
 * @return Collection<int, Inscription>
 */
public function getInscriptions(): Collection
{
    return $this->inscriptions;
}

public function addInscription(Inscription $inscription): static
{
    if (!$this->inscriptions->contains($inscription)) {
        $this->inscriptions->add($inscription);
        $inscription->setClasse($this);
    }

    return $this;
}

public function removeInscription(Inscription $inscription): static
{
    if ($this->inscriptions->removeElement($inscription)) {
        // set the owning side to null (unless already changed)
        if ($inscription->getClasse() === $this) {
            $inscription->setClasse(null);
        }
    }

    return $this;
}
}
