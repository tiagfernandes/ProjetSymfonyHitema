<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 04/12/2018
 * Time: 11:43
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre courriel',
            ])
            ->add('subject', TextType::class, [
                'label' => 'Pourquoi nous contactez-vous',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
            ]);
    }
}