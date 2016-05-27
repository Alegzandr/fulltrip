<?php
namespace FulltripBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => false, 'attr' => array('placeholder' => 'Nom')))
            ->add('category', ChoiceType::class, array(
                'choices' => array(
                    'Boîte de nuit' => 'nightclub',
                    'Bar' => 'pub',
                    'Restaurant' => 'restaurant',
                ), 'choices_as_values' => true, 'label' => false))
            ->add('description', TextareaType::class, array('label' => false, 'attr' => array('placeholder' => 'Description')))
            ->add('address', TextType::class, array('label' => false, 'attr' => array('placeholder' => 'Adresse')))
            ->add('zipCode', NumberType::class, array('label' => false, 'attr' => array('placeholder' => 'Code postal')))
            ->add('city', TextType::class, array('label' => false, 'attr' => array('placeholder' => 'Ville')))
            ->add('price', ChoiceType::class, array(
                'choices' => array(
                    'gratuit' => '0',
                    '< 10€' => '10',
                    '< 20€' => '20',
                    '< 50€' => '50',
                    '< 100€' => '100',
                    '< 150€' => '150',
                    '< 300€' => '300'
                ), 'choices_as_values' => true, 'label' => false))
            ->add('post', 'vich_image', array(
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
                'label'         => 'Photo'
            ))
            ->add('save', SubmitType::class, array('label' => 'Publier'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EntityBundle\Entity\Place',
        ));
    }
}