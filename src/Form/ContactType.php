<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu', TextareaType::class, [
                'constraints' => new Length([
                    'min'             => 10,
                    'minMessage'      => 'Le contenu doit contenir au mois {{ limit }} caractères.',
                    'max'             => 1024,
                    'maxMessage'      => 'Le contenu ne peut pas contenir plus de {{ limit }} caractères.'
                ])
            ])
            ->add('nom', TextType::class, [
                'constraints' => new Length([
                    'min'             => 2,
                    'minMessage'      => 'Le contenu doit contenir au mois {{ limit }} caractères.',
                    'max'             => 32,
                    'maxMessage'      => 'Le contenu ne peut pas contenir plus de {{ limit }} caractères.'
                ])
            ])
            ->add('prenom', TextType::class, [
                'constraints' => new Length([
                    'min'             => 10,
                    'minMessage'      => 'Le contenu doit contenir au mois {{ limit }} caractères.',
                    'max'             => 32,
                    'maxMessage'      => 'Le contenu ne peut pas contenir plus de {{ limit }} caractères.'
                ])
            ])
            ->add('organisation', TextType::class, [
                'constraints' => new Length([
                    'min'             => 10,
                    'minMessage'      => 'Le contenu doit contenir au mois {{ limit }} caractères.',
                    'max'             => 32,
                    'maxMessage'      => 'Le contenu ne peut pas contenir plus de {{ limit }} caractères.'
                ])
            ])
            ->add('telephone', TextType::class, [
                'constraints' => new Length([
                    'min'             => 10,
                    'minMessage'      => 'Le contenu doit contenir au mois {{ limit }} caractères.',
                    'max'             => 16,
                    'maxMessage'      => 'Le contenu ne peut pas contenir plus de {{ limit }} caractères.'
                ])
            ])
            ->add('email', EmailType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
