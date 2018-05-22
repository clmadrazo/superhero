<?php

namespace SuperHero\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use SuperHero\Bundle\AppBundle\Entity\Superhero;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="SuperHero\Bundle\AppBundle\Repository\ImageSuperheroRepository")
 */
class Image
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Assert\Image(maxSize="6000000")
     */
    protected $file;
    
    /**
     *  @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $image;

    protected $imagePath;

    private $temp;
    
    /**
     * @ORM\ManyToOne(targetEntity="SuperHero\Bundle\AppBundle\Entity\Superhero", inversedBy="images")
     */
    protected $superhero;

    public function getId()
    {
        return $this->id;
    }
    
    public function getFile()
    {
        return $this->file;
    }
    
    public function setFile($file)
    {
        $this->file = $file;
        if (null !== $this->file) {
            $image = sha1(uniqid(mt_rand(), true));
            $this->image = $image.'.'.$this->file->guessExtension();
        }
    }
    
    public function getImage()
    {
        return $this->image;
    }
    
    public function setImage($image)
    {
        $this->image = $image;
    }
    
    public function getImagePath()
    {
        return $this->imagePath;
    }
    
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preFileUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->image = $filename.'.'.$this->file->guessExtension();
        }
    }

    public function storeFilenameForRemove()
    {
        $this->temp = $this->getWebPathImage();
    }

    public function getWebPathImage()
    {
        return null === $this->image
            ? null
            : $this->getUploadDir().$this->image;
    }

    public function getUploadDir()
    {
        return '/uploads/superhero/';
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function setSuperhero(Superhero $superhero)
    {
        $this->superhero = $superhero;
        return $this;
    }

    public function getSuperhero()
    {
        return $this->superhero;
    }
}