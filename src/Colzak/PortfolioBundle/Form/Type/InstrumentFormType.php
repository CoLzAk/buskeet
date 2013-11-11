<?php

namespace Colzak\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Colzak\PortfolioBundle\Form\Type\InstrumentTypeFormType;

class InstrumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'string', array('label' => 'Nom'))
            ->add(new InstrumentTypeFormType())
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Colzak\PortfolioBundle\Document\Instrument',
        ));
    }

    public function getName()
    {
        return 'colzak_portfolio_instrument';
    }
}
