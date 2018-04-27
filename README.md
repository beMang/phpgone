# phpGone
Le framework phpGone est en cours de développement, la documentation sera écrite plus tard. 

## Statut de build
* Master : [![Build Status](https://travis-ci.org/beMang/phpgone.svg?branch=master)](https://travis-ci.org/beMang/phpgone)
* Branch dev : [![Build Status](https://travis-ci.org/beMang/phpgone.svg?branch=develop)](https://travis-ci.org/beMang/phpgone)
* Code coverage branch master : [![Coverage Status](https://coveralls.io/repos/github/beMang/phpgone/badge.svg?branch=master)](https://coveralls.io/github/beMang/phpgone?branch=master)
* Code coverage branch dev : [![Coverage Status](https://coveralls.io/repos/github/beMang/phpgone/badge.svg?branch=develop)](https://coveralls.io/github/beMang/phpgone?branch=develop)

**Cette page est totalement dépréciée**

## Néanmoins voici le principe général du framework :
Ceci traite uniquement du CoreMiddleware :
Chaque partie du site possède un module :
Chaque module possède un controleur, un modèle (manager) et des vues (une vue par action). Le controleur doit hériter de la classe \phpGone\Core\BackController pour pouvoir bien fonctionner.

Il y a un système de middleware permettant d'influencer la réponse ou la requête avant que ceux-ci atteignet le CoreMiddleware, à savoir, le coeur de l'application.

## Etapes pour afficher la page 
* Envoi de la requête à l'application
* Traitement de la requête par les middlewares
  * Middlewares alternatifs (TrailingSlash,...)
  * Core middleware
    * Récupération du bon controleur en fonction des routes et de la requête
    * Traitement de la requête par le controleur correspondant (Effectue la bonne action)
    * Rendu des informations (Render et variables)
  * Not Found Middleware (404)
* Renvoi du résultat
* Envoi du résultat aux clients

## Fonctionalités disponibles
* Router et routes
* Rendu twig
* Configuration simple
* Middlewares

### Fonctionalités en développement : voir les issues

## PSR
Le framework respecte/respectera certains psr :
* Logger interface (psr-3)
* Autoloading standard (psr-4) avec Composer
* HTTP Message interface (psr-7)
* Simple cache (psr-16)
* Coding Style Guide (psr-2 et donc psr-1)

## Merci

J'espère que vous utiliserez ce framework. Si il y a des bugs/défauts de conception, n'hésitez pas à mettre ça dans les issues.

*Adrien Antonutti*