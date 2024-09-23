# Kata x Aurélien Feuillard

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
  