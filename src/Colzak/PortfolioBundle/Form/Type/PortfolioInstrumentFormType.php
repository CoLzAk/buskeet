<?php

namespace Colzak\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Colzak\PortfolioBundle\Document\PortfolioInstrument;

class PortfolioInstrumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level', 'choice', array(
                'label' => 'Niveau',
                'choices' => PortfolioInstrument::getLevelList()
            ))
            ->add('instrument', 'document', array(
                'class' => 'Colzak\PortfolioBundle\Document\Instrument',
                'property' => 'name',
                'required' => true
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Colzak\PortfolioBundle\Document\PortfolioInstrument',
        ));
    }

    public function getName()
    {
        return 'colzak_portfolio_portfolio_instrument';
    }
}
