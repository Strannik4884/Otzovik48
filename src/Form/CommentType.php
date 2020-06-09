<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', null, [
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Текст должен быть не менее {{ limit }} символов!',
                        'max' => 512
                    ])
                ],
                'label' => 'Имя',
                'attr' => [
                    'class' => 'validate'
                ]
            ])
            ->add('rating', NumberType::class, [
                'constraints' => [
                    new Length([
                        'max' => 1
                    ])
                ],
                'label' => 'Рейтинг',
                'attr' => [
                    'class' => 'validate',
                    'maxlength' => "1"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
