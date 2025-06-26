<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function() {
    add_options_page(
        'Produtos em Destaque',
        'Produtos em Destaque',
        'manage_options',
        'produtos-destaque',
        'pd_settings_page'
    );
});

add_action('admin_init', function() {
    register_setting('pd_settings', 'pd_categorias');
    register_setting('pd_settings', 'pd_qtd_produtos');
    register_setting('pd_settings', 'pd_titulo_font_size');
    register_setting('pd_settings', 'pd_titulo_color');
});

function pd_settings_page() {
    $categorias = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    $selected = (array)get_option('pd_categorias', []);
    $qtd = intval(get_option('pd_qtd_produtos', 4));
    ?>
    <div class="wrap">
        <h1>Produtos em Destaque por Categoria</h1>
        <form method="post" action="options.php">
            <?php settings_fields('pd_settings'); ?>
            <table class="form-table">
                <tr>
                    <th>Categorias para exibir</th>
                    <td>
                        <?php foreach ($categorias as $cat): ?>
                            <label>
                                <input type="checkbox" name="pd_categorias[]" value="<?php echo esc_attr($cat->slug); ?>" <?php checked(in_array($cat->slug, $selected)); ?>>
                                <?php echo esc_html($cat->name); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <th>Quantidade de produtos por categoria</th>
                    <td>
                        <input type="number" name="pd_qtd_produtos" value="<?php echo esc_attr($qtd); ?>" min="1" max="20">
                    </td>
                </tr>
                <tr>
                    <th>Tamanho da fonte do título (px)</th>
                    <td>
                        <input type="number" name="pd_titulo_font_size" placeholder="10-50" value="<?php echo esc_attr(get_option('pd_titulo_font_size', 20)); ?>" min="10" max="50">
                    </td>
                </tr>
                <tr>
                    <th>Cor do título</th>
                    <td>
                        <input type="color" name="pd_titulo_color" value="<?php echo esc_attr(get_option('pd_titulo_color', '#000000')); ?>">
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <p>Use o shortcode <code>[produtos_destaque_categoria]</code> no Elementor ou em qualquer página.</p>

        <p>
            Plugin desenvolvido por 
            <a href="<?php echo esc_url($autor_link); ?>" target="_blank" rel="noopener noreferrer">
                Andrei Moterle
            </a>
        </p>
    </div>
    <?php
}