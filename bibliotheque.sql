CREATE DATABASE bibliotheque;
USE bibliotheque;

CREATE TABLE livres (
    id_livre INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    categorie VARCHAR(255) NOT NULL
);

INSERT INTO livres (id_livre, auteur, titre, categorie) VALUES
(100, 'GUY DE MAUPASSANT', 'Une vie', 'roman'),
(101, 'GUY DE MAUPASSANT', 'Bel-Ami ', 'roman'),
(102, 'HONORE DE BALZAC', 'Le pere Goriot', 'roman'),
(103, 'ALPHONSE DAUDET', 'Le Petit chose', 'roman'),
(104, 'ALEXANDRE DUMAS', 'La Reine Margot', 'roman'),
(105, 'ALEXANDRE DUMAS', 'Les Trois Mousquetaires', 'roman');

CREATE TABLE utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(70) NOT NULL,
    prenom VARCHAR(70) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    date_naissance DATE NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    code_postal VARCHAR(10) NOT NULL
);