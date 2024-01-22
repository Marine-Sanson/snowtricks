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


    /**
     * Summary of function buildForm
     *
     * Send an email to the user with a token to verify his account
     *
     * @param FormBuilderInterface $builder FormBuilderInterface
     * @param array                $options Options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add(
                'username', TextType::class, [
                    'attr' => [
                        'class' => 'form-control mb-3'
                    ],
                    'label' => 'Nom'
                ]
            )
            ->add(
                'email', EmailType::class, [
                    'attr' => [
                        'class' => 'form-control mb-3',
                        'readonly' => true,
                    ],
                    'label' => 'Email'
                ]
            )
            ->add(
                'avatar', FileType::class, [
                    'attr' => [
                        'class' => 'form-control mb-3'
                    ],
                    'label' => "Télécharger une image - Attention le téléchargement d'une nouvelle image supprimera la précédente",
                    'multiple' => false,
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new Image(
                            [
                                'maxWidth' => 1600,
                                'maxWidthMessage' => 'l\'image doit faire {{ max_width }} pixels de large au maximum',
                                'maxHeight' => 1600,
                                'maxHeightMessage' => 'l\'image doit faire {{ max_height }} pixels de long au maximum',
                            ]
                        )
                    ]
                ]
            );

    }


    /**
     * Summary of function configureOptions
     *
     * Send an email to the user with a token to verify his account
     *
     * @param OptionsResolver $resolver OptionsResolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {

        $resolver->setDefaults([
            'data_class' => User::class,
        ]);

    }


}
