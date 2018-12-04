<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 27/11/2018
 * Time: 14:43
 */

namespace App\Form\Type;

use App\Entity\Character;
use App\Entity\Genre;
use App\Entity\Type;
use App\Entity\Video;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom',
            ))
            ->add('dtRelease', DateType::class, array(
                'label' => 'Date de creation',
                'years' => range(1800, 2100),
            ))
            ->add('filmmakers', EntityType::class, array(
                'label' => 'Réalisateur',
                'multiple' => true,
                'class' => Character::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.lastname', 'ASC');
                },
                'choice_label' => function ($character, $key, $value) {
                    return $character->getFirstname() . ' ' . $character->getLastname();
                }
            ))
            ->add('actors', EntityType::class, array(
                'label' => 'Acteurs',
                'class' => Character::class,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.lastname', 'ASC');
                },
                'choice_label' => function ($character, $key, $value) {
                    return $character->getFirstname() . ' ' . $character->getLastname();
                },
                'required' => false,
            ))
            ->add('genres', EntityType::class, array(
                'label' => 'Genres',
                'class' => Genre::class,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                },
                'choice_label' => 'name'
            ))
            ->add('type', EntityType::class, array(
                'label' => 'Type',
                'class' => Type::class,
                'choice_label' => 'name'
            ))
            ->add('requiredAge', IntegerType::class, array(
                'label' => 'Age mini',
                'required' => false,
            ))
            ->add('comment', TextareaType::class, array(
                'label' => 'Description',
            ))
            ->add('urlTrailer', UrlType::class, array(
                'label' => 'Url bande d\'annonce',
                'required' => false,
            ))
            ->add('rowImage', FileType::class, array(
                'label' => 'Image',
                'required' => $options['required_image'],
            ))
            ->add('price', MoneyType::class, array(
                'label' => 'Prix',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
            'required_image' => true
        ]);
    }
}