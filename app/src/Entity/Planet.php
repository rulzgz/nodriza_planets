<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PlanetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PlanetRepository::class)]
class Planet
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $rotation_period = null;

    #[ORM\Column(nullable: true)]
    private ?int $orbital_period = null;

    #[ORM\Column(nullable: true)]
    private ?int $diameter = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRotationPeriod(): ?int
    {
        return $this->rotation_period;
    }

    public function setRotationPeriod(?int $rotation_period): self
    {
        $this->rotation_period = $rotation_period;

        return $this;
    }

    public function getOrbitalPeriod(): ?int
    {
        return $this->orbital_period;
    }

    public function setOrbitalPeriod(?int $orbital_period): self
    {
        $this->orbital_period = $orbital_period;

        return $this;
    }

    public function getDiameter(): ?int
    {
        return $this->diameter;
    }

    public function setDiameter(?int $diameter): self
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank(['groups'  => ['validateRequired']]));
        $metadata->addPropertyConstraint('name', new Assert\NotBlank(['groups'  => ['validateRequired']]));

        $metadata->addPropertyConstraint('id', new Assert\Positive(['groups' => ['validateType']]));
        $metadata->addPropertyConstraint('rotation_period', new Assert\Positive(['groups' => ['validateType']]));
        $metadata->addPropertyConstraint('orbital_period', new Assert\Positive(['groups' => ['validateType']]));
        $metadata->addPropertyConstraint('diameter', new Assert\Positive(['groups' => ['validateType']]));

        $metadata->addConstraint(new UniqueEntity([
            'fields' => 'id',
            'groups' => ['validateUnique']
        ]));

        $metadata->setGroupSequence(['Planet', 'validateRequired', 'validateType', 'validateUnique']);
    }
}
