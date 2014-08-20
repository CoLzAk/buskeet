<?php

namespace Colzak\GeoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Colzak\GeoBundle\Document\PublicPlace;
use Colzak\GeoBundle\Form\Type\PublicPlaceCoordinatesFormType;

class PublicPlaceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Description'))
            ->add('streetNumber', 'hidden', array('label' => 'N°'))
            ->add('route', 'hidden', array('label' => 'Nom de la voie'))
            ->add('locality', 'hidden', array('label' => 'Ville'))
            ->add('subLocality', 'hidden', array('label' => 'Arrondissement', 'required' => false))
            ->add('postalCode', 'hidden', array('label' => 'Code Postal', 'required' => false))
            ->add('administrativeAreaLevel1', 'hidden', array('label' => 'Département', 'required' => false))
            ->add('administrativeAreaLevel2', 'hidden', array('label' => 'Région', 'required' => false))
            ->add('country', 'hidden', array('label' => 'Pays', 'required' => false))
            ->add('publicPlaceCoordinates', new PublicPlaceCoordinatesFormType())
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Colzak\GeoBundle\Document\PublicPlace',
        ));
    }

    public function getName()
    {
        return 'colzak_geo_public_place';
    }
}
