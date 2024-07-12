<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
class Professeur extends User
{
    

    // #[Assert\NotBlank]
    #[ORM\Column(length: 20)]
    private ?string $grade = null;

    // #[Assert\NotBlank]
    #[ORM\ManyToMany(targetEntity: Module::class, inversedBy: 'professeurs')]
    private Collection $modules;

    // #[Assert\NotBlank]
    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'professeurs')]
    private Collection $classes;

    public function __construct()
    {
        $this->setRoles(["ROLE_PROFESSEUR"]);
        $this->modules = new ArrayCollection();
        $this->classes = new ArrayCollection();
    }

   

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): static
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
        }

        return $this;
    }

    public function removeModule(Module $module): static
    {
        $this->modules->removeElement($module);

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
        }

        return $this;
    }

    public function removeClass(Classe $class): static
    {
        $this->classes->removeElement($class);

        return $this;
    }

    function __toString(): string{
        return $this->getNomComplet();
    }
}
