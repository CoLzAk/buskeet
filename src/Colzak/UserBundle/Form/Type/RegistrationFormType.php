<?php

namespace Colzak\UserBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/**
 * Registration form
 */
class RegistrationFormType extends BaseType
{
    protected $container;

    public function __construct($class, ContainerInterface $container)
    {
        parent::__construct($class);

        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('email', 'email', array('label' => 'Email'))
            ->add('username', null, array('label' => 'Nom d\'utilisateur'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmez votre mot de passe'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Colzak\UserBundle\Document\User',
        ));
    }

    public function getName()
    {
        return 'colzak_user_registration';
    }
}
