<?php

namespace SuperHero\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="superhero")
 * @ORM\Entity(repositoryClass="SuperHero\Bundle\AppBundle\Repository\SuperheroRepository")
 */
class Superhero
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank()
     */
    private $nickname;

    /**
     * @ORM\Column(name="real_name", type="string", length=40)
     * @Assert\NotBlank()
     */
    private $realName;

    /**
     * @ORM\Column(name="origin_description", type="text")
     * @Assert\NotBlank()
     */
    private $originDescription;

    /**
     * @ORM\Column(name="superpowers", type="text")
     * @Assert\NotBlank()
     */
    private $superpowers;

    /**
     * @ORM\Column(name="catch_phrase", type="text")
     * @Assert\NotBlank()
     */
    private $catchPhrase;

    /**
     * @ORM\OneToMany(targetEntity="SuperHero\Bundle\AppBundle\Entity\Image", mappedBy="superhero", cascade={"persist","remove", "detach"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setRealName($realName)
    {
        $this->realName = $realName;

        return $this;
    }

    public function getRealName()
    {
        return $this->realName;
    }

    public function setOriginDescription($originDescription)
    {
        $this->originDescription = $originDescription;

        return $this;
    }

    public function getOriginDescription()
    {
        return $this->originDescription;
    }

    public function setSuperpowers($superpowers)
    {
        $this->superpowers = $superpowers;

        return $this;
    }

    public function getSuperpowers()
    {
        return $this->superpowers;
    }

    public function setCatchPhrase($catchPhrase)
    {
        $this->catchPhrase = $catchPhrase;

        return $this;
    }

    public function getCatchPhrase()
    {
        return $this->catchPhrase;
    }

    public function setImages($images)
    {
        if (count($images) > 0) {
            foreach ($images as $i) {
                $this->addImage($i);
            }
        }
        return $this;
    }

    public function addImage(Image $image)
    {
        $image->setSuperhero($this);
        $this->images->add($image);
        return $this;
    }

    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    public function getImages()
    {
        return $this->images;
    }
}
