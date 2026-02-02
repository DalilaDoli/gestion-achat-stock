====================== README.md ======================

# Gestion des Dossiers & Projets

Application web développée avec Laravel permettant la gestion, le suivi et la circulation des dossiers ou projets entre différents départements, avec historique des situations et contrôle des accès utilisateurs.

------------------------------------------------------

FONCTIONNALITÉS

- Création de dossiers avec numérotation automatique
- Gestion des types de dossiers
- Suivi des situations des dossiers
- Transfert des dossiers entre départements
- Clôture des dossiers
- Historique des actions
- Gestion des rôles (administrateur / utilisateur)

------------------------------------------------------

TECHNOLOGIES

- PHP 8+
- Laravel 8 / 9
- MySQL
- Blade
- Bootstrap

------------------------------------------------------

STRUCTURE DU PROJET

app/
 └── Http/
     └── Controllers/
         └── DossierController.php

------------------------------------------------------

INSTALLATION

1. Cloner le projet :
   git clone https://github.com/DalilaDoli/gestion-dossiers.git

2. Installer les dépendances :
   composer install

3. Configuration :
   cp .env.example .env
   php artisan key:generate

4. Base de données :
   php artisan migrate

5. Lancer le serveur :
   php artisan serve

------------------------------------------------------

SÉCURITÉ

- Authentification Laravel
- Accès limité par département
- Rôle administrateur pour la supervision globale

------------------------------------------------------

AUTEUR

Dalila Doli  
Développeuse Web  
Laravel • Django • Applications de gestion

------------------------------------------------------

LICENCE

Projet open-source à usage pédagogique et professionnel.

======================================================
