<?php

namespace App\Form;

use App\Entity\Dvd;
use App\Entity\Exemplaire;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DvdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('annee')
            ->add('resumee')
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'libelle',
                'multiple' => false,
            ])
            ->add('is_serie')
            ->add('producteur')
            ->add('nbmedia')
            //->add('exemplaire')
            ->add('exemplaire', EntityType::class, [
                'class' => Exemplaire::class,
                /*
                'choices' => function ($value, $key, $index) {
                    if (is_array($value)) {
                        return implode(', ', $value);
                    } else {
                        return $value;
                    }
                },
                */
                'choice_label' => 'ref',
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dvd::class,
        ]);
    }
}
