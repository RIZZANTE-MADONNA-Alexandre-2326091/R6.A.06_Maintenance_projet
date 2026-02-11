# R6.A.06_Maintenance_projet
Refonte du projet UGSEL Web avec la prise en compte de la maintenance
et de la qualité de code.

Le projet est composé en 2 parties :
- Backend avec le framework PHP Symfony (lancez la commande dans le `backend/`: `symfony serve`)
- Frontend avec le framework JS React (lancez la commande dans le `frontend`: `npm run dev`)

# Bases de données
La base de données de type PostgreSQL est hébergé sur AlwaysData.
Dans le `backend`, créez un fichier `.env` à partir de `.env.example` et modifiez la ligne `DATABASE_URL`.

# Tests possibles
Dans le `backend/`, vous pouvez utiliser les commandes suivantes :
```shell
vendor/bin/phpunit tests
vendor/bin/php-cs-fixer check
vendor/bin/behat
```
Cela permet de tester la qualité de code du projet, le respect du standard PHP
et les spécifications.<br>
Dans le `frontend\`, vous pouvez utiliser la commande `npx cypress` open pour ouvrir Cypress pour réaliser
les tests finaux sur l'interface.

> [!NOTE]
Le fichier `.github/workflows/symfony.yml`
permet de tester le backend avant une pull request sur la branche main.


Réalisé par:
- Buchmuller Nassim
- El Kihal Ewan
- Loeb Dorian
- Rizzante--Madonna Alexandre
- Turmo Baptiste

**3<sup>ème</sup> année** BUT Informatique, **Groupe A1**
