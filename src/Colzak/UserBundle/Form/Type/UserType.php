<?php

namespace Colzak\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'Nom d\'utilisateur'))
            ->add('email', 'email', array('label' => 'Email'))
            ->add('plainPassword', 'password', array('label' => 'Mot de passe'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Colzak\UserBundle\Document\User',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return '';
    }
}
