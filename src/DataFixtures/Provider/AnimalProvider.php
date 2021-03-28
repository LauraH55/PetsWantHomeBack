<?php

namespace App\DataFixtures\Provider;

class AnimalProvider
{


    private $species = [

        'chat',
        'chien',
        'nac',

    ];

    private $catRace = [

        'Abyssin',
        'American Bobtail',
        'American curl',
        'American Wirehair',
        'American Shorthair',
        'Angora Turc',
        'Balinais',
        'Bengal',
        'Birman',
        'Bleu russe',
        'Bombay',
        'British Longhair',
        'British Shorthair',
        'Burmese',
        'Burmilla',
        'California Spangled',
        'California Rex',
        'Ceylan',
        'Chartreux',
        'Chausie',
        'Chinchilla Persan',
        'Cornish Rex',
        'Cymric',
        'Devon Rex',
        'Donskoy',
        'Européen',
        'Exotic',
        'German Rex',
        'Gouttière',
        'Havana Brown',
        'Highland Straight',
        'Himalayen',
        'Japanese Bobtail',
        'Javanais',
        'Korat',
        'LaPerm',
        'Maine Coon',
        'Manx',
        'Mau égyptien',
        'Munchkin',
        'Nebelung',
        'Norvégien',
        'Ocicat',
        'Oriental',
        'Persan',
        'Peterbald',
        'Pixiebob',
        'Ragamuffin',
        'Ragdoll',
        'Safari',
        'Savannah',
        'Scottish Fold',
        'Selkirk Rex',
        'Siamois',
        'Sibérien',
        'Singapura',
        'Snowshoe',
        'Sokoke',
        'Somali',
        'Sphynx',
        'Thaï',
        'Tiffany',
        'Tonkinois',
        'Toyger',
        'Turkish Van',
        'York Chocolat'

    ];

    private $dogRace = [

        'Affenpinscher',
        'Airedale Terrier',
        'Akita américain',
        'Akita Inu',
        'Ariégeois',
        'Azawakh',
        'Barbet',
        'Barbu Tchèque',
        'Barzoï',
        'Basenji',
        'Basset',
        'Beagle',
        'Beagle-Harrier',
        'Bearded Collie',
        'Beauceron',
        'Belington Terrier',
        'Berger Allemand',
        'Berger Australien',
        'Berger Belge',
        'Berger Finnois de Laponie',
        'Berger Suisse',
        'Bichon à poil frisé',
        'Bichon Bolonais',
        'Bichon Havanais',
        'Bichon Maltais',
        'Billy',
        'Bleu de Casgogne',
        'Bobtail',
        'Boerboel',
        'Border Collie',
        'Border Terrier',
        'Bouledogue Français',
        'Bouvier',
        'Boxer',
        'Braque Allemand',
        'Briquet Griffon Vendéen',
        'Broholmer',
        'Buhund Norvégien',
        'Bull Terrier',
        'Bulldog',
        'Bullmastiff',
        'Cane Corso',
        'Caniche',
        'Carlin',
        'Chien-loup',
        'Chihuahua',
        'Chow-Chow',
        'Cocker',
        'Dalmatien',
        'Dobermann',
        'Dogue allemand',
        'Dogue argentin',
        'Dogue du Tibet',
        'Épagneul breton',
        'Épagneul français',
        'Eurasier',
        'Fox-Terrier',
        'Golden Retriever',
        'Grand bouvier suisse',
        'Griffon belge',
        'Griffon bruxellois',
        'Husky Sibérien',
        'Hovawart',
        'Hokkaido Ken',
        'Irish Terrier',
        'Jack Russell Terrier',
        'Jagdterrier',
        'Kai',
        'Kelpie',
        'Kishu',
        'Komondor',
        'Labrador Retriever',
        'Laika de Sibérie occidentale',
        'Laika de Sibérie orientale',
        'Chien esquimau canadien',
        'Leonberger',
        'Lévrier afghan',
        'Malamute de l\'Alaska',
        'Manchester Terrier',
        'Mastiff',
        'Mudi',
        'Norfolk Terrier',
        'Otterhound',
        'Petit Münsterländer',
        'Pinscher',
        'Rottweiler',
        'Saint-Bernard',
        'Saluki',
        'Samoyède',
        'Schnauzer',
        'Scottish Terrier',
        'Setter anglais',
        'Shar Pei',
        'Shiba Inu',
        'Shih Tzu',
        'Spinone',
        'Spitz allemand',
        'Teckel',
        'Terre-Neuve',
        'Terrier',
        'Welsh Corgi',
        'Whippet',
        'Yorkshire Terrier',

    ];

    private $nacRace = [

        'Lapin',
        'Lapin nain',
        'Furet',
        'Poule',
        'Perroquet',
        'Oiseau',
        'Caméléon',
        'Souris',
        'Rat',
        'Reptile',
        
    ];

