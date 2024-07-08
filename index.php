<?php

// Inclusion du fichier contenant la classe TemplateEngine
require 'TemplateEngine.php';

// Création d'une instance de TemplateEngine avec le répertoire des templates
$template = new TemplateEngine(__DIR__ . '/templates');

// Définition d'une variable 'message' avec une valeur
$template->set('message', 'Ceci est un message personnalisé.');

// Rendu du template 'index.php'
$template->render('index.php');