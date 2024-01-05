<?php

/**
 * ResetPasswordRequestFormType File Doc Comment
 *
 * @category Form
 * @package  App\Form
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * ResetPasswordRequestFormType Class Doc Comment
 *
 * @category Form
 * @package  App\Form
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class ResetPasswordRequestFormType extends AbstractType
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
        ->add('email', EmailType::class, [
            'attr' => [
                'class' => 'form-control mb-3'
            ],
            'label' => 'Adresse email'
        ]);
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
            // Configure your form options here
        ]);
    }
}
