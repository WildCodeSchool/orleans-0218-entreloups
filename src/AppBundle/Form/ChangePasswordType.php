<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 29/05/18
 * Time: 15:37
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;

class ChangePasswordType extends AbstractType
{

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ChangePasswordFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_change_password';
    }
}