<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
//permet d'utiliser les expressions régulières pour vérifier les valeurs contenues
//dans les champs de formulaire.
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rue = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $codepostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    //#[Assert\NotBlank]
    //#[Assert\Regex('/^[0-9]{3}[0-9]{4}$/')]
    //https://regex101.com/
    //numéro de téléphone :
    //^0[0-9]{1} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$
    //#[Assert\Regex('/^0[0-9]{1} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/')]
    //^0[0-9]{9}$
    //#[Assert\Regex('/^0[0-9]{9}$/')]

    /*
    //il faut que au moins l'une des expressions correponde à la valeur contenue dans le champ de formulaire
    #[Assert\AtLeastOneOf([
        new Assert\Regex('/^\d-\d{3}-\d{5}-\d$/'),
        new Assert\Regex('/^\d{3}-\d-\d{3}-\d{5}-\d{2}$/'),
    ])]
    
    #[Assert\AtLeastOneOf([
        new Assert\Regex('/^0[0-9]{1} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/'),
        new Assert\Regex('/^0[0-9]{9}$/'),
    ])]
    */
    /*
    #[Assert\Sequentially([
        new Assert\NotNull,
        new Assert\Type('string'),
        new Assert\Length(min: 10),
        //new Assert\Regex(Place::ADDRESS_REGEX),
        //new App\Validation\Geolocalizable,
    ])]
    */

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $tel_fix = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $tel_mobile = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Emprunt $emprunt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     */
    public function getRoles(): array
    {
        /*
        #[Assert\All([
            new Assert\Regex('/^ROLE_[A-Z]+$/')
        ])]
        */
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(?string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelFix(): ?string
    {
        return $this->tel_fix;
    }

    public function setTelFix(?string $tel_fix): self
    {
        $this->tel_fix = $tel_fix;

        return $this;
    }

    public function getTelMobile(): ?string
    {
        return $this->tel_mobile;
    }

    public function setTelMobile(?string $tel_mobile): self
    {
        $this->tel_mobile = $tel_mobile;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getEmprunt(): ?Emprunt
    {
        return $this->emprunt;
    }

    public function setEmprunt(?Emprunt $emprunt): self
    {
        $this->emprunt = $emprunt;

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): self
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setUser($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getUser() === $this) {
                $emprunt->setUser(null);
            }
        }

        return $this;
    }
}
