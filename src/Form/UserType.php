<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            //->add('roles')
            /* fix string array conversion */
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'choice_label' => function ($value, $key, $index) {
                    if (is_array($value)) {
                        return implode(', ', $value);
                    } else {
                        return $value;
                    }
                },
                'multiple' => true,
            ])
            //->add('password')
            ->add('password', PasswordType::class, [
                'hash_property_path' => 'password',
                'mapped' => false
            ])
            ->add('nom')
            ->add('prenom')
            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text'])
            ->add('rue')
            ->add('codepostal')
            ->add('ville')
            ->add('tel_fix')
            ->add('tel_mobile')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
