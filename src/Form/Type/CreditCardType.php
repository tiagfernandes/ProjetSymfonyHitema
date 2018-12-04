<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 03/12/2018
 * Time: 21:52
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, [
                'label' => 'Numéro',
                'attr' => array(
                    'placeholder' => '4242 4242 4242 xxxx'
                )
            ])
            ->add('dateExpired', TextType::class, array(
                'label' => 'Expiration date',
                'attr' => array(
                    'placeholder' => '01 / 2018'
                )
            ))
            ->add('cryptogram', PasswordType::class, array(
                'label' => 'Cryptogram',
                'attr' => array(
                    'placeholder' => '***'
                )
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom',
            ));
    }
}