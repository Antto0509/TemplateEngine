# Moteur de Template en PHP

## Objectif

Ce projet vise à créer un moteur de template simple en PHP. Le but est de séparer la logique de l'application de la présentation en utilisant des fichiers de template. Le moteur de template permet d'inclure dynamiquement des fichiers et de remplacer des variables définies dans le template.

## Fonctionnalités

- **Inclusion de fichiers** : Utilisation de balises `{ include file.php }` pour inclure dynamiquement des fichiers dans un template.
- **Remplacement de variables** : Utilisation de balises `{ var }` pour remplacer des variables définies avec leurs valeurs dans le template.
- **Gestion des variables non définies** : Si une balise de variable est présente dans le template mais n'est pas définie, elle sera remplacée par une chaîne vide.

## Structure des Fichiers

```bash
/templates
    /header.php
    /footer.php
    /index.php
/index.php
TemplateEngine.php
```

- **/templates** : Contient les fichiers de template.
- **/index.php** : Point d'entrée de l'application.
- **TemplateEngine.php** : Contient la classe `TemplateEngine` qui gère le rendu des templates.

## Exemple de Templates

**/templates/header.php**
```php
<header>
    <h1>Bienvenue sur mon site</h1>
</header>
```

**/templates/footer.php**
```php
<footer>
    <p>&copy; 2024 Mon Site Web</p>
</footer>
```

**/templates/index.php**
```php
<!DOCTYPE html>
<html>
<head>
    <title>Page d'accueil</title>
</head>
<body>
    { include header.php }

    <main>
        <p>{ message }</p>
        <p>Contenu principal de la page.</p>
    </main>

    { include footer.php }
</body>
</html>
```

## Utilisation

1. **Inclure la classe TemplateEngine** :
   Incluez le fichier TemplateEngine.php dans votre script principal.

2. **Créer une instance de TemplateEngine** :
   Initialisez l'objet avec le répertoire contenant vos templates.

3. **Définir des variables** :
   Utilisez la méthode set pour définir des variables qui seront remplacées dans les templates.

4. **Rendre un template** :
   Utilisez la méthode render pour afficher le template final.

### Exemple d'utilisation

**/index.php**
```php
<?php

require 'TemplateEngine.php';

// Création d'une instance de TemplateEngine avec le répertoire des templates
$template = new TemplateEngine(__DIR__ . '/templates');

// Définition d'une variable 'message' avec une valeur
$template->set('message', 'Ceci est un message personnalisé.');

// Rendu du template 'index.php'
$template->render('index.php');

?>
```

## Classe TemplateEngine

### Propriétés

- **templateDir** : Répertoire contenant les fichiers de template.
- **vars** : Tableau associatif de variables à remplacer dans les templates.

### Méthodes 

- **__construct($templateDir)** : Initialise le répertoire des templates.
- **set($var, $value)** : Définit une variable à remplacer dans les templates.
- **render($templateFile)** : Rend un fichier template en remplaçant les inclusions et les variables définies.
- **parseIncludes($content)** : Remplace les balises { include file } par le contenu des fichiers inclus.
- **parseVariables($content)** : Remplace les balises { var } par les valeurs définies dans $vars, sinon par une chaîne vide.
