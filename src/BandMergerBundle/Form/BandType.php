<?php

namespace BandMergerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BandType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name',null, array('attr' => ['class'=>'form-band form-control input-lg'],))
                ->add('description',null, array('attr' => ['class'=>'form-band form-control input-lg'], ))
                ->add('public',ChoiceType::class, array(
                    'choices'=> array(
                        'Yes' => 1,
                        'No' => 0,),'choices_as_values' => true,
                    'attr' => ['class'=>'form-band form-control input-lg'],))
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BandMergerBundle\Entity\Band'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bandmergerbundle_band';
    }


}
