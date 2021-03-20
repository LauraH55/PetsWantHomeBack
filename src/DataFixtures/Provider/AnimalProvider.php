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
        'American Staffordshire Terrier',
        'Ancien chien d\'arrêt Danois',
        'Anglo-Français de petite vénerie',
        'Ariégeois',
        'Azawakh',
        'Barbet',
        'Barbu Tchèque',
        'Barzoï',
        'Basenji',
        'Basset Artésien Normand',
        'Basset de Westphalie',
        'Basset des Alpes',
        'Basset fauve de Bretagne',
        'Basset Hound',
        'Beagle',
        'Beagle-Harrier',
        'Bearded Collie',
        'Beauceron',
        'Belington Terrier',
        'Berger Allemand',
        'Berger Australien',
        'Berger Belge',
        'Berger blanc Suisse',
        'Berger Catalan',
        'Berger d\'Anatolie',
        'Berger d\'Asie centrale',
        'Berger d\Islande',
        'Berger de Bergame',
        'Berger de Bosnie-Herzégovine et de Croatie',
        'Berger de Brie',
        'Berger de l\'Atlas',
        'Berger de Maremme et des Abruzzes',
        'Berger de Picardie',
        'Berger de Russie',
        'Berger des Pyrénées',
        'Berger des Shetland',
        'Berger du Caucase',
        'Berger du massif du Karst',
        'Berger Finnois de Laponie',
        'Berger Hollandais',
        'Berger Polonais de plaine',
        'Berger polonais de Podhale',
        'Berger Portugais',
        'Berger Yougoslave',
        'Bichon à poil frisé',
        'Bichon Bolonais',
        'Bichon Havanais',
        'Bichon Maltais',
        'Billy',
        'Black and Tan Coonhound',
        'Bleu de Casgogne',
        'Bobtail',
        'Boerboel',
        'Border Collie',
        'Border Terrier',
        'Bouledogue Français',
        'Bouvier Bernois',
        'Bouvier d\'Appenzell',
        'Bouvier d\'Australie',
        'Bouvier de l\'Entlebuch',
        'Bouvier des Ardennes',
        'Bouvier des Flandres',
        'Boxer',
        'Brachet Allemand',
        'Brachet Autrichien noir et feu',
        'Brachet de Styrie',
        'Brachet Polonais',
        'Brachet Tyrolien',
        'Braque Allemand',
        'Braque d\'Auvergne',
        'Braque de Burgos',
        'Braque de l\'Ariège',
        'Braque de Weimar',
        'Braque du Bourbonnais',
        'Braque Français',
        'Braque Hongrois',
        'Braque Italien',
        'Braque Saint-Germain',
        'Braque Slovaque',
        'Briquet Griffon Vendéen',
        'Broholmer',
        'Buhund Norvégien',
        'Bull Terrier',
        'Bulldog',
        'Bullmastiff',

    ];

    private $nacRace = [

        'Lapin',
        'Lapin nain',
        'Poule',
        'Perroquet',
        'Oiseau',
        'Caméléon',
        'Serpent',
        'Souris',
        'Rat',
        'Reptile',
        'Poisson',

    ];

    private $image = 'default_image_01.png';

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

    public function image()
    {
        return $this->image;
    }
}