<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
Use App\Entity\Post;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('content', TextType::class, [
            'label' => 'Commentaire',
        ])
        /*->add('user', EntityType::class, [
            'class' => User::class,
            'label' => 'Auteur',
             
        ])*/
        /*->add('post', EntityType::class, [
            'class' => Post::class,
            'label' => 'Article',
             
        ]);*/        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
