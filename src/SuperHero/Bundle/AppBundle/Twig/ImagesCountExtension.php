<?php

namespace SuperHero\Bundle\AppBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

class ImagesCountExtension extends \Twig_Extension
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

  
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('imagesCount', array($this, 'imagesCount')),
        );
    }

    public function imagesCount($superheroId)
    {
        $query = $this->doctrine->getManager()
            ->createQuery('
            SELECT
                count(i.id) as total FROM AppBundle:Image i
            JOIN
                i.superhero s
            WHERE
                s.id = :id');
        $query->setParameter('id', $superheroId);

        return $query->getSingleScalarResult();
    }

    public function getName()
    {
        return 'images_count.extension';
    }
}