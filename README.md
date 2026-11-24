# Installation et lancement

## 1. Prérequis

Avant de commencer, les logiciels suivants doivent être installés :

- **PHP** : version 8.5.12.
- **Composer** : gestionnaire de dépendances PHP.
- **MySQL** : système de gestion de base de données.
- **Apache** : serveur web.
- **Git** : pour récupérer le projet.

Pour simplifier l'installation sous Windows, l'utilisation de **XAMPP** est recommandée.

## 2. Récupération du projet

Récupérer le code source depuis GitHub :

```bash
cd C:\xampp\htdocs
git clone https://github.com/Theanael/CEF-touche-pas-au-klaxon.git touche-pas-au-klaxon
```

Le projet doit se trouver dans le dossier suivant :

```text
C:\xampp\htdocs\touche-pas-au-klaxon
```

## 3. Installation des dépendances

Ouvrir un terminal à la racine du projet et exécuter la commande suivante :

```bash
composer install
```

Cette commande installe les dépendances PHP nécessaires au fonctionnement de l'application.

## 4. Configuration de la base de données

1. Démarrer les services Apache et MySQL depuis XAMPP.
2. Accéder à phpMyAdmin à l'adresse suivante : [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Importer les fichiers SQL fournis dans le dossier `sql` du projet afin de créer la base de données, les tables et d'insérer les données initiales.

## 5. Configuration de l'environnement

À la racine du projet, créer un fichier `.env` en se basant sur le fichier `.env.template`.

Renseigner les informations de connexion à la base de données ainsi que les paramètres nécessaires au fonctionnement de l'application.

## 6. Lancement de l'application

1. Vérifier que les services Apache et MySQL sont démarrés dans XAMPP.
2. Vérifier que le fichier `.htaccess` est bien présent et que le module Apache `mod_rewrite` est activé.
3. Accéder à l'application depuis un navigateur à l'adresse suivante :

   [http://localhost/touche-pas-au-klaxon/](http://localhost/touche-pas-au-klaxon/)

L'application est alors accessible.