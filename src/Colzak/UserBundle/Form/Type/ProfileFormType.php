<?php

namespace Colzak\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Colzak\UserBundle\Document\Profile;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('lastname', null, array('label' => 'Nom'))
            ->add('birthdate', 'birthday', array(
                'label' => 'Date de naissance',
                'years' => range(date("Y")-16, date("Y")-70)
            ))
            ->add('gender', 'choice', array(
                'label' => 'Je suis ',
                'choices' => array(Profile::GENDER_FEMALE => 'Une femme', Profile::GENDER_MALE => 'Un homme'),
                'expanded' => true
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Colzak\UserBundle\Document\Profile',
        ));
    }

    public function getName()
    {
        return 'colzak_user_profile';
    }
}
