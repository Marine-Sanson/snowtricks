<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfilFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
                'label' => 'Nom'
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'readonly' => true,
                ],
                'label' => 'Email'
            ])
            ->add('avatar', FileType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
                'label' => "Télécharger une image - Attention le téléchargement d'une nouvelle image supprimera la précédente",
                'multiple' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxWidth' => 1600,
                        'maxWidthMessage' => 'l\'image doit faire {{ max_width }} pixels de large au maximum',
                        'maxHeight' => 1600,
                        'maxHeightMessage' => 'l\'image doit faire {{ max_height }} pixels de long au maximum',
                    ])
                ]
            ]);

    }


    public function configureOptions(OptionsResolver $resolver): void
    {

        $resolver->setDefaults([
            'data_class' => User::class,
        ]);

    }


}
