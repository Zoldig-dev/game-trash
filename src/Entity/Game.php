<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $launchAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $notGlobal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pathImg;

    /**
     * @ORM\OneToOne(targetEntity=Forum::class, mappedBy="game", cascade={"persist", "remove"})
     */
    private $forum;

    /**
     * @ORM\ManyToMany(targetEntity=GameCategory::class, inversedBy="games")
     */
    private $gameCategory;

    /**
     * @ORM\ManyToMany(targetEntity=Device::class, inversedBy="games")
     */
    private $devices;

    public function __construct()
    {
        $this->gameCategory = new ArrayCollection();
        $this->devices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLaunchAt(): ?\DateTimeInterface
    {
        return $this->launchAt;
    }

    public function setLaunchAt(\DateTimeInterface $launchAt): self
    {
        $this->launchAt = $launchAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNotGlobal(): ?int
    {
        return $this->notGlobal;
    }

    public function setNotGlobal(?int $notGlobal): self
    {
        $this->notGlobal = $notGlobal;

        return $this;
    }

    public function getPathImg(): ?string
    {
        return $this->pathImg;
    }

    public function setPathImg(string $pathImg): self
    {
        $this->pathImg = $pathImg;

        return $this;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(Forum $forum): self
    {
        // set the owning side of the relation if necessary
        if ($forum->getGame() !== $this) {
            $forum->setGame($this);
        }

        $this->forum = $forum;

        return $this;
    }

    /**
     * @return Collection|GameCategory[]
     */
    public function getGameCategory(): Collection
    {
        return $this->gameCategory;
    }

    public function addGameCategory(GameCategory $gameCategory): self
    {
        if (!$this->gameCategory->contains($gameCategory)) {
            $this->gameCategory[] = $gameCategory;
        }

        return $this;
    }

    public function removeGameCategory(GameCategory $gameCategory): self
    {
        $this->gameCategory->removeElement($gameCategory);

        return $this;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        $this->devices->removeElement($device);

        return $this;
    }
}
