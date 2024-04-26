<?php
/**
 * Plugin Name: WP GitHub Commit History
 * Description: Displays commit history from a GitHub repository in the WordPress dashboard and on pages using a shortcode.
 * Version: 1.0
 * Author: Your Name
 */

// Incluye el archivo de funciones principales
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Agregar página de configuración en el panel de administración
add_action('admin_menu', 'wpgch_add_admin_menu');
function wpgch_add_admin_menu() {
    add_menu_page(
        'GitHub Commit History Settings',
        'GitHub Settings',
        'manage_options',
        'wpgch-settings',
        'wpgch_display_settings_page'
    );
}

// Generar el shortcode aleatorio al cargar la página de configuración
add_action('admin_init', 'wpgch_generate_random_shortcode');
// Manejar la acción de vaciar los shortcodes generados
add_action('admin_init', 'wpgch_clear_generated_shortcodes');

// Función para mostrar la página de configuración
function wpgch_display_settings_page() {
?>
<div class="wrap wpgch-container">
    <h1><?php echo esc_html__('GitHub Commit History Settings', 'wpgch'); ?></h1>
    <form method="post" action="">
        <p>Enter your GitHub credentials below:</p>
        <input type="text" name="wpgch_github_username" placeholder="GitHub Username" /><br>
        <input type="text" name="wpgch_github_repo" placeholder="GitHub Repository" /><br>
        <input type="text" name="wpgch_github_token" placeholder="GitHub Access Token" /><br>
        <input type="submit" name="wpgch_generate_shortcode" value="Generate Shortcode" />
    </form>

    <?php
    // Mostrar los shortcodes generados
    $shortcodes = get_option('wpgch_generated_shortcodes', array());
    if (!empty($shortcodes)) {
        echo '<h2>Generated Shortcodes</h2>';
        echo '<ul>';
        foreach ($shortcodes as $shortcode) {
            echo '<li>[' . esc_html($shortcode) . ']</li>';
        }
        echo '</ul>';
    }
    ?>
</div>
<?php
}


// Shortcode para mostrar el historial de commits de GitHub
add_shortcode('wpgch_commit_history', 'wpgch_display_commit_history_shortcode');

// Función para enlazar el archivo de estilos CSS
add_action('admin_enqueue_scripts', 'wpgch_enqueue_styles');
function wpgch_enqueue_styles() {
    wp_enqueue_style('wpgch-admin-styles', plugin_dir_url(__FILE__) . 'assets/css/github-commit-history.css');
}

// Función para vaciar todos los shortcodes generados
function wpgch_clear_generated_shortcodes() {
    if (isset($_POST['wpgch_clear_shortcodes'])) {
        // Eliminar todos los shortcodes almacenados en las opciones de WordPress
        delete_option('wpgch_generated_shortcodes');
    }
}

// Función para mostrar los shortcodes generados
function wpgch_display_generated_shortcodes() {
    $shortcodes = get_option('wpgch_generated_shortcodes', array());
    if (!empty($shortcodes)) {
        echo '<h2>Generated Shortcodes</h2>';
        echo '<ul>';
        foreach ($shortcodes as $shortcode) {
            echo '<li>' . esc_html($shortcode) . '</li>';
        }
        echo '</ul>';
        // Botón para vaciar todos los shortcodes generados
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="wpgch_clear_shortcodes" value="1" />';
        echo '<input type="submit" name="wpgch_clear_shortcodes_button" value="Clear All Shortcodes" />';
        echo '</form>';
    }
}