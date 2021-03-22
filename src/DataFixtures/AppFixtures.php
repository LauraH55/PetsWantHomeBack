<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Race;
use App\Entity\Animal;
use App\Entity\Shelter;
use App\Entity\Species;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\AnimalProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $connection;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, Connection $connection)
    {
        $this->passwordEncoder = $passwordEncoder;
        // Connection to MySQL
        $this->connection = $connection;
    }

    // Here we set up our values
    const NB_ANIMALS = 30;
    const NB_SPECIES = 3;
    const NB_RACES = 9;

    private function truncate()
    {
        // We desactivate constraints from Faker
        $animals = $this->connection->executeQuery('SET foreign_key_checks = 0');
        // We truncate
        $animals = $this->connection->executeQuery('TRUNCATE TABLE animal');
        $animals = $this->connection->executeQuery('TRUNCATE TABLE race');
        $animals = $this->connection->executeQuery('TRUNCATE TABLE shelter');
    }

    public function load(ObjectManager $manager)
    {
        // We truncate our tables to restart at id=1
        $this->truncate();

        // Instance of Faker
        $faker = Faker\Factory::create('fr_FR');
        // We give a provider to Faker
        $faker->addProvider(new AnimalProvider());

        // Shelter
        $shelter = new Shelter();
        //$encodedPassword = $this->passwordEncoder->encodePassword($shelter, 'shelter');
        $shelter->setName('Refuge 1');
        $shelter->setAddress('2 rue des gentianes 05000 Gap');
        $shelter->setPhoneNumber('0635262245');
        $shelter->setEmail('shelter@shelter.com');
        $shelter->setPicture('images/shelter.jpg');
        $shelter->setPassword('$argon2id$v=19$m=65536,t=4,p=1$zFDMcyTCfQnlHqWMOsC+sw$hfCVAVPCKyK0U6W3HVXSnyxm/W3zNHUj7mWThYCbof8');

        $manager->persist($shelter);


        $catSpeciesObject = [];

        $catSpecies = new Species();
        $catSpecies->setCreatedAt(new \DateTime());
        // The function unique() make our result always unique
        $catSpecies->setName('cat');

        // We stock our data for later
        $catSpeciesObject[] = $catSpecies;

        // We persist it
        $manager->persist($catSpecies);


        $dogSpeciesObject = [];

        $dogSpecies = new Species();
        $dogSpecies->setCreatedAt(new \DateTime());
        // The function unique() make our result always unique
        $dogSpecies->setName('dog');

        // We stock our data for later
        $dogSpeciesObject[] = $dogSpecies;

        // We persist it
        $manager->persist($dogSpecies);


        $nacSpeciesObject = [];

        $nacSpecies = new Species();
        $nacSpecies->setCreatedAt(new \DateTime());
        // The function unique() make our result always unique
        $nacSpecies->setName('nac');

        // We stock our data for later
        $nacSpeciesObject[] = $nacSpecies;

        // We persist it
        $manager->persist($nacSpecies);


        // Cat's Races for Race Table

        // An array to stock our cat's races
        $catList = [];

        for ($i = 0; $i < self::NB_RACES; $i++) {

            $cats = new Race();
            $cats->setCreatedAt(new \DateTime());
            // The function unique() make our result always unique
            $cats->setName($faker->unique()->catRace());
            $cats->setSpecies($catSpecies); 

            // We stock our data for later
            $catList[] = $cats;

            // We persist it
            $manager->persist($cats);
        };

        // Dog's Races for Race Table

        // An array to stock our dog's races
        $dogList = [];

        for ($i = 0; $i < self::NB_RACES; $i++) {

            $dogs = new Race();
            // We fill the fields of our entity
            $dogs->setCreatedAt(new \DateTime());
            $dogs->setName($faker->unique()->dogRace());
            $dogs->setSpecies($dogSpecies);

            // We stock our data for later
            $dogList[] = $dogs;

            // We persist it
            $manager->persist($dogs);
        };


        // New pets's Races for Race Table

        // An array to stock our new pet's races
        $nacList = [];

        for ($i = 0; $i < self::NB_RACES; $i++) {

            $nacs = new Race();
            // We fill the fields of our entity
            $nacs->setCreatedAt(new \DateTime());
            $nacs->setName($faker->unique()->nacRace());
            $nacs->setSpecies($nacSpecies); 

            // We stock our data for later
            $nacList[] = $nacs;

            // We persist it
            $manager->persist($nacs);
        };

        // Cats for Animal Table

        for ($i = 1; $i <= self::NB_ANIMALS; $i++) {

            $animal = new Animal();
            // We fill the fields of our entity
            $animal->setName($faker->animalName());
            $animal->setBirthdate($faker->dateTimeBetween('-20 years'));
            $animal->setGender($faker->numberBetween($min = 1, $max = 2));
            // The function numberBetween() allow to set a number only between the min and max values indicated
            $animal->setCohabitation($faker->numberBetween($min = 1, $max = 4));
            $animal->setPicture($faker->image());
            $animal->setStatus($faker->numberBetween($min = 1, $max = 4));
            $animal->setDescription($faker->text());
            $animal->setCreatedAt(new \DateTime());
            $animal->setSpecies($catSpecies);

             // With shuffle we make random data but also unique
            shuffle($catList);
            for ($r = 0; $r < self::NB_RACES; $r++) {
                // We search in our shuffled array
                $randomRace = $catList[$r];
                $animal->setRace($randomRace);
            } 

            // We persist it
            $manager->persist($animal);
        }

        // Cats for Animal Table

        for ($i = 1; $i <= self::NB_ANIMALS; $i++) {

            $animal = new Animal();
            // We fill the fields of our entity
            $animal->setName($faker->animalName());
            $animal->setBirthdate($faker->dateTimeBetween('-20 years'));
            $animal->setGender($faker->numberBetween($min = 1, $max = 2));
            $animal->setCohabitation($faker->numberBetween($min = 1, $max = 4));
            $animal->setPicture($faker->image());
            $animal->setStatus($faker->numberBetween($min = 1, $max = 4));
            $animal->setDescription($faker->text());
            $animal->setCreatedAt(new \DateTime());
            $animal->setSpecies($dogSpecies);

             // With shuffle we make random data but also unique
            shuffle($dogList);
            for ($r = 0; $r < self::NB_RACES; $r++) {

                $randomRace = $dogList[$r];
                $animal->setRace($randomRace);
            } 

            // We persist it
            $manager->persist($animal);
        }

        // Cats for Animal Table

        for ($i = 1; $i <= self::NB_ANIMALS; $i++) {

            $animal = new Animal();
            // We fill the fields of our entity
            $animal->setName($faker->animalName());
            $animal->setBirthdate($faker->dateTimeBetween('-20 years'));
            $animal->setGender($faker->numberBetween($min = 1, $max = 2));
            $animal->setCohabitation($faker->numberBetween($min = 1, $max = 4));
            $animal->setPicture($faker->image());
            $animal->setStatus($faker->numberBetween($min = 1, $max = 4));
            $animal->setDescription($faker->text());
            $animal->setCreatedAt(new \DateTime());
            $animal->setSpecies($nacSpecies);

            // With shuffle we make random data but also unique
             shuffle($nacList);
            for ($r = 0; $r < self::NB_RACES; $r++) {

                $randomRace = $nacList[$r];
                $animal->setRace($randomRace);
            } 

            // We persist it
            $manager->persist($animal);
        }


        // We flush
        $manager->flush();
    }
}
