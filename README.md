====================== README.md ======================

# 📦 Gestion de Stock & Achats
# 📦 Inventory & Purchasing Management System

## FR (Français)

### 📌 Description
Application web développée avec Laravel permettant la gestion complète des stocks, des achats, des commandes fournisseurs et des réceptions, avec suivi des statuts et génération de documents PDF.

---

### 🚀 Fonctionnalités principales

#### 📦 Gestion des achats
- Création des demandes d’achat (DA)
- Validation ou rejet des demandes d’achat
- Suivi par statut (workflow)
- Génération automatique des codes DA

#### 🛒 Gestion des commandes
- Création des commandes fournisseurs
- Validation et annulation des commandes
- Gestion des articles commandés
- Génération des bons de commande en PDF

#### 🚚 Gestion des réceptions
- Réception des commandes fournisseurs
- Gestion des bons de livraison et factures
- Calcul automatique du PMP (Prix Moyen Pondéré)
- Gestion des emplacements de stockage
- Annulation des réceptions

#### 📊 Gestion du stock
- Mise à jour automatique du stock après réception
- Suivi des mouvements de stock
- Inventaire des articles

#### 🧾 Documents PDF
- Demandes d’achat
- Bons de commande
- Génération via FPDF

---

### 🛠️ Technologies
- PHP 8+
- Laravel 8 / 9
- MySQL
- Blade
- Bootstrap
- FPDF

---

### 📂 Structure du projet
app/
 └── Http/
     └── Controllers/
         ├── GestionAchat/
         │   ├── DaController.php
         │   └── CommandeController.php
         └── GestionStock/
             └── ReceptionController.php

---

### ⚙️ Installation

1. Cloner le projet :
   git clone https://github.com/DalilaDoli/gestion-achat-stock.git

2. Installer les dépendances :
   composer install

3. Configuration :
   cp .env.example .env  
   php artisan key:generate

4. Configurer la base de données dans `.env`

5. Lancer les migrations :
   php artisan migrate

6. Démarrer le serveur :
   php artisan serve

---

### 🔐 Sécurité & rôles
- Authentification Laravel
- Actions liées à l’utilisateur connecté
- Validation par statuts (workflow achat)

---

## EN (English)

### 📌 Description
Laravel-based web application for managing inventory, purchasing requests, supplier orders, and goods receptions, with status tracking and PDF document generation.

---

### 🚀 Key Features

#### 📦 Purchasing Management
- Purchase request creation (PR)
- Validation or rejection workflow
- Status-based tracking
- Automatic PR code generation

#### 🛒 Supplier Orders
- Supplier order creation
- Order validation and cancellation
- Ordered items management
- Purchase order PDF generation

#### 🚚 Goods Reception
- Reception of supplier orders
- Delivery notes and invoice management
- Automatic weighted average price (WAP) calculation
- Storage location management
- Reception cancellation

#### 📊 Stock Management
- Automatic stock update after reception
- Stock movement tracking
- Inventory management

#### 🧾 PDF Documents
- Purchase requests
- Purchase orders
- Generated using FPDF

---

### 🛠️ Technologies
- PHP 8+
- Laravel 8 / 9
- MySQL
- Blade
- Bootstrap
- FPDF

---

### 📂 Project Structure
app/
 └── Http/
     └── Controllers/
         ├── GestionAchat/
         │   ├── DaController.php
         │   └── CommandeController.php
         └── GestionStock/
             └── ReceptionController.php

---

### ⚙️ Installation

1. Clone the repository:
   git clone https://github.com/DalilaDoli/gestion-achat-stock.git

2. Install dependencies:
   composer install

3. Environment setup:
   cp .env.example .env  
   php artisan key:generate

4. Configure database in `.env`

5. Run migrations:
   php artisan migrate

6. Start the server:
   php artisan serve

---

### 🔐 Security & Roles
- Laravel authentication
- User-based action control
- Status-based validation workflow


