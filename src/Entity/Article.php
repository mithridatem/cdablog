<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/articles/{id}', 
            requirements: ['id' => '\d+'],
            normalizationContext: ['groups' => 'article:item']),
        new GetCollection(
            uriTemplate: '/articles',
            normalizationContext: ['groups' => 'article:list']),
    ],
    order: ['id' => 'ASC', 'titre' => 'ASC'],
    paginationEnabled: true
)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['article:list','article:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['article:list','article:item'])]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['article:item','article:list'])]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne]
    #[Groups(['article:item','article:list'])]
    private ?Utilisateur $utilisateur = null;
    
    #[ORM\ManyToMany(targetEntity: Categorie::class)]
    #[Groups(['article:item','article:list'])]
    private Collection $categories;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['article:item','article:list'])]
    private ?string $contenu = null;

    #[ORM\Column(length: 200)]
 
    private ?string $urlImg = null;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }


    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

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
}
