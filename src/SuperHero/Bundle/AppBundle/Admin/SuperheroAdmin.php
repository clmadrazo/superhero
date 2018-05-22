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
    private $twig;

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    );

    public function __construct($code, $class, $baseControllerName, $twig)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->twig = $twig;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $subject = $this->getSubject();
        $showMapper
            ->add('nickname')
            ->add('realName')
            ->add('originDescription')
            ->add('superpowers')
            ->add('catchPhrase')
            ->add('images',  'string', array('template' => $this->twig->render('AppBundle:Superhero:list.superhero.images.twig', array('label' => 'Images Superhero', 'id' => $subject->getId()))))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Superhero')
                ->with('Superhero')
                    ->add('nickname', TextType::class, array("required" => "true"))
                    ->add('realName', TextType::class, array("required" => "true"))
                    ->add('originDescription', TextareaType::class, array("label" => "Original Description", "required" => "true"))
                    ->add('superpowers', TextareaType::class, array("required" => "true"))
                    ->add('catchPhrase', TextareaType::class, array("label" => "Catch Phrase", "required" => "true"))
                ->end()
            ->end()
            ->tab('Images Superhero')
                ->with('Images')
                    ->add('images', 'sonata_type_collection', array(
                        'required' => false,
                        'by_reference' => true,
                        'label' => 'Images Superhero',
                        'constraints' => new \Symfony\Component\Validator\Constraints\Valid(),
                    ), array(
                        'edit' => 'inline',
                        'inline' => 'standard',
                        'sortable' => 'position',
                    ))
                ->end()
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nickname')
            ->add('images', null, array('template' => 'AppBundle:Superhero:list.superhero.images.twig'))
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
        $superhero->setImages($superhero->getImages());
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'AppBundle:App:edit.html.twig';
            default:
                return parent::getTemplate($name);
        }
    }
}