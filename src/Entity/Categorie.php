<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/category/{id}', 
            requirements: ['id' => '\d+'],
            normalizationContext: ['groups' => 'category:item']),
        new GetCollection(
            uriTemplate: '/category',
            normalizationContext: ['groups' => 'category:list']),
        new Post(
            uriTemplate: '/category'
        ),
        new Delete(
            uriTemplate: '/category/{id}', 
            requirements: ['id' => '\d+'],
        )  
    ],
    order: ['id' => 'ASC', 'nom' => 'ASC'],
    paginationEnabled: false
)]

class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api', 'admin', 'category:item','category:list','article:item','article:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['api', 'admin', 'category:item','category:list','article:item','article:list'])]
    private ?string $nom = null;

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

    public function __toString() : string 
    {
        return $this->nom;
    }
}
