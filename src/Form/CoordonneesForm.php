<?php

namespace App\Form;

use App\Entity\Coordonnees;
use App\Entity\Quartier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoordonneesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
            ])
            /*->add('longitude', NumberType::class, [
                'label' => 'Longitude',
                'required' => false,
                'scale' => 6,
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Latitude',
                'required' => false,
                'scale' => 6,
            ])*/
            ->add('CodePostal', TextType::class, [
                'label' => 'Code postal',
            ])
            ->add('quartier', EntityType::class, [
                'class' => Quartier::class,
                'choice_label' => 'nom', // à adapter selon ton entité Quartier
                'label' => 'Quartier',
                'placeholder' => 'Sélectionner un quartier',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coordonnees::class,
        ]);
    }
}
