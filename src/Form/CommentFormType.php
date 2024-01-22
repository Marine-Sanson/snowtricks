<?php

namespace App\Form;

use App\Model\CommentModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class CommentFormType extends AbstractType
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
                'content', TextType::class, [
                    'attr' => [
                        'class' => 'form-control w-lg-75 m-auto'
                    ],
                    'label' => 'Laisse un commentaire :'
                ]
            )
            ->add('trickId', HiddenType::class, ['mapped' => false])
            ->add('userId', HiddenType::class, ['mapped' => false]);

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

        $resolver->setDefaults(
            [
                'data_class' => CommentModel::class,
            ]
        );

    }


}
