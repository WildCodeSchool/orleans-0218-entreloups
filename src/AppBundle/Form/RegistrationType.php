<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 22/05/18
 * Time: 16:13
 */

namespace AppBundle\Form;

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
            ->add('codePostal', HiddenType::class)
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ;
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
