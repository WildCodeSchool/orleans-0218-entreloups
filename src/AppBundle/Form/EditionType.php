<?php

namespace AppBundle\Form;

use AppBundle\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom :'])
            ->add(
                'startDate',
                DateTimeType::class,
                [
                    'label' => 'Date de début :',
                    'widget' => 'single_text', 'model_timezone' => 'Europe/Paris', 'html5' => false,
                    'attr' => ['class' => 'flatpickr']
                ]
            )
            ->add(
                'endDate',
                DateTimeType::class,
                [
                    'label' => 'Date de fin :',
                    'widget' => 'single_text', 'model_timezone' => 'Europe/Paris', 'html5' => false,
                    'attr' => ['class' => 'flatpickr']
                ]
            )
            ->add('place', TextType::class, ['label' => 'Lieu :'])
            ->add('hashtag', TextType::class, ['label' => 'Hashtag :'])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut :',
                'choices' => ['A venir' => true, 'Annulée' => false]
            ])
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'label' => 'Évènement',
                'disabled' => true,
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Edition'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_edition';
    }
}
