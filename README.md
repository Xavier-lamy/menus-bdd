# Projet Menus

> note: Le dossier _databases est un dossier temporaire uniquement pour envoyer les tables pour le projet git, à l'avenir elles seront disponibles via des migrations.

## Définition du projet de base et phase 1
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
+ Ajout d'une colonne commands_id pour relier cette table à la table commands

| id | ingredient | commands_id | quantity | unit          | useby_date |
|----|------------|-------------|----------|-----------------------|-----|
|INT | VARCHAR(40)|   INT       | INT      |     VARCHAR(30)       | DATE|
|UNSIGNED|NOT NULL| UNSIGNED    | NOT NULL |     NOT NULL          | NOT NULL |
|AUTO_INCREMENT|  |             | UNSIGNED |                       |     |
|PRIMARY KEY|     |             |          |                       |     |
|1   |  farine    |             |     200  |       grammes         |  2023-02-04   |
|2   |  oeufs     |             |     15   |       unités          |  2021-11-26   |
|3   |  sucre     |             |     300  |       grammes         |  2022-06-24   |
|4   |  lait      |             |      30  |       centilitres     |  2021-12-12   |
|5   |  lait      |             |     100  |       centilitres     |  2021-12-25   |


### Table 'commands'
+ Elle reprend les même ingrédients mais avec cette fois leur quantité totale indépendamment de la date
+ Dans celle ci le nom des ingrédients doit être unique, exceptionnelement ce sera le nom des ingrédients qui servira de liens entre les 2 tables, liens à établir entre les deux tables : quand un ingrédient avec une date est ajouté ou retiré à 'stocks' on le modifie également dans la quantité totale de 'commands'

| id | ingredient | quantity | unit          | alert_stock     | must_buy |
|----|------------|----------|-----------------------|----------------|---------|
|INT | VARCHAR(40)| INT      |     VARCHAR(30)       |  INT           | BIT     |
|UNSIGNED|NOT NULL| NOT NULL |     NOT NULL          |  NOT NULL      | NOT NULL|
|AUTO_INCREMENT| UNIQUE | UNSIGNED |                 |  UNSIGNED      |         |
|PRIMARY KEY|     |          |                       |                |         |
|1   |  farine    |     200  |       grammes         |       300      |    1    |
|2   |  oeufs     |     15   |       unités          |        10      |    0    |
|3   |  sucre     |     300  |       grammes         |        200     |    0    |
|4   |  lait      |     130  |       centilitres     |        50      |    0    |

## Définition Phase 2
On commence à ajouter les autres tables et possibilités:
+ Créer un système de comptes (admin, guest, registered,..):
    - Definir les roles
    - A la création : nom, mot de passe, ... , souhaite-t-il création auto d'ingrédients dans total stocks (run factory avec des ingrédients prédéfinis)
+ Créer la page recettes (front)
    - Un tableau qui affiche : *nom de la recette* et *voir le détail*
    - Option pour ajouter ou supprimer une recette
    - Sur chaque page d'une recette on a les détails, on peut la modifier 
    - Sur une page recette on a le titre (= nom de la recette), le procédé, (une image ?),  puis le nom de chaque ingrédient et de sa quantité)
    - On peut choisir d'exclure un ingrédient de la gestion des stocks (pour les ingrédients sans quantité (QS) ou pour l'eau du robinet par exemple, option: "ajouter un ingrédient à exclure de la gestion de stock (exemple l'eau du robinet)"
    - **Avancé**: les recettes doivent pouvoir s'appeler les unes les autres: exemple une recette tarte doit pouvoir appeler une recette pâte à tarte, on aura donc un champ en plus pour choisir (avec un select qui affiche les recettes déjà présentes); ce champ recette doit permettre de choisir la quantité nécessaire (ex: 300g de pâte, afin de recalculer la quantité nécessaire d'ingrédients
+ Page recette (back)
    - Table recipes (Id, Nom, Procédé, poids total=calculé en fonction de tous les ingrédients liés à cette recette, Image optionnel ?, objet ingrédient exclu gestion
    - Table quantities (recipe_id, ingredient=IdCommand, quantité=rentré manuellement)
+ Créer la page menus (front)
    - Archive des menus de la semaine en cours (peut choisir d'afficher  les semaines précédentes, suivantes, ...)
    - Sur un menu on choisit les plats (recettes que l'on souhaite pour tel jour (date donnée)
    - La gestion de la liste de courses se fait en fonction des infos ci dessus
+ Page menu (back)
    - table menus: id unique, date du jour, les moment (clés: "matin", "midi", "soir"), les plats (recettes exemple tarte)
    - A voir au plus efficace: à chaque affichage de shopping le programme recalcule les quantités totales nécessaires (problème=si un utilisateur décide de rafraichir la page à chaque fois on devra faire les calculs à chaque fois/ ou stocker dans la session ?) ou faire une table en plus qui stocke les quantités nécessaires jusqu'à la prochaine semaine (problème= nécessite de la mettre à jour à la moindre modif sur une autre table, alors que dans le premier cas on ne fait le calcul qu'à l'affichage de shopping, donc quand c'est nécessaire