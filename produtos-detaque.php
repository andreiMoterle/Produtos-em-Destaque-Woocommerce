<?php
/**
 * Plugin Name: Produtos em Destaque por Categoria
 * Description: Exibe produtos do WooCommerce por categoria, com seleção no admin.
 * Version: 1.21
 * Author: Andrei Moterle
 * Author URI: https://github.com/andreiMoterle
 */

if (!defined('ABSPATH')) exit;

// Ativa opções padrão ao ativar
register_activation_hook(__FILE__, function() {
    add_option('pd_categorias', []);
    add_option('pd_qtd_produtos', 4);
});

// Carrega CSS/JS
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('pd-style', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('pd-script', plugin_dir_url(__FILE__) . 'assets/script.js', [], false, true);
});

// Adiciona página no admin
require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';

// Shortcode
add_shortcode('produtos_destaque_categoria', function() {
    $categorias = get_option('pd_categorias', []);
    $qtd = intval(get_option('pd_qtd_produtos', 4));
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/produtos-por-categoria.php';
    return ob_get_clean();
});