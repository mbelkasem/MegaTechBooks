<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'mapped' => false,
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('login', TextType::class , ['attr' => ['class' => 'form-control'], 'label' => 'Identifiant'])
            ->add('firstname' , TextType::class , ['attr' => ['class' => 'form-control'], 'label' => 'Prénom'])
            ->add('lastname' , TextType::class , ['attr' => ['class' => 'form-control'], 'label'=>'Nom'])
            ->add('address' , TextType::class , ['attr' => ['class' => 'form-control'], 'label'=> 'Adresse'])
            ->add('zipcode' , TextType::class , ['attr' => ['class' => 'form-control'], 'label'=> 'Code Postale'])
            ->add('city' , TextType::class , ['attr' => ['class' => 'form-control'], 'label'=> 'Ville'])          
            ->add('country', ChoiceType::class, [
                'label' => 'Pays',
                'choices' => [
                    'Belgique' => 'BE',
                    'France' => 'FR',
                    'Pays-Bas' => 'NL',
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('RGPDAgrement', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devriez accepter nos conditions..',
                    ]),
                ],
                'label' => 'En m\'inscrivant à ce site, j\'accepte les conditions du RGPD',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
