<?php

namespace App\Entity;

use App\Repository\SocietyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocietyRepository::class)
 */
class Society
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
    private $name;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ligne1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ligne2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ligne3;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getLigne1(): ?string
    {
        return $this->ligne1;
    }

    public function setLigne1(string $ligne1): self
    {
        $this->ligne1 = $ligne1;

        return $this;
    }

    public function getLigne2(): ?string
    {
        return $this->ligne2;
    }

    public function setLigne2(?string $ligne2): self
    {
        $this->ligne2 = $ligne2;

        return $this;
    }

    public function getLigne3(): ?string
    {
        return $this->ligne3;
    }

    public function setLigne3(?string $ligne3): self
    {
        $this->ligne3 = $ligne3;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}
