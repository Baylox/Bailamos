<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cet email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 80)]
    private ?string $lastName = null;

    /**
     * @var Collection<int, Course>
     */
    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'students')]
    private Collection $courses;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isTeacher = false;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // Ajoute automatiquement ROLE_TEACHER si isTeacher est vrai
        if ($this->isTeacher && !in_array('ROLE_TEACHER', $roles)) {
            $roles[] = 'ROLE_TEACHER';
        }

        // Ajoute toujours ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        // Synchronise isTeacher avec les rôles
        $this->isTeacher = in_array('ROLE_TEACHER', $roles);

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->addStudent($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            $course->removeStudent($this);
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isTeacher(): bool
    {
        return $this->isTeacher;
    }

    // Permet de définir si l'utilisateur est un enseignant
    public function setIsTeacher(bool $isTeacher): static
    {
        $this->isTeacher = $isTeacher;

        // Synchronise le rôle ROLE_TEACHER avec isTeacher
        if ($isTeacher && !in_array('ROLE_TEACHER', $this->roles)) {
            $this->roles[] = 'ROLE_TEACHER';
        } elseif (!$isTeacher) {
            $this->roles = array_filter($this->roles, fn($role) => $role !== 'ROLE_TEACHER');
        }

        return $this;
    }

    // Valide que l'utilisateur a le rôle ROLE_TEACHER si isTeacher est vrai
    #[Assert\Callback]
    public function validateTeacherStatus(ExecutionContextInterface $context): void
    {
        if ($this->isTeacher && !in_array('ROLE_TEACHER', $this->roles)) {
            $context->buildViolation('Un enseignant doit avoir le rôle ROLE_TEACHER.')
                ->atPath('roles')
                ->addViolation();
        }

        if (!$this->isTeacher && in_array('ROLE_TEACHER', $this->roles)) {
            $context->buildViolation('Un utilisateur avec le rôle ROLE_TEACHER doit être marqué comme enseignant.')
                ->atPath('isTeacher')
                ->addViolation();
        }
    }

    // Retourne le rôle le plus élevé de l'utilisateur
    public function getHighestRole(): string
    {

    $rolesHierarchy = [
        'ROLE_ADMIN' => 1,
        'ROLE_TEACHER' => 2,
        'ROLE_STUDENT' => 3,
        'ROLE_USER' => 4,
    ];

    $roleLabels = [
        'ROLE_ADMIN' => 'Administrateur',
        'ROLE_TEACHER' => 'Professeur',
        'ROLE_STUDENT' => 'Étudiant',
        'ROLE_USER' => 'Utilisateur',
    ];

    $highestRole = 'ROLE_USER'; // On part du plus bas rôle pour incrémenter par la suite

    foreach ($this->getRoles() as $role) {
        if (isset($rolesHierarchy[$role]) && $rolesHierarchy[$role] < $rolesHierarchy[$highestRole]) {
            $highestRole = $role;
        }
    }
    
    // Retourne le label du rôle le plus élevé ou le rôle lui-même s'il n'y a pas de label
    return $roleLabels[$highestRole] ?? $highestRole;
    }
}

