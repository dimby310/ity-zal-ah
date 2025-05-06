<<<<<<< HEAD
DROP DATABASE IF EXISTS consolidation_budgetaire;
CREATE DATABASE consolidation_budgetaire;
=======
CREATE DATABASE IF NOT EXISTS consolidation_budgetaire;
>>>>>>> 41ef530 (feat : all/change)
USE consolidation_budgetaire;

-- Suppression des tables existantes si elles existent
DROP TABLE IF EXISTS detail_budget;
DROP TABLE IF EXISTS nature;
DROP TABLE IF EXISTS liaison_departement;
DROP TABLE IF EXISTS budget;
DROP TABLE IF EXISTS type;
DROP TABLE IF EXISTS periode;
DROP TABLE IF EXISTS departement;
DROP TABLE IF EXISTS categorie;

-- Création de la table categorie
CREATE TABLE categorie(
   id_categorie INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_categorie)
);

-- Création de la table departement
CREATE TABLE departement(
   id_departement INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_departement)
);

-- Création de la table periode
CREATE TABLE periode(
   id_periode INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   mois INT NOT NULL,
   annee INT NOT NULL,
   PRIMARY KEY(id_periode)
);

-- Création de la table type
CREATE TABLE type(
   id_type INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   id_categorie INT NOT NULL,
   PRIMARY KEY(id_type),
   FOREIGN KEY(id_categorie) REFERENCES categorie(id_categorie)
);

-- Création de la table budget
CREATE TABLE budget(
   id_budget INT AUTO_INCREMENT,
   solde_debut INT,
   solde_fin INT,
   id_departement INT NOT NULL,
   id_periode INT NOT NULL,
   PRIMARY KEY(id_budget),
   FOREIGN KEY(id_departement) REFERENCES departement(id_departement),
   FOREIGN KEY(id_periode) REFERENCES periode(id_periode)
);

-- Création de la table liaison_departement
CREATE TABLE liaison_departement(
   id_liaison INT AUTO_INCREMENT,
   autorisation VARCHAR(50),
   source INT NOT NULL,
   destinataire INT NOT NULL,
   PRIMARY KEY(id_liaison),
   FOREIGN KEY(source) REFERENCES departement(id_departement),
   FOREIGN KEY(destinataire) REFERENCES departement(id_departement)
);

-- Création de la table nature
CREATE TABLE nature(
   id_nature INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   id_type INT NOT NULL,
   PRIMARY KEY(id_nature),
   FOREIGN KEY(id_type) REFERENCES type(id_type)
);

-- Création de la table detail_budget
CREATE TABLE detail_budget(
   id_detail INT AUTO_INCREMENT,
   montant_prevision INT NOT NULL,
   montant_realisation INT,
   id_nature INT NOT NULL,
   id_budget INT NOT NULL,
   PRIMARY KEY(id_detail),
   FOREIGN KEY(id_nature) REFERENCES nature(id_nature),
   FOREIGN KEY(id_budget) REFERENCES budget(id_budget)
);