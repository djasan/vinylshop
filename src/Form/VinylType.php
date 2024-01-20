<?php

namespace App\Form;

use App\Entity\Vinyl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class VinylType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('artiste')
            ->add('annee')
            ->add('album')
            ->add('cover', FileType::class, [
                'mapped' => false,
                'label' => 'Fichier image',
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => "ceci n'est pas une image valide"
                    ])
                ]
            ])
            ->add('audio', FileType::class, [
                'mapped' => false,
                'label' => 'Fichier audio',
                'required'=>true,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'audio/mpeg',
                            'audio/mpeg3',
                            'audio/x-mpeg3',
                            'audio/mp4',
                            'audio/aac'
                        ],
                        'mimeTypesMessage' => 'Votre fichier doit etre au format mp3',
                    ])
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vinyl::class,
        ]);
    }
}