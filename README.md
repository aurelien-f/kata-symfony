# Kata x Aurélien Feuillard [Document de l'exercice](https://docs.google.com/document/d/1HFwN8MJJAcLW8EmZQsmWgFC3fSY_ZC3Y01repAzi9IM/edit#heading=h.alqi9kkdk9db)

## Etape 1

* Installation de composer via brew
  * `brew install composer`
* Installation de symfony via composer
  * `symfony new kata-symfony  --version="7.1.*" --webapp`
* Installation de doctrine
  * `composer require doctrine twig symfony/form`
  * `composer require symfony/orm-pack`
  * `composer require --dev symfony/maker-bundle`
* Instancie le dépôt git local
  * `git init`
  * `git add .`
  * `git commit -m "Initial commit"`
* Créer une branche develop
  * `git checkout -b develop`
  
## Etape 2

* Création de la base de donnée
  * `DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db" > .env.local`
  * `php bin/console doctrine:database:create`

* Création de l'entité Movie
  * `php bin/console make:entity`
  * `php bin/console make:migration`
  * `php bin/console doctrine:migrations:migrate`

* Migration de la base de donnée
  * `php bin/console doctrine:migrations:migrate`

## Etape 3

* Création de l'entité Movie
  * `php bin/console make:migration`
  * `php bin/console doctrine:migrations:migrate`
* Vérification de la table movie
  * `sqlite3 var/data.db`
  * `.tables`
  * `.schema movie`
  * `select * from movie;`

## Etape 4

* Configuration du server
  * `symfony server:ca:install`
  * `symfony server:start`

## Etape 5

* Installation de Webpack Encore
  * `composer require symfony/webpack-encore-bundle`
  * `pnpm add @symfony/webpack-encore --save-dev`
  * `pnpm add bootstrap`
  * `pnpm add @popperjs/core`
  * `pnpm add sass-loader@^14.0.0 sass --save-dev`

## Etape 6

* Création du formulaire
  * `php bin/console make:form MovieType`
* Configuration du formulaire
  * `src/Form/MovieType.php`
* Création du contrôleur pour gérer le formulaire
  * `src/Controller/MovieController.php`
* Création du template Twig
  * `src/templates/movie/add.html.twig`
* Ajout de class bootstrap + label pour le bouton submit

## Etape 7

* Modification du controller [HomeController.php](src/Controller/HomeController.php) pour récupérer les films
* Modification du template twig index pour afficher les films dans une table bootstrap

## Etape 8

* Modification de [MovieController.php](src/Controller/MovieController.php)
* Création d'un template > [detail.html.twig](templates/movie/detail.html.twig)
* Ajout d'un bouton dans [index.html.twig](templates/home/index.html.twig)

## Etape 9

* Modification de [MovieController.php](src/Controller/MovieController.php)
* Création d'un composant pour le formulaire > [_movie_form.html.twig](templates/movie/_movie_form.html.twig)
* Création d'un template > [edit.html.twig](templates/movie/edit.html.twig)
* Ajout d'un bouton dans [index.html.twig](templates/home/index.html.twig)

## Etape 10

* Ajout d'un bouton de suppression dans [detail.html.twig](templates/movie/detail.html.twig)
* Création d'un component modal avec Bootstrap pour confirmer la suppression ([modal](templates/components/confirm_delete_modal.html.twig))

## Etape 11

* Intégration de l'API OMDB
  * Création du client OMDB > [OmdbClient.php](src/Service/OmdbClient.php)
  * Création du DTO pour les films > [MovieDTO.php](src/Class/MovieDTO.php)
  * Configuration de la clé API dans le fichier .env.local
  * Création du contrôleur pour la recherche de films > [OmdbController.php](src/Controller/OmdbController.php)
  * Création du template Twig pour la recherche de films > [search.html.twig](templates/omdb/search.html.twig)
  * Ajout de la route pour la recherche de films dans le fichier de configuration des routes > [routes.yaml](config/routes.yaml)

## Etape 12 / 13

* Ajout des champs poster, last_played_at et status dans la table movie
  * Création de la migration
* Ajout d'un bouton dans [search.html.twig](templates/omdb/search.html.twig) pour ajouter le film à la bibliothèque
* Ajout d'une sécurité pour vérifier si le film existe déjà dans la bibliothèque
* Ajout d'un message flash de succès et d'erreur
* Ajout d'une image de poster par défaut ou l'image OMDB dans [detail.html.twig](templates/movie/detail.html.twig)

## Etape 14

* mise en place du workflow
  * `composer require symfony/workflow`
  * `php bin/console make:workflow`
  * [workflow.yaml](config/packages/workflow.yaml)
  * Modification de [detail.html.twig](templates/movie/detail.html.twig) pour ajouter le bouton de changement de statut
  * Modification de [MovieController.php](src/Controller/MovieController.php) pour gérer le changement de statut, suivi du [tuto](https://grafikart.fr/tutoriels/symfony-workflow-1978)
  * Création d'un subscriber pour changer la date de vue [MovieStatusChangeSubscriber.php](src/EventSubscriber/MovieStatusChangeSubscriber.php)
