

-- Insertion des départements
INSERT INTO departement (nom) VALUES
('Maintenance'),
('Administration'),
('Ressources Humaines');

-- Insertion des catégories
INSERT INTO categorie (nom) VALUES
('Recettes'),
('Dépenses');

-- Insertion des types et natures pour chaque département
-- Maintenance
INSERT INTO type (nom, id_categorie) VALUES
('Subventions', 1),
('Prestations de services', 1),
('Dons et mécénat', 1),
('Vente de matériel usagé', 1),
('Achat de matériel', 2),
('Entretien et réparation', 2),
('Frais de sous-traitance', 2),
('Énergie et fournitures', 2);

INSERT INTO nature (nom, id_type) VALUES
('Aide gouvernementale', 1),
('Financement privé', 1),
('Fonds universitaires', 1),
('Subvention internationale', 1),
('Réparation d''équipements externes', 2),
('Contrats de maintenance', 2),
('Assistance technique', 2),
('Vente de pièces détachées', 2),
('Don d''entreprises technologiques', 3),
('Partenariat avec fabricants de matériel', 3),
('Legs d''anciens élèves', 3),
('Contributions d''organisations', 3),
('Revente d''ordinateurs anciens', 4),
('Cession de mobiliers', 4),
('Recyclage de câbles et composants', 4),
('Vente de logiciels déclassés', 4);

-- Administration
INSERT INTO `type` (nom, id_categorie) VALUES
('Frais d''inscription et scolarité', 1),
('Partenariats académiques', 1),
('Location d''infrastructures', 1),
('Ventes diverses', 1),
('Salaires et charges', 2),
('Fournitures et logistique', 2),
('Communication et publicité', 2),
('Sécurité et maintenance', 2);

INSERT INTO nature (nom, id_type) VALUES
('Frais d''admission', 5),
('Frais d''inscription', 5),
('Frais de réinscription', 5),
('Frais de certification', 5),
('Financement de recherche', 6),
('Accords internationaux', 6),
('Contrats avec entreprises', 6),
('Sponsoring d''événements', 6),
('Location d''amphithéâtres', 7),
('Bureaux pour startups', 7),
('Salle de conférence', 7),
('Espace de coworking', 7),
('Vente de manuels', 8),
('Vente de goodies universitaires', 8),
('Vente d''anciens mobiliers', 8),
('Accès payant aux archives', 8);

-- Ressources Humaines
INSERT INTO type (nom, id_categorie) VALUES
('Subventions RH', 1),
('Prestations internes', 1),
('Contributions du personnel', 1),
('Aides gouvernementales', 1),
('Salaires et formations', 2),
('Gestion du personnel', 2),
('Bien-être et conditions de travail', 2),
('Technologies RH', 2);

INSERT INTO nature (nom, id_type) VALUES
('Fonds pour la formation', 9),
('Aide à l''embauche', 9),
('Primes de performance', 9),
('Financement externe pour stages', 9),
('Formations internes', 10),
('Évaluation des compétences', 10),
('Séminaires et conférences', 10),
('Conseil en carrière', 10),
('Mutuelle et assurance', 11),
('Cotisation syndicale', 11),
('Frais de formation continue', 11),
('Contribution retraite', 11),
('Programme d''insertion', 12),
('Aide pour handicapés', 12),
('Financement égalité des chances', 12),
('Plan de mobilité interne', 12);


-- Insertion des périodes
INSERT INTO periode (nom, mois, annee) VALUES
('Janvier 2025', 1, 2025),
('Février 2025', 2, 2025),
('Mars 2025', 3, 2025);

-- Insertion des budgets
INSERT INTO budget (solde_debut, solde_fin, id_departement, id_periode) VALUES
(500000, 700000, 1, 1),
(600000, 750000, 2, 1),
(450000, 600000, 3, 1);

-- Insertion des détails de Maintenance
INSERT INTO detail_budget (montant_prevision, montant_realisation, id_nature, id_budget) VALUES
(120000, 115000, 4, 1),  -- Réparation d’équipements externes
(50000, 45000, 5, 1),    -- Contrats de maintenance
(80000, 78000, 6, 1),    -- Assistance technique
(30000, 29000, 7, 1),    -- Vente de pièces détachées
(150000, 148000, 8, 1),  -- Don d’entreprises technologiques

-- Détails de budget pour le département Administration
(100000, 95000, 9, 2),   -- Frais d’admission
(80000, 78000, 10, 2),   -- Frais d’inscription
(70000, 67000, 11, 2),   -- Frais de réinscription
(50000, 48000, 12, 2),   -- Frais de certification
(120000, 115000, 13, 2), -- Financement de recherche

-- Détails de budget pour le département Ressources Humaines
(150000, 145000, 14, 3), -- Fonds pour la formation
(60000, 55000, 15, 3),   -- Aide à l’embauche
(100000, 98000, 16, 3),  -- Primes de performance
(45000, 43000, 17, 3),   -- Financement externe pour stages
(90000, 88000, 18, 3);   -- Formations internes
