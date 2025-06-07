<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $UpdatedAt = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'team')]
    private Collection $userId;

    /**
     * @var Collection<int, Toolbox>
     */
    #[ORM\ManyToMany(targetEntity: Toolbox::class, mappedBy: 'teamId')]
    private Collection $toolboxes;

    public function __construct()
    {
        $this->CreatedAt = new \DateTimeImmutable();
        $this->UpdatedAt = new \DateTimeImmutable();
        $this->userId = new ArrayCollection();
        $this->toolboxes = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
            $userId->setTeam($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        if ($this->userId->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getTeam() === $this) {
                $userId->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Toolbox>
     */
    public function getToolboxes(): Collection
    {
        return $this->toolboxes;
    }

    public function addToolbox(Toolbox $toolbox): static
    {
        if (!$this->toolboxes->contains($toolbox)) {
            $this->toolboxes->add($toolbox);
            $toolbox->addTeamId($this);
        }

        return $this;
    }

    public function removeToolbox(Toolbox $toolbox): static
    {
        if ($this->toolboxes->removeElement($toolbox)) {
            $toolbox->removeTeamId($this);
        }

        return $this;
    }
}
