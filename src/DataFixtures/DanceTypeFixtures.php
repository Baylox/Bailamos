<?php

namespace App\DataFixtures;

use App\Entity\DanceType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DanceTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $danceTypes = [
            [
                'name' => 'Bachata',
                'description' => 'Originaire de la République dominicaine, la Bachata est bien plus qu’une danse : c’est une expression culturelle profondément enracinée dans l’histoire et les émotions. Elle se caractérise par ses mouvements sensuels et ses pas simples, exécutés sur des rythmes romantiques et envoûtants. La Bachata se danse souvent en couple, mettant l’accent sur une connexion intime et harmonieuse entre les partenaires. Aujourd’hui, elle se décline en plusieurs styles, notamment la Bachata Dominicaine, plus rythmée, et la Bachata Moderne, influencée par des éléments de danse contemporaine. Elle est devenue incontournable dans les soirées latines à travers le monde.'
            ],
            [
                'name' => 'Salsa',
                'description' => 'La Salsa, véritable emblème des danses latino-américaines, est née de la fusion de divers styles musicaux cubains, comme le Son, le Mambo et le Cha-cha-cha. Dynamique et pleine de vitalité, cette danse est une célébration de la joie et de l’énergie. Les partenaires échangent des tours rapides, des jeux de pieds complexes et une improvisation qui reflète leur personnalité. La Salsa peut être dansée en couple ou en groupe, sous forme de Rueda de Casino, où les partenaires changent régulièrement dans un cercle dynamique. Elle est devenue un phénomène mondial, attirant aussi bien les amateurs que les passionnés, grâce à sa musique entraînante et son ambiance festive.'
            ],
            [
                'name' => 'Kizomba',
                'description' => 'Originaire d’Angola, la Kizomba est une danse africaine marquée par sa douceur et son intimité. Elle s’est développée à partir du Semba, une danse traditionnelle angolaise, en intégrant des influences modernes, notamment des rythmes électroniques. Connue pour ses mouvements fluides et sa connexion intense entre les partenaires, la Kizomba se distingue par une interprétation musicale qui met l’accent sur l’harmonie et la sensibilité. Danser la Kizomba, c’est avant tout partager un moment de communication non verbale, où chaque geste raconte une histoire. Aujourd’hui, elle a conquis les pistes de danse du monde entier, se mêlant parfois à d’autres styles comme l’Urban Kiz ou le Tarraxo, tout en conservant ses racines profondes.'
            ]
        ];

        foreach ($danceTypes as $data) {
            $danceType = new DanceType();
            $danceType->setName($data['name']);
            $danceType->setDescription($data['description']);
            $manager->persist($danceType);
        }

        $manager->flush();
    }
}

