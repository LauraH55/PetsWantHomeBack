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

    private $catDescription = [
        
        'Petit chat coquin qui joue avec tout ce qui bouge, pucé et vacciné.',
        'Chat paresseux et un peu capricieux, il faut le laisser venir de lui-même pour jouer ou le caresser.',
        'Très énergique, il lui faut de l\'espace pour avoir de quoi faire de l\'activité physique. Appartement déconseillé pour ce chat !',
        'Très affectueux, il va falloir lui donner beaucoup d\'attention.',
        'Chat un peu sauvage auquel il faudra laisser le temps de s\'adapter à son environnement et à sa nouvelle famille.',
        'Adore se cacher dans les moindres recoin et se mettre en mode chasseur, il faudra être vigilant avec ce petit chat espiègle pour pas qu\'il ne se cache dans un endroit risqué !',
        'Saute partout sans jamais se fatiguer, il vous faudra une bonne dose d\'énergie pour le suivre dans ses quarts d\'heure de folie',
        'Adore faire la sieste, très gourmand, veillez à ne pas laisser trainer de nourriture si vous craquez pour cette boule de poil !',
        'Ce chat est malvoyant, il serait donc préférable qu\'il vive en appartement et il faudra le guider. Il est très câlin et joueur !',
        'Chat très bavard et facétieux, aux rituels peu communs, il faudra l\'adopter avec son doudou !',
        
        
    ];

    private $descriptionDog = [

        'Chien affectueux, très joueur, qui adore les balades',
        'Petit chien qui a son caractère, mais qui adore les caresses',
        'Chien qui a besoin d\'espace et de sorties régulières',
        'Adorable, aime jouer, se balader, mais peut aussi bien rester sur le canapé',
        'Chien qui a du caractère et qui fait des bêtises s\'il n\'est pas stimulé',
        'Très énergique, le compagnon idéal des sportifs, il vous accompagnera dans vos sorties running avec plaisir',
        'Chien calme et posé, très bon caractère, s\'entend bien avec les enfants',
        'Attention, chien vif, affectueux, il s\'entend avec les enfants, mais attention aux touts petits',
        'Un peu foufou, très joueur et très gourmand, attention à ne pas laisser traîner de la nourriture',
        'Chien adorable, mais craintif, il aura besoin d\'être rassuré par sa famille',
        'Une fois en confiance il est très câlin, voire fusionnel avec son humain.',
        'Chien de caractère. Il aura besoin d\'un maître connaissant bien les chiens et capable de le gérer.',
        'Je me révèlerai être parfait pour vivre en maison ou appartement',
        'Aura besoin d\'adoptants connaisseurs, motivés et prêts à s\'investir dans l\'éducation.',
        'Ce chien est agréable, câlin, plutôt calme en intérieur et dynamique à l\'extérieur, et il sera à coup sûr le compagnon idéal de toute la famille.',
        'Ce jeune chien est dynamique et affectueux, il a besoin de temps pour faire confiance mais se montre ensuite sociable et joueur',
        'Il faudra poursuivre son éducation, il fait encore quelques dégâts lors des absences et se montre protecteur de son environnement',
        'Le moindre rien me fait peur, je commence tout juste à comprendre que les humains et les promenades ça peut être cool !',
        'C\'est un chien câlin, joueur, dynamique, qui sera ravi de partir avec vous pour de longues balades',
        'De nature très expressive, il n\'aime pas la solitude. Terrain bien clos obligatoire car j\'ai tendance à prendre la poudre d\'escampette.',
        'Très joueuse avec ses congénères elle est à l\'aise en leur présence et l\'aide à prendre confiance.',
        'C\'est un jeune chien qui aimerait se dépenser et découvrir le monde avec une famille patiente.',
        'Un brin sensible, il lui faudra un environnement stable et calme. Fait de la protection de ressources sur la nourriture, un travail est à prévoir. Il est réactif en laisse (sur les chiens).',
        'Chien plein de bonne humeur. Doux, calme et bien élevé, il recherche une famille aussi gentille que lui.',
        'Chien joueur, calme et propre. Il adore les balades et il a du rappel, car il est baladé sans laisse.'
        
        



    ];



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