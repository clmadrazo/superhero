<?php

namespace SuperHero\Bundle\AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ImageAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $mapper)
    {
        $options = array('required' => true, 'label' => 'Image');
        if (($subject = $this->getSubject()) && $subject->getWebPathImage()) {
            $imageInfo = $subject->getWebPathImage();
            $options['help'] = '<img src="'.$imageInfo.'" />';
        }

        $mapper
            ->add('file', 'file', $options)
        ;
    }
}