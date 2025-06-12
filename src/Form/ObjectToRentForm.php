<?php

namespace App\Form;

use App\Entity\Coordonnees;
use App\Entity\EtatObjectToRent;
use App\Entity\ObjectToRent;
use App\Entity\TypeObjectToRent;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ObjectToRentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('descriptionText')
            ->add('price')
            ->add('Surface')
            ->add('NbrPieces')
            ->add('NbrSalleDeBain')
            ->add('NbrSalleDeau')
            ->add('CuisineEquipee')
            ->add('Terasse')
            ->add('Balcon')
            ->add('Jardin')
            ->add('Piscine')
            ->add('AccessibleFauteuilsRoulants')
            ->add('Garage')
            ->add('SousSol')
            ->add('NbrTerasse')
            ->add('SurfaceBalcon')
            ->add('NbrChambres')
            ->add('AnneeConstruction')
            ->add('SurfaceTerrain')
            ->add('activated')
            ->add('Coordonnee', EntityType::class, [
                'class' => Coordonnees::class,
                'choice_label' => 'id',
            ])
            ->add('User', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('typeObjectToRent', EntityType::class, [
                'class' => TypeObjectToRent::class,
                'choice_label' => 'id',
            ])
           ->add('etatObjectToRent', EntityType::class, [
    'class' => EtatObjectToRent::class,
    'choice_label' => 'Libelle',
])

            ->add('photoFile', FileType::class, [
                'label' => 'Photo (fichier image)',
                'mapped' => false, // important : ce champ n’est pas lié à l'entité directement
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (jpeg, png, gif)',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ObjectToRent::class,
        ]);
    }
}
