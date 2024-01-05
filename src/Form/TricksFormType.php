<?php

/**
 * TricksFormType File Doc Comment
 *
 * @category Form
 * @package  App\Form
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Form;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * TricksFormType Class Doc Comment
 *
 * @category Form
 * @package  App\Form
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class TricksFormType extends AbstractType
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
                            'maxWidth' => 1600,
                            'maxWidthMessage' => 'l\'image doit faire {{ max_width }} pixels de large au maximum',
                            'maxHeight' => 1600,
                            'maxHeightMessage' => 'l\'image doit faire {{ max_height }} pixels de long au maximum',
                        ])
                    )
                ]
            ])
            ->add('videos', UrlType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
                'label' => 'Coller l\'url de la vidéo que vous souhaitez ajouter',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/https?:\/\/www\.youtube\.com/',
                        'message' => 'Seules les liens Youtube sont acceptés'
                    ])
                ]
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
            'data_class' => Trick::class,
        ]);
    }
}
