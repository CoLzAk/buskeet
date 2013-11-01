<?php

namespace Colzak\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Colzak\UserBundle\Document\Portfolio;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('instruments', 'document', array(
                'class' => 'Colzak\MusicBundle\Document\Instrument',
                'property' => 'name'
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Colzak\UserBundle\Document\Portfolio',
        ));
    }

    public function getName()
    {
        return 'colzak_user_portfolio';
    }
}
