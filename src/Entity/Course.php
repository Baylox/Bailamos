<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DanceType $dance = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'courses')]
    private Collection $students;

    #[ORM\Column(length: 10)]
    private ?string $day_of_week = null;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDance(): ?DanceType
    {
        return $this->dance;
    }

    public function setDance(?DanceType $dance): static
    {
        $this->dance = $dance;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? 'N/A'; // Retourne le titre du cours pour EasyAdmin
    }

    /**
     * @return Collection<int, User>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(User $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
        }

        return $this;
    }

    public function removeStudent(User $student): static
    {
        $this->students->removeElement($student);

        return $this;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->day_of_week;
    }

    public function setDayOfWeek(string $day_of_week): static
    {
        $this->day_of_week = $day_of_week;

        return $this;
    }

    public function getDanceImage(): ?string
    {
        // Vérifie si une danse est associée et retourne son image ou une valeur par défaut
        return $this->dance?->getImage() ?? '/images/danse1.jpg';
    }
}
