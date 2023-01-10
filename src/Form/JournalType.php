<?php

namespace App\Form;

use App\Entity\Exemplaire;
use App\Entity\Journal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('annee')
            ->add('resumee')
            ->add('date_parution')
            ->add('frequence')
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
            'data_class' => Journal::class,
        ]);
    }
}
