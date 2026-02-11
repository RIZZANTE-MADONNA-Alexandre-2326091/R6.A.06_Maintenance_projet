export const SPORTS = [
  { id: 1, name: 'Badminton', icon: 'Trophy' },
  { id: 2, name: 'Natation', icon: 'Waves' },
  { id: 3, name: 'Athlétisme', icon: 'Activity' },
  { id: 4, name: 'Gymnastique', icon: 'Dumbbell' },
  { id: 5, name: 'Escalade', icon: 'Mountain' },
  { id: 6, name: 'Judo', icon: 'Swords' },
  { id: 7, name: 'Tennis de Table', icon: 'Target' },
];

export const CHAMPIONNATS = [
  {
    id: 3,
    sportId: 1,
    libelle: 'Badminton B/M Equipe',
    dateDeb: '2025-11-15',
    lieu: 'Rennes',
    statut: 'Inscriptions fermées',
    description: 'Championnat par équipe pour les catégories Benjamins et Minimes.',
  },
  {
    id: 4,
    sportId: 1,
    libelle: 'Badminton Double C/J',
    dateDeb: '2025-12-01',
    lieu: 'Saint-Malo',
    statut: 'Inscriptions ouvertes',
    description: 'Championnat double pour Cadets et Juniors.',
  },
  {
    id: 10,
    sportId: 2,
    libelle: 'Natation ELITE',
    dateDeb: '2025-12-18',
    lieu: 'Cesson-Sévigné',
    statut: 'En cours',
    description: 'Compétition élite ouverte à toutes les catégories.',
  },
  {
    id: 11,
    sportId: 5,
    libelle: 'Escalade Bloc',
    dateDeb: '2026-01-10',
    lieu: 'Bruz',
    statut: 'A venir',
    description: 'Compétition de bloc départementale.',
  },
    {
    id: 69,
    sportId: 6,
    libelle: 'Judo Départemental',
    dateDeb: '2026-02-12',
    lieu: 'Dojo Régional',
    statut: 'Inscriptions ouvertes',
    description: 'Sélections départementales pour le régional.',
  },
  {
    id: 36,
    sportId: 3,
    libelle: 'Athlé Estival Régional',
    dateDeb: '2026-04-23',
    lieu: 'Vannes',
    statut: 'A venir',
    description: 'Championnat régional estival sur piste.',
  }
];

export const EPREUVES = [
  { id: 477, competId: 3, libelle: 'Equipe Benjamins', type: 'Equipe' },
  { id: 478, competId: 3, libelle: 'Equipe Minimes', type: 'Equipe' },
  { id: 479, competId: 4, libelle: 'Double Cadets', type: 'Double' },
  { id: 480, competId: 4, libelle: 'Double Juniors', type: 'Double' },
  { id: 101, competId: 10, libelle: '50m Nage Libre', type: 'Individuel' },
  { id: 102, competId: 10, libelle: '100m Brasse', type: 'Individuel' },
];
