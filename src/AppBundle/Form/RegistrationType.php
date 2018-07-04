<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 22/05/18
 * Time: 16:13
 */

namespace AppBundle\Form;

use AppBundle\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('city', SearchType::class)
            ->add('mobility', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 200,
                    'value' => 100
                ]
            ])
            ->add('codePostal', HiddenType::class)
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'label' => 'Choisissez vos domaines d\'intérêt par mots clés :',
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
