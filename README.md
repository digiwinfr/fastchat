# ![cat](www/assets/images/cat.png) FastChat

Un chat en PHP/MySQL sans framework.

## Rappel du contexte

Développement d'un T’chat, construit sur un modele MVC objet maison, sans framework. Les éléments techniques sont les suivants :  

Durée : 3 à 4 heures

- PHP 5 / MySQL / HTML 5
- Apache ou Nginx
- Une architecture basée sur le modèle MVC objet (l’arborescence doit aussi respecter ce modèle)
- Une page d’authentification avec si possible, creation automatique de comptes
- Une page de T’chat, avec :
- Listing des messages archivés
- Possibilité de dialoguer avec les autres membres
- Listing des connectés (si vous avez le temps)
- Un affichage 'temps réel' (si vous avez le temps)
- Un minimum de sécurité (à vous de voir ce qui doit être sécurisé)
- Une doc d’installation (si nécessaire)
- Un zip contenant le projet
- Un sql pour l’installation de la BDD
- Le design n’est pas important donc ne vous attardez pas sur ce point, quelque chose de basique suffira
- Possibilité d’utiliser Bootstrap
- Possiblilité d’utiliser JQuery
- Possibilité d'utiliser Github à la place d'un zip

*NB : Il faut que le projet soit fonctionnel lors de son installation (en dehors des configurations BDD)*


[Démo](https://fastchat.delivery.trsb.net/)

## Installation

### Avec Docker

**Pré-requis :**

- [docker](https://docs.docker.com/install/)
- [docker-compose](https://docs.docker.com/compose/install/)

**Installation :**

```bash
# Copie du fichier d'environnement par défaut
cp .env.dev.dist .env

# Téléchargement, build des images et démarrage des conteneurs
docker-compose up -d

# Installation des dépendances
.docker/bin/composer install

# Restauration de la base de données
docker-compose exec database sh -c 'mysql -u root -proot fastchat < /tmp/dump.sql'
```

Fastchat est disponible à l'adresse [http://localhost:8080](http://localhost:8080)

### Sans Docker

**Pré-requis :**

- PHP 7 avec les extensions mysqli, pdo, pdo_mysql
- MySql 5.7
- [composer](https://getcomposer.org/)
- Apache ou Nginx avec l'url rewriting activé

**Installation :**

- Copier le contenu du dépôt dans le document root de votre serveur
- Exécuter la commande `composer install` à la racine du projet pour récupérer les dépendances
- Restaurer le fichier `dump.sql` sur vostre instance MySql
- Adapter le fichier `config/config.php` en fonction de votre base de données

Fastchat est disponible à l'adresse configurée selon votre serveur http