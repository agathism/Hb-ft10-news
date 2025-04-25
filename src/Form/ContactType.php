<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Your firstname'
            ],
            'label_attr' => ['class' => 'form-label']
        ])
        ->add('lastname', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Your lastname'
            ],
            'label_attr' => ['class' => 'form-label']
        ])
        ->add('email', EmailType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Your email adress'
            ],
            'label_attr' => ['class' => 'form-label']
        ])
        ->add('subject', ChoiceType::class, [
            'choices' => [
                'Informational Request' => 'information',
                'Suggestion' => 'suggestion',
                'Technical support' => 'support',
                'Partnership' => 'partnership'
            ],
            'attr' => ['class' => 'form-control'],
            'label_attr' => ['class' => 'form-label'],
            'placeholder' => 'Choose a subject'
        ])
        ->add('message', TextareaType::class, [
            'attr' => [
                'class' => 'form-control',
                'rows' => 5,
                'placeholder' => 'Your message'
            ],
            'label_attr' => ['class' => 'form-label']
        ])
        ->add('Subscribe', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary mt-3'],
            'label' => 'Subscribe'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'csrf_protection' => false,
        ]);
    }
}
