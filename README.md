# Projet Menus

> note: Le dossier _databases est un dossier temporaire uniquement pour envoyer les tables pour le projet git, à l'avenir elles seront disponibles via des migrations.

## Définition du projet de base
+ L'objectif final est de réaliser un site (avec laravel) pour gérer les menus d'un resto (ou personnels), avec en base de données la possibilité de gérer les stocks de marchandises, les menus prévus pour les semaines à venir, les recettes liées à ces menus, qu'on peut ensuite lier à notre gestion des stocks, et une interface d'administration pour avoir les pleins pouvoirs même sur la création et suppression des tables. Le projet dans sa version finale sera réalisé sous Laravel

+ Dans un premier temps l'objectif est de faire une version simplifiée en PHP vanilla (pour des particuliers qui souhaitent faire leur course en fonction des stocks restant chez eux) avec 2 tables: la table des stocks et celle des produits à acheter (liste de course créé automatiquement à partir des stocks d'alerte):

+ Quand le particulier souhaite savoir quelles produits il doit acheter cette semaine:
    - il doit pouvoir entrer la liste des ingrédients qu'il a besoin
    - le programme regarde ensuite quels ingrédients de la BDD atteindront le seuil d'alerte et passe la valeur "MustBuy" à "true", il retourne ensuite une liste de courses contenant tous les produits à acheter
    - Le particulier doit pouvoir consulter visuellement l'état de l'ensemble des stocks, triable par nom ou DLC
    - Le particulier doit pouvoir modifier manuellement le nom de l'ingrédient, la quantité, la dénomination de quantité, le stock d'alerte ou la DLC des produits
    - Quand il rentre des courses il doit pouvoir entrer la quantité et la DLC des produits qu'il a acheté dans un formulaire lui proposant d'entrer ces valeurs pour chaque ingrédient présent sur la liste de course, le programme remet alors a jour la liste des stocks (notamment la case MustBuy)
    - Si quand il tape un ingrédient, celui ci n'apparait pas dans la liste il doit pouvoir l'ajouter
    - Quand il utilise un produit il indique la quantité retirée ainsi que la DLC du produit retiré, ainsi le programme peut retiré complètement le produit si pour cette DLC la quantité atteint 0


+ Tables de la base de données:
    - Table stocks
    - Table commands
    - Table recettes (à venir)
    - Table menus (à venir)

### Table 'stocks':
+ La gestion des stocks par défaut sera un déclenchement des commandes basé sur un stock d'alerte pour simplifier il n'y aura pas d'autre type de stock dans un premier temps (stock saisonnier, commande régulière,...)
+ De la même façon il n'y a que des DLC et pas de différenciation avec les DLUO dans un premier temps
+ Modèle avec les types de données et des exemples:

| id | ingredient | quantity | quantity_name          | useby_date |
|----|------------|----------|-----------------------|-----|
|INT | VARCHAR(40)| INT      |     VARCHAR(30)       | DATE|
|UNSIGNED|NOT NULL| NOT NULL |     NOT NULL          | NOT NULL |
|AUTO_INCREMENT|  | UNSIGNED |                       |     |
|PRIMARY KEY|     |          |                       |     |
|1   |  farine    |     200  |       grammes         |  2023-02-04   |
|2   |  oeufs     |     15   |       unités          |  2021-11-26   |
|3   |  sucre     |     300  |       grammes         |  2022-06-24   |
|4   |  lait      |      30  |       centilitres     |  2021-12-12   |
|5   |  lait      |     100  |       centilitres     |  2021-12-25   |


### Table 'commands'
+ Elle reprend les même ingrédients mais avec cette fois leur quantité totale indépendamment de la date
+ Dans celle ci le nom des ingrédients doit être unique, exceptionnelement ce sera le nom des ingrédients qui servira de liens entre les 2 tables, liens à établir entre les deux tables : quand un ingrédient avec une date est ajouté ou retiré à 'stocks' on le modifie également dans la quantité totale de 'commands'

| id | ingredient | quantity | quantity_name          | alert_stock     | must_buy |
|----|------------|----------|-----------------------|----------------|---------|
|INT | VARCHAR(40)| INT      |     VARCHAR(30)       |  INT           | BIT     |
|UNSIGNED|NOT NULL| NOT NULL |     NOT NULL          |  NOT NULL      | NOT NULL|
|AUTO_INCREMENT| UNIQUE | UNSIGNED |                 |  UNSIGNED      |         |
|PRIMARY KEY|     |          |                       |                |         |
|1   |  farine    |     200  |       grammes         |       300      |    1    |
|2   |  oeufs     |     15   |       unités          |        10      |    0    |
|3   |  sucre     |     300  |       grammes         |        200     |    0    |
|4   |  lait      |     130  |       centilitres     |        50      |    0    |

