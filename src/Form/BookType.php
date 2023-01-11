<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Exemplaire;
use App\Entity\Genre;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('annee')
            ->add('resumee')
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Image',
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '512K'
                    ])
                ]
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'libelle',
                'multiple' => false,
            ])
            ->add('etat')
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'nom',
                'multiple' => true,
            ])
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
            'data_class' => Book::class,
        ]);
    }
}
