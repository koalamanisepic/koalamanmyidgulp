<?php
/**
 * Translation dictionary.
 *
 * To add a new UI string: add a key under both 'en' and 'fr' below,
 * then reference it in a template as $t['section']['key'].
 *
 * To add a new language: duplicate one of the two top-level arrays,
 * translate every value, and add the language code to $available
 * in includes/bootstrap.php.
 */

return [

    'en' => [

        'meta' => [
            'title'       => 'Koalaman — Learning Log',
            'description' => 'Learning records, projects, and independent study.',
        ],

        'nav' => [
            'brand'    => 'Koalaman.',
            'learning' => 'Learning',
            'projects' => 'Projects',
            'papers'   => 'Papers',
            'wemos'    => 'Wemos Controller',
            'menu'     => 'Menu',
            'theme_toggle' => 'Toggle dark mode',
        ],

        'hero' => [
            'volume'   => 'Learning Log ' . MIDDOT . ' Ongoing',
            'cta'      => 'Explore',
            'contents' => 'Contents',
        ],

        'learning' => [
            'label' => 'Learning',
            'title' => 'Learning Records',
            'desc'  => 'Documentation of subjects and concepts studied through coursework, independent study, lectures, books, and other resources.',
            'cta'   => 'View records',
            'unit'  => 'records',
            'items' => [
                [
                    'code' => 'LR' . MIDDOT . '01',
                    'name' => 'Psychology',
                    'desc' => 'Concepts in cognition, behaviour, and research methods, studied through coursework and independent reading.',
                    'link' => 'learning/psychology/',
                ],
                [
                    'code' => 'LR' . MIDDOT . '02',
                    'name' => 'Sociology',
                    'desc' => 'Social structures, institutions, and group behaviour, studied through independent A-Level resources.',
                    'link' => 'learning/sociology/',
                ],
                [
                    'code' => 'LR' . MIDDOT . '03',
                    'name' => 'Education & Learning',
                    'desc' => 'How people learn and retain information, and how explanations can be made clearer.',
                    'link' => 'learning/education-and-learning/',
                ],
                [
                    'code' => 'LR' . MIDDOT . '04',
                    'name' => 'French',
                    'desc' => 'A running log of original sentences written while learning new French vocabulary.',
                    'link' => 'learning/french/',
                ],
                [
                    'code' => 'LR' . MIDDOT . '05',
                    'name' => 'Philosophy',
                    'desc' => 'Ideas and arguments encountered through primary texts, lectures, and independent reading.',
                    'link' => 'learning/philosophy/',
                ],
            ],
        ],

        'projects' => [
            'label'    => 'Projects',
            'title'    => 'Projects & Applications',
            'desc'     => 'Practical work demonstrating the application of knowledge, problem-solving, collaboration, technical skills, and communication.',
            'cta'      => 'View project',
            'unit'     => 'project',
            'featured' => [
                'code' => 'PR' . MIDDOT . '01',
                'name' => 'Digital Twin — Railway Safety',
                'desc' => 'A technology project exploring railway safety through sensors, monitoring, digital twin concepts, and a simulated environment.',
                'tags' => ['Digital Twin', 'Sensors', 'ESP32', 'Team Coordination', 'Technical Communication'],
                'link' => 'projects/digital-twin-railway-safety/',
            ],
        ],

        'papers_home' => [
            'label' => 'Papers',
            'title' => 'Papers',
            'desc'  => 'PDF copies of papers written over time, kept in one place for reference.',
            'cta'   => 'Browse papers',
            'unit'  => 'papers',
            'unit_singular' => 'paper',
            'link'  => 'papers/',
        ],

        'esp32' => [
            'label' => 'Hardware',
            'title' => 'Controllers',
            'desc'  => 'Interfaces for controlling and testing the railway project hardware.',
            'cta'   => 'Open',
            'items' => [
                [
                    'name' => 'Wemos Controller',
                    'desc' => 'Primary control interface for the digital twin hardware.',
                    'link' => 'https://koalaman.my.id/esp32wemos/',
                ],
                [
                    'name' => 'ESP32 DevKit V1',
                    'desc' => 'Secondary board used for sensor and firmware testing.',
                    'link' => 'https://koalaman.my.id/esp32devkitv1/',
                ],
            ],
        ],

        'french' => [
            'eyebrow'         => 'Learning ' . MIDDOT . ' French',
            'title'           => 'French Sentences',
            'desc'            => 'A running log of original sentences written while learning new vocabulary. Each one is dated as it is added.',
            'form_title'      => 'Add a sentence',
            'label_sentence'  => 'Sentence (French)',
            'placeholder_sentence' => 'e.g. Je voudrais apprendre le français chaque jour.',
            'label_note'      => 'Note (optional)',
            'placeholder_note' => 'Meaning, context, or the word being practised',
            'label_passphrase' => 'Passphrase',
            'placeholder_passphrase' => 'Required to add an entry',
            'submit'          => 'Add entry',
            'error_empty'     => 'The sentence field can’t be empty.',
            'error_passphrase' => 'That passphrase isn’t correct.',
            'success'         => 'Sentence added.',
            'wall_title'      => 'Log',
            'wall_empty'      => 'No sentences logged yet.',
            'back'            => 'Back to Learning',
        ],

        'papers' => [
            'eyebrow'          => 'Papers',
            'title'            => 'Papers',
            'desc'             => 'PDF copies of papers written over time, uploaded here for reference.',
            'form_title'       => 'Upload a paper',
            'label_title'      => 'Title',
            'placeholder_title' => 'e.g. The Role of Statistics in Psychological Research',
            'label_description' => 'Description (optional)',
            'placeholder_description' => 'Subject, course, or context',
            'label_date'       => 'Date written (optional)',
            'written_prefix'   => 'Written',
            'uploaded_prefix'  => 'Uploaded',
            'label_file'       => 'PDF file',
            'label_passphrase' => 'Passphrase',
            'placeholder_passphrase' => 'Required to upload',
            'submit'           => 'Upload',
            'error_empty'      => 'The title field can’t be empty.',
            'error_passphrase' => 'That passphrase isn’t correct.',
            'error_no_file'    => 'Choose a PDF file to upload.',
            'error_not_pdf'    => 'Only PDF files are accepted.',
            'error_too_large'  => 'That file is too large (20MB max).',
            'error_upload_failed' => 'The upload failed. Please try again.',
            'error_storage'    => 'Could not save the file on the server. Check that the storage folder is writable.',
            'success'          => 'Paper uploaded.',
            'list_title'       => 'Papers',
            'list_empty'       => 'No papers uploaded yet.',
            'view'             => 'View PDF',
            'back'             => 'Back to home',
        ],

        'mascot' => [
            'aria_label' => 'Honk the clown nose',
        ],

        'footer' => [
            'links'     => 'Learning ' . MIDDOT . ' Projects ' . MIDDOT . ' Papers',
            'copyright' => 'Koalaman',
        ],

    ],

    'fr' => [

        'meta' => [
            'title'       => 'Koalaman — Journal d’apprentissage',
            'description' => 'Journal d’apprentissage, projets et études indépendantes.',
        ],

        'nav' => [
            'brand'    => 'Koalaman.',
            'learning' => 'Apprentissage',
            'projects' => 'Projets',
            'papers'   => 'Papiers',
            'wemos'    => 'Contrôleur Wemos',
            'menu'     => 'Menu',
            'theme_toggle' => 'Basculer le mode sombre',
        ],

        'hero' => [
            'volume'   => 'Journal d’apprentissage ' . MIDDOT . ' En cours',
            'cta'      => 'Explorer',
            'contents' => 'Sommaire',
        ],

        'learning' => [
            'label' => 'Apprentissage',
            'title' => 'Dossiers d’apprentissage',
            'desc'  => 'Documentation des matières et concepts étudiés à travers les cours, les études indépendantes, les conférences, les livres et d’autres ressources.',
            'cta'   => 'Voir les dossiers',
            'unit'  => 'dossiers',
            'items' => [
                [
                    'code' => 'LR' . MIDDOT . '01',
                    'name' => 'Psychologie',
                    'desc' => 'Notions de cognition, de comportement et de méthodes de recherche, étudiées à travers les cours et des lectures indépendantes.',
                    'link' => 'learning/psychology/',
                ],
                [
                    'code' => 'LR' . MIDDOT . '02',
                    'name' => 'Sociologie',
                    'desc' => 'Structures sociales, institutions et comportements collectifs, étudiés à travers des ressources indépendantes de niveau A-Level.',
                    'link' => 'learning/sociology/',
                ],
                [
                    'code' => 'LR' . MIDDOT . '03',
                    'name' => 'Éducation & apprentissage',
                    'desc' => 'Comment les individus apprennent et retiennent l’information, et comment rendre les explications plus claires.',
                    'link' => 'learning/education-and-learning/',
                ],
                [
                    'code' => 'LR' . MIDDOT . '04',
                    'name' => 'Français',
                    'desc' => 'Un registre continu de phrases originales écrites en apprenant du nouveau vocabulaire français.',
                    'link' => 'learning/french/',
                ],
                [
                    'code' => 'LR' . MIDDOT . '05',
                    'name' => 'Philosophie',
                    'desc' => 'Idées et arguments rencontrés à travers des textes primaires, des conférences et des lectures indépendantes.',
                    'link' => 'learning/philosophy/',
                ],
            ],
        ],

        'projects' => [
            'label'    => 'Projets',
            'title'    => 'Projets & applications',
            'desc'     => 'Travaux pratiques démontrant l’application des connaissances, la résolution de problèmes, la collaboration, les compétences techniques et la communication.',
            'cta'      => 'Voir le projet',
            'unit'     => 'projet',
            'featured' => [
                'code' => 'PR' . MIDDOT . '01',
                'name' => 'Jumeau numérique — Sécurité ferroviaire',
                'desc' => 'Projet technologique portant sur la sécurité ferroviaire à travers des capteurs, la surveillance, les concepts de jumeau numérique et un environnement simulé.',
                'tags' => ['Jumeau numérique', 'Capteurs', 'ESP32', 'Coordination', 'Communication technique'],
                'link' => 'projects/digital-twin-railway-safety/',
            ],
        ],

        'papers_home' => [
            'label' => 'Papiers',
            'title' => 'Papiers',
            'desc'  => 'Copies PDF de travaux rédigés au fil du temps, conservées ici pour référence.',
            'cta'   => 'Parcourir les papiers',
            'unit'  => 'papiers',
            'unit_singular' => 'papier',
            'link'  => 'papers/',
        ],

        'esp32' => [
            'label' => 'Matériel',
            'title' => 'Contrôleurs',
            'desc'  => 'Interfaces permettant de contrôler et de tester le matériel du projet ferroviaire.',
            'cta'   => 'Ouvrir',
            'items' => [
                [
                    'name' => 'Contrôleur Wemos',
                    'desc' => 'Interface principale de contrôle du matériel du jumeau numérique.',
                    'link' => 'https://koalaman.my.id/esp32wemos/',
                ],
                [
                    'name' => 'ESP32 DevKit V1',
                    'desc' => 'Carte secondaire utilisée pour les tests de capteurs et de micrologiciel.',
                    'link' => 'https://koalaman.my.id/esp32devkitv1/',
                ],
            ],
        ],

        'french' => [
            'eyebrow'         => 'Apprentissage ' . MIDDOT . ' Français',
            'title'           => 'Phrases en français',
            'desc'            => 'Un registre continu de phrases originales écrites en apprenant du nouveau vocabulaire. Chacune est datée au moment de son ajout.',
            'form_title'      => 'Ajouter une phrase',
            'label_sentence'  => 'Phrase (français)',
            'placeholder_sentence' => 'ex. Je voudrais apprendre le français chaque jour.',
            'label_note'      => 'Note (optionnelle)',
            'placeholder_note' => 'Signification, contexte, ou le mot pratiqué',
            'label_passphrase' => 'Mot de passe',
            'placeholder_passphrase' => 'Requis pour ajouter une entrée',
            'submit'          => 'Ajouter l’entrée',
            'error_empty'     => 'Le champ de la phrase ne peut pas être vide.',
            'error_passphrase' => 'Ce mot de passe est incorrect.',
            'success'         => 'Phrase ajoutée.',
            'wall_title'      => 'Registre',
            'wall_empty'      => 'Aucune phrase enregistrée pour le moment.',
            'back'            => 'Retour à Apprentissage',
        ],

        'papers' => [
            'eyebrow'          => 'Papiers',
            'title'            => 'Papiers',
            'desc'             => 'Copies PDF de travaux rédigés au fil du temps, téléversées ici pour référence.',
            'form_title'       => 'Téléverser un papier',
            'label_title'      => 'Titre',
            'placeholder_title' => 'ex. Le rôle des statistiques dans la recherche psychologique',
            'label_description' => 'Description (optionnelle)',
            'placeholder_description' => 'Matière, cours, ou contexte',
            'label_date'       => 'Date de rédaction (optionnelle)',
            'written_prefix'   => 'Rédigé le',
            'uploaded_prefix'  => 'Téléversé le',
            'label_file'       => 'Fichier PDF',
            'label_passphrase' => 'Mot de passe',
            'placeholder_passphrase' => 'Requis pour téléverser',
            'submit'           => 'Téléverser',
            'error_empty'      => 'Le champ du titre ne peut pas être vide.',
            'error_passphrase' => 'Ce mot de passe est incorrect.',
            'error_no_file'    => 'Choisissez un fichier PDF à téléverser.',
            'error_not_pdf'    => 'Seuls les fichiers PDF sont acceptés.',
            'error_too_large'  => 'Ce fichier est trop volumineux (20 Mo maximum).',
            'error_upload_failed' => 'Le téléversement a échoué. Veuillez réessayer.',
            'error_storage'    => 'Impossible d’enregistrer le fichier sur le serveur. Vérifiez que le dossier de stockage est accessible en écriture.',
            'success'          => 'Papier téléversé.',
            'list_title'       => 'Papiers',
            'list_empty'       => 'Aucun papier téléversé pour le moment.',
            'view'             => 'Voir le PDF',
            'back'             => 'Retour à l’accueil',
        ],

        'mascot' => [
            'aria_label' => 'Klaxonner le nez de clown',
        ],

        'footer' => [
            'links'     => 'Apprentissage ' . MIDDOT . ' Projets ' . MIDDOT . ' Papiers',
            'copyright' => 'Koalaman',
        ],

    ],

];
