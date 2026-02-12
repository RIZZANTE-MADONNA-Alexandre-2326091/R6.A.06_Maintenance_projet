<?php

use App\Kernel;
use App\Entity\Sport;
use App\Entity\Championnat;
use App\Entity\Competition;
use App\Entity\Epreuve;
use App\Enum\SportTypeEnum;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/backend/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/backend/.env');

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();
$container = $kernel->getContainer();
$entityManager = $container->get('doctrine')->getManager();

// Helper to truncate tables
function truncateTable($em, $class) {
    $cmd = $em->getClassMetadata($class);
    $connection = $em->getConnection();
    $dbPlatform = $connection->getDatabasePlatform();
    $connection->executeQuery('TRUNCATE TABLE '.$cmd->getTableName().' CASCADE');
}

echo "Cleaning database...\n";
// Truncate in order to respect foreign keys
truncateTable($entityManager, Epreuve::class);
truncateTable($entityManager, Competition::class);
truncateTable($entityManager, Championnat::class);
truncateTable($entityManager, Sport::class);

echo "Creating Sports...\n";
$sports = [];

$sportData = [
    ['Football', SportTypeEnum::equipe],
    ['Basketball', SportTypeEnum::equipe],
    ['Handball', SportTypeEnum::equipe],
    ['Volley-ball', SportTypeEnum::equipe],
    ['Rugby', SportTypeEnum::equipe],
    ['Athlétisme', SportTypeEnum::individuel],
    ['Natation', SportTypeEnum::individuel],
    ['Gymnastique', SportTypeEnum::individuel],
    ['Judo', SportTypeEnum::individuel],
    ['Cross-Country', SportTypeEnum::individuel],
    ['Badminton', SportTypeEnum::indiEquipe],
    ['Tennis de Table', SportTypeEnum::indiEquipe],
    ['Tennis', SportTypeEnum::indiEquipe],
];

foreach ($sportData as $data) {
    $sport = new Sport();
    $sport->setName($data[0]);
    $sport->setType($data[1]);
    $entityManager->persist($sport);
    $sports[$data[0]] = $sport;
    echo " - Added Sport: {$data[0]}\n";
}

echo "Creating Championnats...\n";

// Championnat 1: Départemental
$dep35 = new Championnat();
$dep35->setName('Championnat Départemental 35 (2025-2026)');
$entityManager->persist($dep35);

// Championnat 2: Régional
$regBzh = new Championnat();
$regBzh->setName('Championnat Régional Bretagne (2025-2026)');
$entityManager->persist($regBzh);

// Championnat 3: National
$nat = new Championnat();
$nat->setName('Championnat National UGSEL (2025-2026)');
$entityManager->persist($nat);

echo "Creating Competitions and Epreuves...\n";

// --- Competitions for Dep 35 ---
$compFoot = new Competition();
$compFoot->setName('Tournoi Football Minimes Garçons');
$compFoot->setChampionnat($dep35);
$entityManager->persist($compFoot);

$epreuve1 = new Epreuve();
$epreuve1->setName('Phase de Poule A');
$epreuve1->setCompetition($compFoot);
$epreuve1->setSport($sports['Football']);
$entityManager->persist($epreuve1);

$epreuve2 = new Epreuve();
$epreuve2->setName('Phase de Poule B');
$epreuve2->setCompetition($compFoot);
$epreuve2->setSport($sports['Football']);
$entityManager->persist($epreuve2);


$compBad = new Competition();
$compBad->setName('Open Badminton Benjamins/Minimes');
$compBad->setChampionnat($dep35);
$entityManager->persist($compBad);

$epreuve3 = new Epreuve();
$epreuve3->setName('Simples Hommes');
$epreuve3->setCompetition($compBad);
$epreuve3->setSport($sports['Badminton']);
$entityManager->persist($epreuve3);

$epreuve4 = new Epreuve();
$epreuve4->setName('Doubles Mixtes');
$epreuve4->setCompetition($compBad);
$epreuve4->setSport($sports['Badminton']);
$entityManager->persist($epreuve4);


// --- Competitions for Regional ---
$compCross = new Competition();
$compCross->setName('Finale Régionale Cross-Country');
$compCross->setChampionnat($regBzh);
$entityManager->persist($compCross);

$epreuveCross1 = new Epreuve();
$epreuveCross1->setName('Course Benjamines (2km)');
$epreuveCross1->setCompetition($compCross);
$epreuveCross1->setSport($sports['Cross-Country']);
$entityManager->persist($epreuveCross1);

$epreuveCross2 = new Epreuve();
$epreuveCross2->setName('Course Minimes Garçons (3.5km)');
$epreuveCross2->setCompetition($compCross);
$epreuveCross2->setSport($sports['Cross-Country']);
$entityManager->persist($epreuveCross2);


$compNat = new Competition();
$compNat->setName('Meeting Natation Élite');
$compNat->setChampionnat($regBzh);
$entityManager->persist($compNat);

$epreuveNat1 = new Epreuve();
$epreuveNat1->setName('50m Nage Libre');
$epreuveNat1->setCompetition($compNat);
$epreuveNat1->setSport($sports['Natation']);
$entityManager->persist($epreuveNat1);


// --- Competitions for National ---
$compAthle = new Competition();
$compAthle->setName('Championnat de France Athlétisme Estival');
$compAthle->setChampionnat($nat);
$entityManager->persist($compAthle);

$epreuveAthle1 = new Epreuve();
$epreuveAthle1->setName('Finale 100m Haies');
$epreuveAthle1->setCompetition($compAthle);
$epreuveAthle1->setSport($sports['Athlétisme']);
$entityManager->persist($epreuveAthle1);

$epreuveAthle2 = new Epreuve();
$epreuveAthle2->setName('Concours Saut en Longueur');
$epreuveAthle2->setCompetition($compAthle);
$epreuveAthle2->setSport($sports['Athlétisme']);
$entityManager->persist($epreuveAthle2);

$entityManager->flush();

echo "Data loaded successfully!\n";
