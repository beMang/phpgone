# phpGone V2

[![Build Status](https://travis-ci.org/beMang/phpgone.svg?branch=master)](https://travis-ci.org/beMang/phpgone)  [![Coverage Status](https://coveralls.io/repos/github/beMang/phpgone/badge.svg?branch=master)](https://coveralls.io/github/beMang/phpgone?branch=master)

Ce framework est un petit projet personel, que j'ai réalisé pour le défi de faire un framework et de voir tous les enjeux que cela implique.
Tout le monde peut l'utiliser, malheureusement il n'y a pas de documentation (par manque de temps), mais il est assez simple à utiliser.

## Features
* Modèle utilisé : vue et controlleur (partie accès base de donnée est dans une autre lib)
* Système de route (utilisant les attributs)
* Système de middleware pour gérer facilement les requêtes
* Rendu simple et rendu TWIG
* Module pour gérer facilement les urls (surtout pour les assets)
* Système de configuration avec un fichier unique
* Système de log
* Utilisation de Robo pour automatiser certaines tâches

## Normes
J'ai essayé de respecter le plus possible les normes PSR pour que le framework soit interchangeable et utilisable par tous.

## Database
* Pour la gestion des bases de donnée vous pouvez utiliser le système que j'ai codé : https://packagist.org/packages/bemang/database-system

## Tests
La plupart du framework est soumis à des tests unitaires que j'ai créé pour l'exercice.

## TODo
* Système upload
