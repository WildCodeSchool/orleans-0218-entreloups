<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 18/06/18
 * Time: 13:15
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'Nom : '])
        ->add(
            'status',
            ChoiceType::class,
            [
                'label' => 'Statut :',
                'choices' =>
                    [
                        'A faire' => 'A faire',
                        'En cours' => 'En cours',
                        'Terminée' => 'Terminée',
                        'Annulée' => 'Annulée'
                    ]
            ]
        )
        ->add('description', TextareaType::class, ['label' => 'Description : '])
        ->add(
            'deadline',
            DateTimeType::class,
            [
            'label' => 'Date d\'objectif :',
            'widget' => 'single_text', 'model_timezone' => 'Europe/Paris', 'html5' => false,
            'attr' => ['class' => 'flatpickr']
            ]
        );
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_task';
    }
}