    private $animalName = [

        'Lika',
        'Louky',
        'Lecko',
        'Loustick',
        'Lasko',
        'Mabel',
        'Maddock',
        'Mooky',
        'Maiden',
        'Maya',
        'Elka',
        'Eros',
        'Ezio', 
        'Erode',
        'Elfy',
        'Stella',
        'Spider',
        'Simba',
        'Sally',
        'Shelby',
        'Oreo',
        'Olaf',
        'Odin',
        'Oziris',
        'Olympea',
        'Roxy',
        'Rouky',
        'Ripley',
        'Riff',
        'Rufus',
        'Aiko',
        'Attila',
        'Arès',
        'Alaska',
        'Anouk',
        'Balto',
        'Bouba',
        'Bella',
        'Baloo',
        'Blue',
        'Chanel',
        'Charlie',
        'César',
        'Chuck',
        'Calypso',
        'Peach',
        'Pongo',
        'Perdita',
        'Pakita',
        'Paxton',
        'Chouquette',
        'Vlad',
        'Nono',
        'Babor',
        'Chiakix',
        'Cachou',
        'Minette',
        'Calina',
        'Mars',
        'Comète',
        'Kikoo',
        'Cookie',
        'Clochette',
        'Max',
        'Chips',
        'Friskette',
        'Mina',
        'Scarlett',
        'Tatum',
        'Mercure',
        'Vénus',
        'Luna',
        'Lilie',
        'Chamallow',
        'Mistrigri',
        'Jarod',
        'Spirit',
        'Chichi',
        'Artémis',
        'Rajah',
        'June',
        'Nala',
        'Neige',
        'Red',
        'Pattenrond',
        'Aslan',
        'Toto',
        'Pepsi',
        'Taya',
        'Navi',
        'Zelda',
        'Link',

    ];

    private $catImage = [
        'cats/abyssin.jpg',
        'cats/abyssin1.jpg',
        'cats/american-curl.jpg',
        'cats/angora-turc.jpg',
        'cats/bengal.jpg',
        'cats/birman.jpg',
        'cats/black-cat.jpg',
        'cats/bleu-russe.jpg',
        'cats/burmilla.jpg',
        'cats/ceylan.jpg',
        'cats/chartreux.jpg',
        'cats/chat-roux.jpg',
        'cats/chat-roux1.jpg',
        'cats/chat-tigre.jpg',
        'cats/chaton.jpg',
        'cats/chaton1.jpg',
        'cats/chaton2.jpg',
        'cats/europeen.jpg',
        'cats/europeen1.jpg',
        'cats/gouttiere.jpg',
        'cats/gouttiere1.jpg',
        'cats/gouttiere2.jpg',
        'cats/main-coon.jpg',
        'cats/manx.jpg',
        'cats/norvegien.jpg',
        'cats/ragdoll.jpg',
        'cats/roux.jpg',
        'cats/savannah.jpg',
        'cats/siamois.jpg',
        'cats/siberien.jpg',
        'cats/sphynx.jpg',
    ];

    private $dogImage = [
        'dogs/akita-inu.jpg',
        'dogs/akita.jpg',
        'dogs/beagle.jpg',
        'dogs/beauceron.jpg',
        'dogs/berger-allemand-noir.jpg',
        'dogs/berger-blanc-suisse.jpg',
        'dogs/border.jpg',
        'dogs/braque-allemand.jpg',
        'dogs/braque-de-weimar.jpg',
        'dogs/chien-loup.jpg',
        'dogs/chihuahua.jpg',
        'dogs/chow-chow.jpg',
        'dogs/cocker-chiot.jpg',
        'dogs/corgi1.jpg',
        'dogs/corgy.jpg',
        'dogs/dalmatien.jpg',
        'dogs/epagneul.jpg',
        'dogs/eurasier-chiot.jpg',
        'dogs/eurasier.jpg',
        'dogs/golden-retriever.jpg',
        'dogs/husky.jpg',
        'dogs/husky1.jpg',
        'dogs/kishu.jpg',
        'dogs/labrador-chiot.jpg',
        'dogs/labrador.jpg',
        'dogs/pit-bull-chiot.jpg',
        'dogs/pit-bull.jpg',
        'dogs/shelter.jpg',
        'dogs/spitz.jpg',
        'dogs/teckel.jpg',
    ];

    private $nacImage = [
        'nacs/cacatoes.jpg',
        'nacs/cacatoes1.jpg',
        'nacs/cacatoes2.jpg',
        'nacs/cacatoes3.jpg',
        'nacs/cacatoes4.jpg',
        'nacs/cameleon.jpg',
        'nacs/cameleon1.jpg',
        'nacs/canari.jpg',
        'nacs/canari1.jpg',
        'nacs/chinchilla.jpg',
        'nacs/cochon-d-inde.jpg',
        'nacs/cochon-d-inde1.jpg',
        'nacs/furet.jpg',
        'nacs/furet1.jpg',
        'nacs/furet2.jpg',
        'nacs/furet3.jpg',
        'nacs/furet4.jpg',
        'nacs/gerbille.jpg',
        'nacs/hamster.jpg',
        'nacs/lapin-nain.jpg',
        'nacs/lapin-nain1.jpg',
        'nacs/lapin-nain2.jpg',
        'nacs/lapin-nain3.jpg',
        'nacs/lapin-nain4.jpg',
        'nacs/lapin-nain5.jpg',
        'nacs/lapin-nain6.jpg',
        'nacs/lapin.jpg',
        'nacs/perroquet.jpg',
        'nacs/poule.jpg',
        'nacs/souris.jpg',
    ];

    private $image = 'default_image_01.png';



    // Here we make all our functions to return our data from the provider to use in AppFixtures

    public function species()
    {
        return $this->species[array_rand($this->species)];
    }

    public function catRace()
    {
        return $this->catRace[array_rand($this->catRace)];
    }

    public function dogRace()
    {
        return $this->dogRace[array_rand($this->dogRace)];
    }

    public function nacRace()
    {
        return $this->nacRace[array_rand($this->nacRace)];
    }

    public function catImage()
    {
        return $this->catImage[array_rand($this->catImage)];
    }

    public function dogImage()
    {
        return $this->dogImage[array_rand($this->dogImage)];
    }

    public function nacImage()
    {
        return $this->nacImage[array_rand($this->nacImage)];
    }

    public function image()
    {
        return $this->image;
    }

    public function animalName()
    {
        return $this->animalName[array_rand($this->animalName)];
    }
}