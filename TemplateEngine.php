<?php

// Déclaration de la classe TemplateEngine
class TemplateEngine {
    // Propriété pour stocker le répertoire des templates
    protected $templateDir;

    // Propriété pour stocker les variables à remplacer dans les templates
    protected $vars = [];

    // Constructeur pour initialiser le répertoire des templates
    public function __construct($templateDir) {
        // Stocke le répertoire des templates en ajoutant un '/' à la fin si nécessaire
        $this->templateDir = rtrim($templateDir, '/') . '/';
    }

    // Méthode pour définir une variable à remplacer dans les templates
    public function set($var, $value) {
        $this->vars[$var] = $value;
    }

    // Méthode pour rendre un fichier template
    public function render($templateFile) {
        // Vérifie si le fichier template existe
        if (file_exists($this->templateDir . $templateFile)) {
            // Lit le contenu du fichier template
            $content = file_get_contents($this->templateDir . $templateFile);

            // Parse les balises d'inclusion { include file }
            $content = $this->parseIncludes($content);

            // Parse les variables { var }
            $content = $this->parseVariables($content);

            // Affiche le contenu du fichier template
            echo $content;
        } else {
            // Affiche une erreur si le fichier template n'existe pas
            echo "Error: Template file '$templateFile' not found.";
        }
    }

    // Méthode pour parser et remplacer les balises d'inclusion { include file }
    protected function parseIncludes($content) {
        // Trouve toutes les occurrences de { include file }
        preg_match_all('/\{ include ([a-zA-Z0-9_\.\/]+) \}/', $content, $matches);

        // Pour chaque inclusion trouvée
        foreach ($matches[1] as $file) {
            // Vérifie si le fichier d'inclusion existe
            if (file_exists($this->templateDir . $file)) {
                // Lit le contenu du fichier d'inclusion
                $includeContent = file_get_contents($this->templateDir . $file);

                // Parse les balises d'inclusion dans le contenu du fichier d'inclusion
                $includeContent = $this->parseIncludes($includeContent);

                // Parse les variables dans le contenu du fichier d'inclusion
                $includeContent = $this->parseVariables($includeContent);

                // Remplace la balise d'inclusion par le contenu du fichier d'inclusion
                $content = str_replace("{ include " . $file . " }", $includeContent, $content);
            } else {
                // Affiche une erreur si le fichier d'inclusion n'existe pas
                echo "Error: Include file '$file' not found.";
            }
        }
        return $content; // Retourne le contenu modifié
    }

    // Méthode pour parser et remplacer les variables { var }
    protected function parseVariables($content) {
        // Pour chaque variable à remplacer
        foreach ($this->vars as $var => $value) {
            // Remplace la variable par sa valeur dans le contenu
            $content = str_replace("{ $var }", $value, $content);
        }
        return $content; // Retourne le contenu modifié
    }
}