<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text',
                //'format' => 'dd/MM/yyyy',
                // 2. Disable HTML5 option
                //'html5' => false
                ])
            //->add('country')
            /* fix string array conversion */
            ->add('country', EntityType::class, [
                'class' => Country::class,
                /*
                'choices' => function ($value, $key, $index) {
                    if (is_array($value)) {
                        return implode(', ', $value);
                    } else {
                        return $value;
                    }
                },
                */
                'choice_label' => 'nom',
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
