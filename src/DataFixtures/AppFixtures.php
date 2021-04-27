<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Race;
use App\Entity\User;
use App\Entity\Animal;
use App\Entity\Shelter;
use App\Entity\Species;
use App\Entity\PrivatePerson;
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
    const NB_RACES = 65;

    private function truncate()
    {
        // We desactivate constraints from Faker
        $animals = $this->connection->executeQuery('SET foreign_key_checks = 0');
        // We truncate
        $animals = $this->connection->executeQuery('TRUNCATE TABLE animal');
        $animals = $this->connection->executeQuery('TRUNCATE TABLE race');
        $animals = $this->connection->executeQuery('TRUNCATE TABLE shelter');
        $animals = $this->connection->executeQuery('TRUNCATE TABLE species');
        $animals = $this->connection->executeQuery('TRUNCATE TABLE user');
        $animals = $this->connection->executeQuery('TRUNCATE TABLE private_person');
    }

    public function load(ObjectManager $manager)
    {
        // We truncate our tables to restart at id=1
        $this->truncate();

        // Instance of Faker
        $faker = Faker\Factory::create('fr_FR');
        // We give a provider to Faker
        $faker->addProvider(new AnimalProvider());


        // Users
        $chatsteignes = new User();
        $chatsteignes->setEmail('chats-teignes@chat.com');
        $encodedPassword = $this->passwordEncoder->encodePassword($chatsteignes, 'chatsteignes');
        $chatsteignes->setPassword($encodedPassword);
        $chatsteignes->setRoles(['ROLE_SHELTER']);
        $chatsteignes->setCreatedAt(new \DateTime());
        $manager->persist($chatsteignes);

        $patounes = new User();
        $patounes->setEmail('le-refuge-des-patounes@patounes.com');
        $encodedPassword = $this->passwordEncoder->encodePassword($patounes, 'patounes');
        $patounes->setPassword($encodedPassword);
        $patounes->setRoles(['ROLE_SHELTER']);
        $patounes->setCreatedAt(new \DateTime());
        $manager->persist($patounes);

        $mordant = new User();
        $mordant->setEmail('refuge-mordant@refuge.com');
        $encodedPassword = $this->passwordEncoder->encodePassword($mordant, 'mordant');
        $mordant->setPassword($encodedPassword);
        $mordant->setRoles(['ROLE_SHELTER']);
        $mordant->setCreatedAt(new \DateTime());
        $manager->persist($mordant);

        $privateUser = new User();
        $privateUser->setEmail('laura@laura.com');
        $encodedPassword = $this->passwordEncoder->encodePassword($privateUser, 'laura');
        $privateUser->setPassword($encodedPassword);
        $privateUser->setRoles(['ROLE_USER']);
        $privateUser->setCreatedAt(new \DateTime());
        $manager->persist($privateUser);

        // Private Person
        $laura = new PrivatePerson();
        $laura->setFirstname('Laura');
        $laura->setLastname('Hantz');
        $laura->setPicture('default_image_01.png');
        $laura->setCreatedAt(new \DateTime());
        $laura->setUser($privateUser);
        $manager->persist($laura);

        $catSpeciesObject = [];

        $catSpecies = new Species();
        $catSpecies->setCreatedAt(new \DateTime());
        // The function unique() make our result always unique
        $catSpecies->setName('Chat');

        // We stock our data for later
        $catSpeciesObject[] = $catSpecies;

        // We persist it
        $manager->persist($catSpecies);


        $dogSpeciesObject = [];

        $dogSpecies = new Species();
        $dogSpecies->setCreatedAt(new \DateTime());
        // The function unique() make our result always unique
        $dogSpecies->setName('Chien');

        // We stock our data for later
        $dogSpeciesObject[] = $dogSpecies;

        // We persist it
        $manager->persist($dogSpecies);


        $nacSpeciesObject = [];

        $nacSpecies = new Species();
        $nacSpecies->setCreatedAt(new \DateTime());
        // The function unique() make our result always unique
        $nacSpecies->setName('Nac');

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

        
        // Nacs for Animal Table

        $nacAnimals = [];

        for ($i = 1; $i <= self::NB_ANIMALS; $i++) {

            $nacAnimal = new Animal();
            // We fill the fields of our entity
            $nacAnimal->setName($faker->unique()->animalName());
            $nacAnimal->setBirthdate($faker->dateTimeBetween('-16 years'));
            $nacAnimal->setGender($faker->numberBetween($min = 1, $max = 2));
            $nacAnimal->setCatCohabitation($faker->boolean());
            $nacAnimal->setDogCohabitation($faker->boolean());
            $nacAnimal->setNacCohabitation($faker->boolean());
            $nacAnimal->setChildCohabitation($faker->boolean());
            $nacAnimal->setUnknownCohabitation($faker->boolean());
            $nacAnimal->setPicture($faker->unique()->nacImage());
            $nacAnimal->setStatus($faker->numberBetween($min = 1, $max = 4));
            $nacAnimal->setDescription($faker->nacDescription());
            $nacAnimal->setCreatedAt(new \DateTime());
            $nacAnimal->setSpecies($nacSpecies);

            // With shuffle we make random data but also unique
            /* shuffle($nacList);
            for ($r = 0; $r < self::NB_RACES; $r++) {

                $randomRace = $nacList[$r];
                $nacAnimal->setRace($randomRace);
            } */

            $nacAnimals[] = $nacAnimal;

            // We persist it
            $manager->persist($nacAnimal);
        }


        // Dogs for Animal Table

        $dogAnimals = [];

        for ($i = 1; $i <= self::NB_ANIMALS; $i++) {

            $dogAnimal = new Animal();
            // We fill the fields of our entity
            $dogAnimal->setName($faker->unique()->animalName());
            $dogAnimal->setBirthdate($faker->dateTimeBetween('-16 years'));
            $dogAnimal->setGender($faker->numberBetween($min = 1, $max = 2));
            $dogAnimal->setCatCohabitation($faker->boolean());
            $dogAnimal->setDogCohabitation($faker->boolean());
            $dogAnimal->setNacCohabitation($faker->boolean());
            $dogAnimal->setChildCohabitation($faker->boolean());
            $dogAnimal->setUnknownCohabitation($faker->boolean());
            $dogAnimal->setPicture($faker->unique()->dogImage());
            $dogAnimal->setStatus($faker->numberBetween($min = 1, $max = 4));
            $dogAnimal->setDescription($faker->unique()->dogDescription());
            $dogAnimal->setCreatedAt(new \DateTime());
            $dogAnimal->setSpecies($dogSpecies);

            // With shuffle we make random data but also unique
            shuffle($dogList);
            for ($r = 0; $r < self::NB_RACES; $r++) {

                $randomRace = $dogList[$r];
                $dogAnimal->setRace($randomRace);
            }

            $dogAnimals[] = $dogAnimal;

            // We persist it
            $manager->persist($dogAnimal);
        }

        // Cats for Animal Table

        $catAnimals = [];

        for ($i = 1; $i <= self::NB_ANIMALS; $i++) {

            $catAnimal = new Animal();
            // We fill the fields of our entity
            $catAnimal->setName($faker->unique()->animalName());
            $catAnimal->setBirthdate($faker->dateTimeBetween('-16 years'));
            $catAnimal->setGender($faker->numberBetween($min = 1, $max = 2));
            // The function numberBetween() allow to set a number only between the min and max values indicated
            $catAnimal->setCatCohabitation($faker->boolean());
            $catAnimal->setDogCohabitation($faker->boolean());
            $catAnimal->setNacCohabitation($faker->boolean());
            $catAnimal->setChildCohabitation($faker->boolean());
            $catAnimal->setUnknownCohabitation($faker->boolean());
            $catAnimal->setPicture($faker->unique()->catImage());
            $catAnimal->setStatus($faker->numberBetween($min = 1, $max = 4));
            $catAnimal->setDescription($faker->unique()->catDescription());
            $catAnimal->setCreatedAt(new \DateTime());
            $catAnimal->setSpecies($catSpecies);

            // With shuffle we make random data but also unique
            shuffle($catList);
            for ($r = 0; $r < self::NB_RACES; $r++) {
                // We search in our shuffled array
                $randomRace = $catList[$r];
                $catAnimal->setRace($randomRace);
            }

            $catAnimals[] = $catAnimal;

            // We persist it
            $manager->persist($catAnimal);
        }

        // Shelters
        $shelterList1 = [];

        $shelter1 = new Shelter();
        $shelter1->setName('Le Refuge des Patounes');
        $shelter1->setAddress('2 rue des chatons');
        $shelter1->setZip('17000');
        $shelter1->setCity('La Rochelle');
        $shelter1->setPhoneNumber('0635262245');
        $shelter1->setEmail('le-refuge-des-patounes@patounes.com');
        $shelter1->setPicture('shelters/shelter1.jpg');
        $shelter1->setCreatedAt(new \DateTime());
        $shelter1->setUser($patounes);

        shuffle($catAnimals);
        for ($r = 0; $r < 30; $r++) {
            $randomAnimal = $catAnimals[$r];
            $shelter1->addAnimal($randomAnimal);
        }
        shuffle($dogAnimals);
        for ($r = 0; $r < 30; $r++) {
            $randomAnimal = $dogAnimals[$r];
            $shelter1->addAnimal($randomAnimal);
        }
        shuffle($nacAnimals);
        for ($r = 0; $r < 30; $r++) {
            $randomAnimal = $nacAnimals[$r];
            $shelter1->addAnimal($randomAnimal);
        }

        $shelterList1[] = $shelter1;

        $manager->persist($shelter1);

        $shelterList2 = [];

        $shelter2 = new Shelter();
        $shelter2->setName('Les Chats Teignes');
        $shelter2->setAddress('85 rue des grosminets 54000 Nancy');
        $shelter2->setZip('54000');
        $shelter2->setCity('Nancy');
        $shelter2->setPhoneNumber('0666778899');
        $shelter2->setEmail('chats-teignes@chat.com');
        $shelter2->setPicture('shelters/shelter2.jpg');
        $shelter2->setCreatedAt(new \DateTime());
        $shelter2->setUser($chatsteignes);

        shuffle($catAnimals);
        for ($r = 0; $r < 10; $r++) {
            $randomAnimal = $catAnimals[$r];
            $shelter2->addAnimal($randomAnimal);
        }
        shuffle($dogAnimals);
        for ($r = 0; $r < 10; $r++) {
            $randomAnimal = $dogAnimals[$r];
            $shelter2->addAnimal($randomAnimal);
        }
        shuffle($nacAnimals);
        for ($r = 0; $r < 10; $r++) {
            $randomAnimal = $nacAnimals[$r];
            $shelter2->addAnimal($randomAnimal);
        }

        $shelterList2[] = $shelter2;

        $manager->persist($shelter2);

        $shelterList3 = [];

        $shelter3 = new Shelter();
        $shelter3->setName('Le refuge du Mordant');
        $shelter3->setAddress('77 avenue du port');
        $shelter3->setZip('54200');
        $shelter3->setCity('Toul');
        $shelter3->setPhoneNumber('0636224255');
        $shelter3->setEmail('refuge-mordant@refuge.com');
        $shelter3->setPicture('shelters/shelter3.jpg');
        $shelter3->setCreatedAt(new \DateTime());
        $shelter3->setUser($mordant);

        shuffle($catAnimals);
        for ($r = 0; $r < 10; $r++) {
            $randomAnimal = $catAnimals[$r];
            $shelter3->addAnimal($randomAnimal);
        }
        shuffle($dogAnimals);
        for ($r = 0; $r < 10; $r++) {
            $randomAnimal = $dogAnimals[$r];
            $shelter3->addAnimal($randomAnimal);
        }
        shuffle($nacAnimals);
        for ($r = 0; $r < 10; $r++) {
            $randomAnimal = $nacAnimals[$r];
            $shelter3->addAnimal($randomAnimal);
        }
        
        $shelterList3[] = $shelter3;
        
        $manager->persist($shelter3);

        // We flush
        $manager->flush();
    }
}
