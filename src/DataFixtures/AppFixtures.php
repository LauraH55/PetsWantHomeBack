<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Race;
use App\Entity\Animal;
use App\Entity\Shelter;
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
        $this->connection = $connection;
    }

    const NB_ANIMALS = 30;
    const NB_SPECIES = 3;
    const NB_RACES = 9;

    private function truncate()
    {
        $animals = $this->connection->executeQuery('SET foreign_key_checks = 0');

        $animals = $this->connection->executeQuery('TRUNCATE TABLE animal');
        $animals = $this->connection->executeQuery('TRUNCATE TABLE race');
        $animals = $this->connection->executeQuery('TRUNCATE TABLE shelter');
    }

    public function load(ObjectManager $manager)
    {

        $this->truncate();

        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new AnimalProvider());

        $catList = [];

        for ($i = 0; $i < self::NB_RACES; $i++) {

            $cats = new Race();
            $cats->setCreatedAt(new \DateTime());
            $cats->setName($faker->unique()->catRace());
            $cats->setSpecies(1);
            
            
            $catList[] = $cats;

            $manager->persist($cats);
        };

        $dogList = [];

        for ($i = 0; $i < self::NB_RACES; $i++) {

            $dogs = new Race();

            $dogs->setCreatedAt(new \DateTime());
            $dogs->setName($faker->unique()->dogRace());
            $dogs->setSpecies(2);

            $dogList[] = $dogs;

            $manager->persist($dogs);
        };

        $nacList = [];

        for ($i = 0; $i < self::NB_RACES; $i++) {

            $nacs = new Race();

            $nacs->setCreatedAt(new \DateTime());
            $nacs->setName($faker->unique()->nacRace());
            $nacs->setSpecies(3);

            $nacList[] = $nacs;

            $manager->persist($nacs);
        };

        for ($i = 1; $i <= self::NB_ANIMALS; $i++) {
            $animal = new Animal();
            $animal->setName($faker->firstname);
            $animal->setBirthdate($faker->dateTimeBetween('-20 years'));
            $animal->setGender($faker->numberBetween($min = 1, $max = 2));
            $animal->setCohabitation($faker->numberBetween($min = 1, $max = 4));
            $animal->setPicture($faker->image());
            $animal->setStatus($faker->numberBetween($min = 1, $max = 4));
            $animal->setDescription($faker->text());
            $animal->setCreatedAt(new \DateTime());

            shuffle($catList);
            for ($r = 0; $r < self::NB_RACES; $r++) {

                $randomRace = $catList[$r];
                $animal->setRace($randomRace);
            }

            $manager->persist($animal);
        }

        for ($i = 1; $i <= self::NB_ANIMALS; $i++) {
            $animal = new Animal();
            $animal->setName($faker->firstname);
            $animal->setBirthdate($faker->dateTimeBetween('-20 years'));
            $animal->setGender($faker->numberBetween($min = 1, $max = 2));
            $animal->setCohabitation($faker->numberBetween($min = 1, $max = 4));
            $animal->setPicture($faker->image());
            $animal->setStatus($faker->numberBetween($min = 1, $max = 4));
            $animal->setDescription($faker->text());
            $animal->setCreatedAt(new \DateTime());

            shuffle($dogList);
            for ($r = 0; $r < self::NB_RACES; $r++) {

                $randomRace = $dogList[$r];
                $animal->setRace($randomRace);
            }

            $manager->persist($animal);
        }

        for ($i = 1; $i <= self::NB_ANIMALS; $i++) {
            $animal = new Animal();
            $animal->setName($faker->firstname);
            $animal->setBirthdate($faker->dateTimeBetween('-20 years'));
            $animal->setGender($faker->numberBetween($min = 1, $max = 2));
            $animal->setCohabitation($faker->numberBetween($min = 1, $max = 4));
            $animal->setPicture($faker->image());
            $animal->setStatus($faker->numberBetween($min = 1, $max = 4));
            $animal->setDescription($faker->text());
            $animal->setCreatedAt(new \DateTime());

            shuffle($nacList);
            for ($r = 0; $r < self::NB_RACES; $r++) {

                $randomRace = $nacList[$r];
                $animal->setRace($randomRace);
            }

            $manager->persist($animal);
        }



        $manager->flush();
    }
}