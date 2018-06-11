<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\TagsToCollectionTransformer;
use AppBundle\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{
    /**
     * @var TagRepository
     */
    private $manager;

    public function __construct(TagRepository $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')->add('city')->add('imageFile', VichImageType::class, array('required' => false))->add('description')
            ->add('tags', TextType::class, array(
                'required' => false,
                'attr' => ['data-role' => 'tagsinput', 'class' => 'tag-input'],
            ));
        $builder->get('tags')
            ->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new TagsToCollectionTransformer($this->manager), true);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_event';
    }
}
