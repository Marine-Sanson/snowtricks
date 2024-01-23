<?php

/**
 * RegistrationFormType File Doc Comment
 *
 * @category Form
 * @package  App\Form
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * RegistrationFormType Class Doc Comment
 *
 * @category Form
 * @package  App\Form
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class RegistrationFormType extends AbstractType
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
                'email', EmailType::class, [
                    'attr' => [
                        'class' => 'form-control mb-3'
                    ],
                    'label' => 'Adresse email',
                    'constraints' => [
                        new Email(
                            [
                                'message' => 'Vous devez entrer un email valide.'
                            ]
                        ),
                    ],
                ]
            )
            ->add(
                'username', TextType::class, [
                    'attr' => [
                        'class' => 'form-control mb-3'
                    ],
                    'label' => 'Nom d\'utilisateur'
                ]
            )
            ->add(
                'agreeTerms', CheckboxType::class, [
                    'mapped' => false,
                    'constraints' => [
                        new IsTrue(
                            [
                                'message' => 'Vous devez acceptez les conditions d\'utilisation du site.',
                            ]
                        ),
                    ],
                    'attr' => [
                        'class' => 'mt-3'
                    ],
                    'label' => 'J\'accepte les conditions d\'utilisation de ce site.'
                ]
            )
            ->add(
                'plainPassword', PasswordType::class, [
                // Instead of being set onto the object directly,
                // This is read and encoded in the controller.
                    'mapped' => false,
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'form-control mb-3'
                    ],
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please enter a password',
                            ]
                        ),
                        new Length(
                            [
                                'min' => 6,
                                'minMessage' => 'Your password should be at least {{ limit }} characters',
                                // Max length allowed by Symfony for security reasons.
                                'max' => 4096,
                            ]
                        ),
                    ],
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

        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );

    }


}
