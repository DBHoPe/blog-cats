<?php

namespace App\Form;

use App\Entity\Cat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Cat name',
                    'required' => false
                ),
                'label' => false
            ])
            ->add('description', TextType::class, [
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-10 text-2xl outline-none',
                    'placeholder' => 'Describe your cat',
                    'required' => false
                ),
                'label' => false
            ])
            ->add('imagePath', FileType::class, array(
                'required' => false,
                'mapped' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
        ]);
    }
}
