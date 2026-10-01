# NexSkin — Site Vitrine Professionnel

Site web vitrine professionnel pour **NexSkin**, marque spécialisée dans la personnalisation et l'habillage d'ordinateurs portables.

## Prérequis

- PHP 8.2+
- MySQL 8.0+
- WAMP / XAMPP / LAMP (serveur local)
- Extension GD (pour la conversion WebP)

## Installation

### 1. Cloner ou copier le projet

Placer le dossier `nexskin/` dans votre répertoire web (ex: `C:\wamp64\www\nexskin` ou `/var/www/html/nexskin`).

### 2. Configurer l'environnement

Modifier les valeurs :
```
APP_URL=http://localhost/nexskin
DB_DATABASE=nexskin
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Lancer l'installation

Dans le navigateur :

```
http://localhost/nexskin/install.php
```

Cela créera :
- La base de données `nexskin`
- Les tables nécessaires
- Le compte administrateur par défaut
- Les dossiers d'upload

### 4. Connexion admin

URL : `http://localhost/nexskin/admin/login`

Identifiants par défaut :
- Email : `admin@nexskin.com`
- Mot de passe : `admin123`

**IMPORTANT : Changez le mot de passe après la première connexion !**

## Structure du Projet

```
nexskin/
├── app/
│   ├── controllers/        # Contrôleurs publics
│   │   └── Admin/          # Contrôleurs admin
│   ├── models/             # Modèles de données
│   ├── views/
│   │   ├── layouts/        # Layouts (main, admin)
│   │   ├── home/           # Page d'accueil
│   │   ├── projects/       # Réalisations
│   │   ├── services/       # Services
│   │   ├── about/          # À propos
│   │   ├── contact/        # Contact
│   │   ├── admin/          # Vues admin
│   │   └── errors/         # Pages d'erreur (404, 403, 500)
│   ├── core/               # Framework MVC maison
│   ├── middleware/          # Middleware (auth, CSRF, admin)
│   └── helpers/            # Fonctions utilitaires
├── config/                 # Configuration
├── database/               # Schéma SQL
├── public/
│   ├── assets/             # CSS, JS, images, fonts
│   ├── uploads/            # Images uploadées
│   ├── index.php           # Point d'entrée
│   ├── robots.txt
│   └── sitemap.xml
├── routes/
│   └── web.php             # Définition des routes
├── storage/logs/           # Logs
├── .env                    # Configuration (non versionné)
├── .env.example            # Modèle de configuration
├── .htaccess               # Réécriture d'URLs
├── install.php             # Script d'installation
└── README.md
```

## Architecture MVC

Le projet utilise un **MVC maison** (pas de framework externe) avec :

- **Router** : Routing basé sur des regex, support des paramètres dynamiques
- **Controller** : Classe de base avec render JSON, redirect, flash messages
- **Model** : ORM léger avec CRUD, pagination, requêtes personnalisées
- **Database** : Singleton PDO avec prepared statements
- **Session** : Gestion des sessions, flash messages, authentification
- **Validator** : Validation côté serveur

## Fonctionnalités

### Site Public
- **Accueil** : Carrousel Hero administrable, animations de section, réalisations en vedette, avant/après, services, processus
- **Réalisations** : Galerie filtrable, pagination, page projet détaillée
- **Services** : Présentation des offres de personnalisation
- **À propos** : Histoire et valeurs de la marque
- **Contact** : Formulaire complet avec upload d'image de référence
- **WhatsApp** : Bouton flottant avec message pré-rempli

### Backoffice
- **Dashboard** : Statistiques et dernières activités
- **Réalisations** : CRUD complet, gestion de la galerie, avant/après
- **Catégories** : CRUD avec modales
- **Messages** : Gestion des demandes de contact avec statuts
- **Paramètres** : Configuration du site, réseaux sociaux, SEO et images du carrousel d’accueil (jusqu’à 8 images)

### Technique
- **Upload sécurisé** : Vérification MIME, taille, renommage aléatoire, conversion WebP
- **Sécurité** : CSRF, prepared statements, password_hash, validation XSS
- **SEO** : Meta tags, Open Graph, sitemap.xml, robots.txt, Schema.org
- **Performance** : Lazy loading, images optimisées, CSS/JS minimal
- **Accessibilité** : HTML sémantique, aria-labels, prefers-reduced-motion
- **Responsive** : Mobile-first, testé de 320px à 1920px

## Configuration Uploads

Les images sont stockées dans `public/uploads/` :
- `projects/` : Images des réalisations
- `categories/` : Images des catégories
- `references/` : Images de référence des formulaires

Formats acceptés : JPG, PNG, WebP
Taille max : 5 Mo (configurable dans `.env`)

## Déploiement

1. Modifier `APP_ENV=production` dans `.env`
2. Configurer le serveur web pour pointer vers `public/`
3. Désactiver l'affichage d'erreurs en production
4. Activer HTTPS
5. Supprimer `install.php`
6. Protéger le dossier `storage/`

## Sécurité

- Ne jamais versionner le fichier `.env`
- Utiliser des mots de passe forts
- Activer HTTPS en production
- Mettre à jour régulièrement PHP et MySQL
- Surveiller les logs dans `storage/logs/`

## Licence

Projet privé — NexSkin.
