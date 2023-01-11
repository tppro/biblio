<?php

namespace App\Form;

use App\Entity\Bookj;
use PHPUnit\TextUI\XmlConfiguration\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookjType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('annee')
            ->add('resumee')
            ->add('etat')
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Image'
                /*
                'constraints' => [
                    new File([
                        'maxSize' => '512K'
                    ])
                ]
                */
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bookj::class,
        ]);
    }
}
