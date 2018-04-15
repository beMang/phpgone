# phpGone
Le framework phpGone est en cours de développement, la documentation sera écrite plus tard. 

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
* Envoi de la réponse de l'application

## Fonctionalités disponibles
* Router et routes
* Rendu twig
* Configuration simple
* Middlewares
* Container (PHP-DI)
* Logs (1 issues opened)

## Fonctionalités en développement (instable ou inachevés)
* Database
* File manager
* Session
* Cache
* Middleware CSRF
* Query Builder
* TwigExtension : FormExtension

## PSR
Le framework respecte/respectera certains psr :
* Logger interface (psr-3)
* Autoloading standard (psr-4)
* HTTP Message interface (psr-7)
* Container Interface (psr-11)
* Simple cache (psr-16)
* Coding Style Guide (psr-2 et donc psr-1)

## Merci

J'espère que vous utiliserez ce framework. Si il y a des bugs/défauts de conception, n'hésitez pas à mettre ça dans les issues.

*Adrien Antonutti*