<?php

namespace Colzak\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Colzak\PortfolioBundle\Document\Instrument;

class InstrumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'name'))
            ->add('category', 'choice', array(
                    'label' => 'category',
                    'choices' => Instrument::getCategoryList()
                ))
            ->add('iconPath', 'text', array('label' => 'icon path'))
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
