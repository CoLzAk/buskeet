<?php

namespace Colzak\GeoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Colzak\GeoBundle\Document\PublicPlaceCoordinates;

class PublicPlaceCoordinatesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('x', 'hidden', array('label' => 'Longitude'))
            ->add('y', 'hidden', array('label' => 'Latitude'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Colzak\GeoBundle\Document\PublicPlaceCoordinate',
        ));
    }

    public function getName()
    {
        return 'colzak_geo_public_place';
    }
}
