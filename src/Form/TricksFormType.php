<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Media;
use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TricksFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
                'label' => 'Nom'
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
                'label' => 'Description'
            ])
            ->add('trickGroup', EntityType::class, [
                'attr' => [
                    'class' => 'form-select mb-3',
                    'size' => "2"
                ],
                'class' => Group::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Selectionnez un ou plusieurs groupe(s)'
            ])
            ->add('images', FileType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
                'label' => 'Télécharger une ou plusieurs image(s)',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All(
                        new Image([
                            'maxWidth' => 1280,
                            'maxWidthMessage' => 'l\'image doit faire {{ max_width }} pixels de large au maximum',
                            'maxHeight' => 1280,
                            'maxHeightMessage' => 'l\'image doit faire {{ max_height }} pixels de long au maximum',
                        ])
                    )
                ]
            ])
            // ->add('media', EntityType::class, [
            //     'class' => Media::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            //     'label' => 'Media'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
