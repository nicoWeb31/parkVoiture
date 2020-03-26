<?php

namespace App\DataFixtures;


use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');
        
        $marque1 = new Marque();
        $marque1->setLibelle('toyota');
        $manager->persist($marque1);

        $marque2 = new Marque();
        $marque2->setLibelle('peujo');
        $manager->persist($marque2);

        $mod = new Modele();
        $mod->setLibelle('yaris')
        ->setImage('modele1.jpg')
        ->setPrixMoyen(12000)
        ->setMarque($marque1);

        $manager->persist($mod);

        $mod2 = new Modele();
        $mod2->setLibelle('yraus')
        ->setImage('modele2.jpg')
        ->setPrixMoyen(15000)
        ->setMarque($marque1);

        $manager->persist($mod2);

        $mod3 = new Modele();
        $mod3->setLibelle('007')
        ->setImage('modele3.jpg')
        ->setPrixMoyen(10000)
        ->setMarque($marque2);

        $manager->persist($mod3);

        $mod4 = new Modele();
        $mod4->setLibelle('008')
        ->setImage('modele4.jpg')
        ->setPrixMoyen(16000)
        ->setMarque($marque2);

        $manager->persist($mod4);

        $mod5 = new Modele();
        $mod5->setLibelle('corola')
        ->setImage('modele5.jpg')
        ->setPrixMoyen(12000)
        ->setMarque($marque1);

        $manager->persist($mod5);

        $modeles= [$mod,$mod2,$mod3,$mod4,$mod5];
        foreach($modeles as $m){
            $rand = rand(3,5);
            for($i =1 ; $i<= $rand ; $i++ ){
                $voiture = new Voiture();
                $voiture->setImmatriculation($faker->regexify("[A-Z]{2}[0-9]{3,4}[A-Z]{2}"))
                        ->setNbrPortes($faker->randomElement($array = array (3,5)))
                        ->setAnnee($faker->numberBetween($min = 1990, $max = 2019))
                        ->setModele($m);
                        $manager->persist($voiture);
            }
        }


        $manager->flush();
    }
}
