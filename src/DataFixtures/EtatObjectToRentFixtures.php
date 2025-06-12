<?php

namespace App\DataFixtures;

use App\Entity\EtatObjectToRent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatObjectToRentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Disponibilité' => ['Disponible', 'Réservé', 'Loué', 'Expiré', 'Retiré du marché'],
            'État physique' => ['Neuf', 'Bon état', 'À rénover', 'En maintenance', 'Insalubre'],
            'Gestion financière' => ['En attente de paiement', 'Paiement en cours', 'Paiement effectué', 'Impayé', 'Saisie'],
            'Statut administratif' => ['En cours d’enregistrement', 'Validé', 'Suspendu', 'Litige', 'Vendu']
        ];

        foreach ($categories as $category => $states) {
            foreach ($states as $state) {
                $etat = new EtatObjectToRent();
                $etat->setLibelle($state);
                $manager->persist($etat);
            }
        }

        $manager->flush();
    }
}
