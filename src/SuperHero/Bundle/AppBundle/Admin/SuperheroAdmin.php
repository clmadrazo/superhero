<?php

namespace SuperHero\Bundle\AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SuperheroAdmin extends AbstractAdmin
{
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    );

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $subject = $this->getSubject();
        $showMapper
            ->add('nickname')
            ->add('realName')
            ->add('originDescription')
            ->add('superpowers')
            ->add('catchPhrase')
            ->add('images')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nickname', TextType::class, array("required" => "true"))
            ->add('realName', TextType::class, array("required" => "true"))
            ->add('originDescription', TextareaType::class, array("label" => "Original Description", "required" => "true"))
            ->add('superpowers', TextareaType::class, array("required" => "true"))
            ->add('catchPhrase', TextareaType::class, array("label" => "Catch Phrase", "required" => "true"))
            ->add('images', 'sonata_type_collection', array(
                'required' => false,
                'label' => 'Images',
                'by_reference' => true
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                )
            )
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nickname')
            ->add('images')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array()
                )
            ))
        ;
    }

    public function prePersist($superhero)
    {
        $this->preUpdate($superhero);
    }

    public function preUpdate($superhero)
    {
        $images = $superhero->getImages();
        foreach ($images as $image) {
            $image->setSuperhero($superhero);
        }
    }
}