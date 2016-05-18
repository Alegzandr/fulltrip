<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array('label' => 'form.firstname', 'translation_domain' => 'FOSUserBundle'))
            ->add('lastname', null, array('label' => 'form.lastname', 'translation_domain' => 'FOSUserBundle'))
            ->add('gender', 'choice', array(
                        'expanded' => true,
                        'choices' => array(
                            'm' => 'form.male',
                            'f' => 'form.female',
                        ),
                        'label' => 'form.gender',
                        'translation_domain' => 'FOSUserBundle'))

            ->add('birthdate', 'date', array(
                'format' => 'dd / MM / yyyy',
                'years' =>  range(\date("Y") - 18, \date("Y") - 100),
                'label' => 'form.birthdate',
                'translation_domain' => 'FOSUserBundle'))

            ->remove('username')
        ;

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
