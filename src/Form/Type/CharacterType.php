<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 30/11/2018
 * Time: 14:32
 */

namespace App\Form\Type;

use App\Entity\Profession;
use App\Entity\Character;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CharacterType extends AbstractType
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
            ->add('professions', EntityType::class, array(
                'label' => 'Profession',
                'class' => Profession::class,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
                'choice_label' => function ($character, $key, $value) {
                    return $character->getName();
                }
            ))
            ->add('rowImage', FileType::class, array(
                'label' => 'Image',
                'required' => $options['required_image'],
            ))
            ->add('dtBorn', BirthdayType::class, [
                'label' => 'Date de naissance',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
            'required_image' => true
        ]);
    }
}