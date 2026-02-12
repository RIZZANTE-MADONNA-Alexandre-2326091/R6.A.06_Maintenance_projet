<?php

namespace App\DataFixtures;

use App\Entity\Championnat;
use App\Entity\Competition;
use App\Entity\Epreuve;
use App\Entity\Sport;
use App\Enum\SportTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ========== SPORTS ==========

        // Sports individuels
        $athletisme = new Sport();
        $athletisme->setName('Athlétisme');
        $athletisme->setType(SportTypeEnum::individuel);
        $manager->persist($athletisme);

        $natation = new Sport();
        $natation->setName('Natation');
        $natation->setType(SportTypeEnum::individuel);
        $manager->persist($natation);

        $tennis = new Sport();
        $tennis->setName('Tennis');
        $tennis->setType(SportTypeEnum::individuel);
        $manager->persist($tennis);

        $judo = new Sport();
        $judo->setName('Judo');
        $judo->setType(SportTypeEnum::individuel);
        $manager->persist($judo);

        $badminton = new Sport();
        $badminton->setName('Badminton');
        $badminton->setType(SportTypeEnum::individuel);
        $manager->persist($badminton);

        // Sports d'équipe
        $football = new Sport();
        $football->setName('Football');
        $football->setType(SportTypeEnum::equipe);
        $manager->persist($football);

        $basketball = new Sport();
        $basketball->setName('Basketball');
        $basketball->setType(SportTypeEnum::equipe);
        $manager->persist($basketball);

        $volleyball = new Sport();
        $volleyball->setName('Volleyball');
        $volleyball->setType(SportTypeEnum::equipe);
        $manager->persist($volleyball);

        $handball = new Sport();
        $handball->setName('Handball');
        $handball->setType(SportTypeEnum::equipe);
        $manager->persist($handball);

        $rugby = new Sport();
        $rugby->setName('Rugby');
        $rugby->setType(SportTypeEnum::equipe);
        $manager->persist($rugby);

        // Sports individuels et équipe
        $relais = new Sport();
        $relais->setName('Relais 4x100m');
        $relais->setType(SportTypeEnum::indiEquipe);
        $manager->persist($relais);

        $tennisDouble = new Sport();
        $tennisDouble->setName('Tennis en double');
        $tennisDouble->setType(SportTypeEnum::indiEquipe);
        $manager->persist($tennisDouble);

        // ========== CHAMPIONNATS ==========

        $ugselBretagne = new Championnat();
        $ugselBretagne->setName('UGSEL Bretagne 2025-2026');
        $manager->persist($ugselBretagne);

        $ugselNational = new Championnat();
        $ugselNational->setName('UGSEL National 2025-2026');
        $manager->persist($ugselNational);

        $champDepartemental = new Championnat();
        $champDepartemental->setName('Championnat Départemental 56');
        $manager->persist($champDepartemental);

        // ========== COMPETITIONS ==========

        // Compétitions UGSEL Bretagne
        $compFootBretagne = new Competition();
        $compFootBretagne->setName('Football Collèges - Bretagne');
        $compFootBretagne->setChampionnat($ugselBretagne);
        $manager->persist($compFootBretagne);

        $compBasketBretagne = new Competition();
        $compBasketBretagne->setName('Basketball Lycées - Bretagne');
        $compBasketBretagne->setChampionnat($ugselBretagne);
        $manager->persist($compBasketBretagne);

        $compAthletismeBretagne = new Competition();
        $compAthletismeBretagne->setName('Athlétisme Cross - Bretagne');
        $compAthletismeBretagne->setChampionnat($ugselBretagne);
        $manager->persist($compAthletismeBretagne);

        // Compétitions UGSEL National
        $compFootNational = new Competition();
        $compFootNational->setName('Championnat de France Football');
        $compFootNational->setChampionnat($ugselNational);
        $manager->persist($compFootNational);

        $compNatationNational = new Competition();
        $compNatationNational->setName('Championnat de France Natation');
        $compNatationNational->setChampionnat($ugselNational);
        $manager->persist($compNatationNational);

        // Compétitions Départementales
        $compHandball56 = new Competition();
        $compHandball56->setName('Handball Minimes - 56');
        $compHandball56->setChampionnat($champDepartemental);
        $manager->persist($compHandball56);

        $compJudo56 = new Competition();
        $compJudo56->setName('Judo Individuel - 56');
        $compJudo56->setChampionnat($champDepartemental);
        $manager->persist($compJudo56);

        // ========== EPREUVES ==========

        // Épreuves Football Bretagne
        $epreuveFootMinimes = new Epreuve();
        $epreuveFootMinimes->setName('Football Minimes Garçons');
        $epreuveFootMinimes->setCompetition($compFootBretagne);
        $epreuveFootMinimes->setSport($football);
        $manager->persist($epreuveFootMinimes);

        $epreuveFootCadets = new Epreuve();
        $epreuveFootCadets->setName('Football Cadets Garçons');
        $epreuveFootCadets->setCompetition($compFootBretagne);
        $epreuveFootCadets->setSport($football);
        $manager->persist($epreuveFootCadets);

        // Épreuves Basketball Bretagne
        $epreuveBasketFilles = new Epreuve();
        $epreuveBasketFilles->setName('Basketball Filles');
        $epreuveBasketFilles->setCompetition($compBasketBretagne);
        $epreuveBasketFilles->setSport($basketball);
        $manager->persist($epreuveBasketFilles);

        $epreuveBasketGarcons = new Epreuve();
        $epreuveBasketGarcons->setName('Basketball Garçons');
        $epreuveBasketGarcons->setCompetition($compBasketBretagne);
        $epreuveBasketGarcons->setSport($basketball);
        $manager->persist($epreuveBasketGarcons);

        // Épreuves Athlétisme Bretagne
        $epreuve100m = new Epreuve();
        $epreuve100m->setName('100m Sprint');
        $epreuve100m->setCompetition($compAthletismeBretagne);
        $epreuve100m->setSport($athletisme);
        $manager->persist($epreuve100m);

        $epreuve400m = new Epreuve();
        $epreuve400m->setName('400m');
        $epreuve400m->setCompetition($compAthletismeBretagne);
        $epreuve400m->setSport($athletisme);
        $manager->persist($epreuve400m);

        $epreuveCross = new Epreuve();
        $epreuveCross->setName('Cross Country 3km');
        $epreuveCross->setCompetition($compAthletismeBretagne);
        $epreuveCross->setSport($athletisme);
        $manager->persist($epreuveCross);

        // Épreuves Natation National
        $epreuve50mLibre = new Epreuve();
        $epreuve50mLibre->setName('50m Nage Libre');
        $epreuve50mLibre->setCompetition($compNatationNational);
        $epreuve50mLibre->setSport($natation);
        $manager->persist($epreuve50mLibre);

        $epreuve100mDos = new Epreuve();
        $epreuve100mDos->setName('100m Dos');
        $epreuve100mDos->setCompetition($compNatationNational);
        $epreuve100mDos->setSport($natation);
        $manager->persist($epreuve100mDos);

        $epreuve200mPapillon = new Epreuve();
        $epreuve200mPapillon->setName('200m Papillon');
        $epreuve200mPapillon->setCompetition($compNatationNational);
        $epreuve200mPapillon->setSport($natation);
        $manager->persist($epreuve200mPapillon);

        // Épreuves Handball 56
        $epreuveHandMinimes = new Epreuve();
        $epreuveHandMinimes->setName('Handball Minimes Mixte');
        $epreuveHandMinimes->setCompetition($compHandball56);
        $epreuveHandMinimes->setSport($handball);
        $manager->persist($epreuveHandMinimes);

        // Épreuves Judo 56
        $epreuveJudo60kg = new Epreuve();
        $epreuveJudo60kg->setName('Judo -60kg');
        $epreuveJudo60kg->setCompetition($compJudo56);
        $epreuveJudo60kg->setSport($judo);
        $manager->persist($epreuveJudo60kg);

        $epreuveJudo73kg = new Epreuve();
        $epreuveJudo73kg->setName('Judo -73kg');
        $epreuveJudo73kg->setCompetition($compJudo56);
        $epreuveJudo73kg->setSport($judo);
        $manager->persist($epreuveJudo73kg);

        $manager->flush();

        echo "✅ Fixtures chargées avec succès !\n";
        echo "   - 12 Sports créés\n";
        echo "   - 3 Championnats créés\n";
        echo "   - 7 Compétitions créées\n";
        echo "   - 15 Épreuves créées\n";
    }
}
