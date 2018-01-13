<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @UniqueEntity(fields={"name"}, message="This category already exists")
 */
class Category implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")     *
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Book", mappedBy="category", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $books;


    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param Book $book
     *
     * @return Category
     */
    public function addBook(Book $book)
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }

        return $this;
    }

    /**
     * @param Book $book
     *
     * @return Category
     */
    public function removeBook(Book $book)
    {
        if (!$this->books->contains($book)) {
            $this->books->remove($book);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}

