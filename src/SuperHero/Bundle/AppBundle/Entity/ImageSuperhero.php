<?php

namespace SuperHero\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="SuperHero\Bundle\AppBundle\Repository\ImageSuperheroRepository")
 */
class ImageSuperhero extends ImageBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="SuperHero\Bundle\AppBundle\Entity\Superhero", inversedBy="images")
     * @ORM\JoinColumn(name="superhero_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $superhero;

    public function getId()
    {
        return $this->id;
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

    public function __construct()
    {
        parent::__construct();
    }

    public function getUploadDir()
    {
        return;
        //return 'uploads/superhero/'.$this->getSuperhero()->getId() . '/';
    }

    function getUploadRootDir()
    {
        return __DIR__.'/../../../../../public/'.$this->getUploadDir();
    }
}
