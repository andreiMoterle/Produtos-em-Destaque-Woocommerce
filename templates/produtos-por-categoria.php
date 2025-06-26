<?php if (!empty($categorias)): ?>
<div class="pd-categorias-tabs">
    <ul class="pd-categorias-list seletorColecoes elementor-icon-list-items elementor-inline-items">
        <?php foreach ($categorias as $i => $slug): 
            $categoria = get_term_by('slug', $slug, 'product_cat');
            if (!$categoria) continue;
            ?>
            <li class="elementor-icon-list-item elementor-inline-item<?php echo $i === 0 ? ' active' : ''; ?>">
                <a href="#pdcat-<?php echo esc_attr($slug); ?>">
                    <span class="elementor-icon-list-text"><?php echo esc_html($categoria->name); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="pd-categorias-content">
    <?php
    $font_size = get_option('pd_titulo_font_size', 20);
    $title_color = get_option('pd_titulo_color', '#000000');
    ?>

    <?php foreach ($categorias as $i => $slug): 
        $categoria = get_term_by('slug', $slug, 'product_cat');
        if (!$categoria) continue;
        $args = [
            'post_type' => 'product',
            'posts_per_page' => $qtd,
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $slug,
                ],
            ],
        ];
        $loop = new WP_Query($args);
        ?>
        <div class="pd-categoria-block content-block pdcat-<?php echo esc_attr($slug); ?><?php echo $i === 0 ? ' active' : ''; ?>">
            <ul class="list-products elementor-grid columns-4">
                <?php while ($loop->have_posts()): $loop->the_post(); global $product; ?>
                    <li <?php wc_product_class('', $product); ?>>
                        <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                            <?php echo $product->get_image(); ?>
                            <h2 class="woocommerce-loop-product__title" style="font-size:<?php echo esc_attr($font_size); ?>px;color:<?php echo esc_attr($title_color); ?>;">
                                <?php the_title(); ?>
                            </h2>
                            <span class="price"><?php echo $product->get_price_html(); ?></span>
                            <?php
                            if (function_exists('pfp_exibir_valor_parcelado')) {
                                pfp_exibir_valor_parcelado($product->get_price(), 'preco-parcelado-listagem', true);
                            }
                            ?>
                        </a>
                        <?php woocommerce_template_loop_add_to_cart(); ?>
                    </li>
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>
            <div class="elementor-widget-container" style="margin-top:20px;">
                <div class="elementor-button-wrapper">
                    <a class="seeAllButton elementor-button elementor-button-link elementor-size-sm elementor-animation-shrink"
                    href="<?php echo esc_url(get_term_link($categoria)); ?>">
                        <span class="elementor-button-content-wrapper">
                            <span class="elementor-button-text">Ver todos</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>