<?php
// Función para generar un shortcode aleatorio
function wpgch_generate_random_shortcode() {
    if (isset($_POST['wpgch_generate_shortcode'])) {
        // Generar un shortcode aleatorio
        $random_shortcode = 'github_commit_history_' . substr(md5(uniqid()), 0, 8);

        // Guardar el shortcode generado en la opción de WordPress
        $shortcodes = get_option('wpgch_generated_shortcodes', array());
        $shortcodes[] = $random_shortcode;
        update_option('wpgch_generated_shortcodes', $shortcodes);

        // Guardar la información proporcionada por el usuario en las opciones de WordPress
        if (isset($_POST['wpgch_github_username']) && isset($_POST['wpgch_github_repo']) && isset($_POST['wpgch_github_token'])) {
            update_option('wpgch_github_username', $_POST['wpgch_github_username']);
            update_option('wpgch_github_repo', $_POST['wpgch_github_repo']);
            update_option('wpgch_github_token', $_POST['wpgch_github_token']);
        }
    }
}

// Función para mostrar el historial de commits de GitHub
function wpgch_display_commit_history_shortcode() {
    ob_start(); // Comienza el almacenamiento en búfer de salida

    // Obtener la información de GitHub del usuario desde las opciones de WordPress
    $username = get_option('wpgch_github_username');
    $repo = get_option('wpgch_github_repo');
    $token = get_option('wpgch_github_token');

    // Verificar si se proporcionó la información necesaria
    if (!empty($username) && !empty($repo) && !empty($token)) {
        // Mostrar el historial de commits utilizando la información proporcionada
        echo '<div class="wpgch-commit-history">';
        echo '<h2>GitHub Commit History</h2>';
        echo '<ul class="wpgch-commit-list">'; // Agregamos la clase "wpgch-commit-list"
        // Aquí iría el código para obtener los commits y mostrarlos utilizando la información de GitHub
        echo '</ul>';
        echo '</div>';
    } else {
        // Mostrar un mensaje de error si falta información
        echo '<p>Error: Please enter your GitHub credentials in the settings page.</p>';
    }

    return ob_get_clean(); // Devuelve el contenido almacenado en búfer y limpia el búfer de salida
}