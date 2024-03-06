<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/users/{id}', 
            requirements: ['id' => '\d+'],
            normalizationContext: ['groups' => 'user:item']),
        new GetCollection(
            uriTemplate: '/users',
            normalizationContext: ['groups' => 'user:list']),
    ],
    order: ['nom' => 'ASC', 'prenom'=> 'ASC'],
    paginationEnabled: false
)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api','user:item','user:list','article:item','article:list' ])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['api','user:item','user:list','article:item','article:list' ])]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Groups(['api','user:item','user:list','article:item','article:list' ])]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotCompromisedPassword(
       message: 'Votre mot de passe à été leake dans une fuite de données, 
       Veuillez choisir un autre mot de passe.'
    )]
    #[Assert\Regex(
        pattern:'/(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{12,}/',
        match:true,
        message:'Le mot de passe doit contenir des min, maj et des nombres',)]
    private ?string $password = null;

    #[ORM\Column(length: 200)]
    #[Groups(['api','user:item','user:list','article:item','article:list' ])]
    private ?string $urlImg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getUrlImg(): ?string
    {
        return $this->urlImg;
    }

    public function setUrlImg(string $urlImg): static
    {
        $this->urlImg = $urlImg;

        return $this;
    }

    public function __toString() : string 
    {
        return $this->prenom . " " . $this->nom;
    }
}
