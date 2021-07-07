# <h1 style="color:blue">Symfony Cheat sheet</h1>


## Créer des entitées

```
symfony console make:entity
```

Répondre aux questions de symfony en lui donnant le nom et le type de champ à créer

## Migrer la base de donnée avec Doctrine

```
symfony console make:migration
```

Pour créer le fichier de migration
```
symfony console doctrine:migrations:migrate
```

Pour migrer les entitées en base de donnée

## Créer des relations entre entitées

```
symfony console make:entity
```

* Noter le nom de l'entitée sur laquelle ajouter une relation
* Noter 'relation' à la question demandant le type
* Donner le nom de l'entitée à relier avec celle-ci
* Donner le type de relation (ex: OneToMany)
* Donner le nom de la propriété à ajouter à l'entité reliée
* Dire si le champ peut être null
* Appuyer sur Enter pour terminer