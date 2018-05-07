<?php

namespace SuperHero\Bundle\AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ImageSuperheroAdmin extends AbstractAdmin
{
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('path', null, array('label' => 'Image','template' => 'AppBundle:Default:list.avatar.twig'))
        ;
    }

    protected function configureListFields(ListMapper $mapper)
    {
        $mapper
            ->addIdentifier('id')
            ->add('path', null, array('label' => 'Image','template' => 'AppBundle:Default:list.avatar.twig'))
        ;
    }

    protected function configureFormFields(FormMapper $mapper)
    {
        $options = array();
        $subject = $this->getSubject();
        if ($subject) {
            $imageInfo = $subject->getUploadRootDir();
            if($imageInfo)
                $options['help'] = ' <img src="'.$imageInfo.'" />';
        }

        $mapper
            ->add('file', 'file', $options)
        ;
    }
}