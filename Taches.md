# Taches du projet Mobile Money - V1

## Binome : Andhy & Midera

### Version V1

#### Module Client (Binome 1 - Midera)
| # | Tache | Description | Statut |
|---|-------|-------------|--------|
| 1 | Auto login par numero | Connexion automatique par numero valide sans inscription | En cours |
| 2 | Consultation du solde | Affichage du solde du client connecte | En cours |
| 3 | Operation de depot | Depot automatique avec mise a jour du solde | En cours |
| 4 | Operation de retrait | Retrait automatique avec calcul des frais | En cours |
| 5 | Operation de transfert | Transfert vers un autre client avec calcul des frais | En cours |
| 6 | Historique des transactions | Liste chronologique des operations du client | En cours |
| 7 | Interface client | Realisation des vues HTML CSS Bootstrap du module client | En cours |

#### Module Operateur (Binome 2 - Andhy)
| # | Tache | Description | Statut |
|---|-------|-------------|--------|
| 8 | Creation du fichier base.sql | Script SQL de creation de la base SQLite | Termine |
| 9 | Configuration des prefixes | CRUD des prefixes valides (033, 037) | Termine |
| 10 | Gestion des types d'operations | CRUD des types (Depot, Retrait, Transfert) | Termine |
| 11 | Gestion des baremes de frais | CRUD des frais par tranche de montant | Termine |
| 12 | Situation des gains | Affichage des frais generes par les retraits et transferts | Termine |
| 13 | Situation des comptes clients | Liste des clients avec leur solde | Termine |
| 14 | Interface operateur | Realisation des vues HTML CSS Bootstrap du module operateur | Termine |
| 15 | Tests et integration | Verification du fonctionnement global du module operateur | Termine |



# Taches du projet Mobile Money -V2
  ## Taches.md - Version 2
## Module Client (Binome 1)
#	Tache	Description
1-Option inclure les frais de retrait	Ajouter une option permettant dinclure les frais de retrait lors dun transfert
2-Envoi multiple	Permettre lenvoi vers plusieurs numeros en une seule operation
3-Repartition automatique du montant	Diviser automatiquement le montant total entre les differents destinataires
4-Mise a jour de lhistorique	Enregistrer toutes les operations issues dun envoi multiple
5-Mise a jour de linterface client	Adapter les formulaires et les vues Bootstrap aux nouvelles fonctionnalites
6-Tests et integration	Verification du bon fonctionnement des nouvelles fonctionnalites client


##   Module Operateur (Binome 2)
#	Tache	Description	Statut
7-Configuration des prefixes des autres operateurs	CRUD des prefixes des autres operateurs (031, 032, ...)	✓ Termine
8-Configuration des commissions	Gestion du pourcentage de commission applique aux transferts vers les autres operateurs	✓ Termine
9-Mise a jour du calcul des frais	Prendre en compte les commissions supplementaires lors des transferts externes	✓ Termine
10-Situation des gains	Separer les gains provenant de lopérateur et des autres operateurs	✓ Termine
11-Situation des montants a envoyer	Afficher les montants a reverser a chaque operateur externe	✓ Termine
12-Mise a jour de linterface operateur	Adapter les pages Bootstrap aux nouvelles fonctionnalites	✓ Termine
13-Tests et integration	Verification du bon fonctionnement des nouvelles fonctionnalites operateur	✓ Termine