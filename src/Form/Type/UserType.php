<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 28/11/2018
 * Time: 15:07
 */

namespace App\Form\Type;

use App\Entity\User;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('dtBorn', BirthdayType::class, [
                'label' => 'Date de naissance',
            ])
            ->add('username', TextType::class, [
                'label' => 'Login',
            ])
            ->add('rawPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => $options['required_password'],
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Mot de passe (bis)'],
            ])
            ->add('captchaCode', CaptchaType::class, array(
                'label' => 'Captcha',
                'captchaConfig' => 'ExampleCaptcha'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'required_password' => false
        ]);
    }
}