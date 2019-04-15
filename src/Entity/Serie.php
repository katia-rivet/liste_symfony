<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SerieRepository")
 * @ORM\Table(name="series")
 *
 * Defines the properties of the Post entity to represent the blog posts.
 *
 * See https://symfony.com/doc/current/book/doctrine.html#creating-an-entity-class
 *
 * Tip: if you have an existing database, you can generate these entity class automatically.
 * See https://symfony.com/doc/current/cookbook/doctrine/reverse_engineering.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class Serie
{
    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them under parameters section in config/services.yaml file.
     *
     * See https://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     */
    public const NUM_ITEMS = 20;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $saisons;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $recommandation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $resume;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;





    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getSaisons(): ?int
    {
        return $this->saisons;
    }

    public function setSaisons(int $saisons): void
    {
        $this->saisons = $saisons;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): void
    {
        $this->etat = $etat;
    }

    public function getRecommandation(): ?string
    {
        return $this->recommandation ;
    }

    public function setRecommandation(string $recommandation): void
    {
        $this->recommandation = $recommandation;
    }

    public function getResume(): ?string
    {
        return $this->resume ;
    }

    public function setResume(string $resume): void
    {
        $this->resume = $resume;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }
//
//    public function getComments(): Collection
//    {
//        return $this->comments;
//    }
//
//    public function addComment(Comment $comment): void
//    {
//        $comment->setPost($this);
//        if (!$this->comments->contains($comment)) {
//            $this->comments->add($comment);
//        }
//    }
//
//    public function removeComment(Comment $comment): void
//    {
//        $this->comments->removeElement($comment);
//    }
//
//    public function getSummary(): ?string
//    {
//        return $this->summary;
//    }
//
//    public function setSummary(string $summary): void
//    {
//        $this->summary = $summary;
//    }
//
//    public function addTag(Tag ...$tags): void
//    {
//        foreach ($tags as $tag) {
//            if (!$this->tags->contains($tag)) {
//                $this->tags->add($tag);
//            }
//        }
//    }
//
//    public function removeTag(Tag $tag): void
//    {
//        $this->tags->removeElement($tag);
//    }
//
//    public function getTags(): Collection
//    {
//        return $this->tags;
//    }
}
