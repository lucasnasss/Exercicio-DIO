<?php
/**
 * WooCommerce Compatibility
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Remover estilos padrão do WooCommerce
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Wrapper de abertura para produtos WooCommerce
 */
function iron_task_woocommerce_wrapper_before() {
    echo '<div class="container">';
}
add_action( 'woocommerce_before_main_content', 'iron_task_woocommerce_wrapper_before', 10 );

/**
 * Wrapper de fechamento para produtos WooCommerce
 */
function iron_task_woocommerce_wrapper_after() {
    echo '</div>';
}
add_action( 'woocommerce_after_main_content', 'iron_task_woocommerce_wrapper_after', 10 );

/**
 * Sidebar para WooCommerce
 */
function iron_task_woocommerce_sidebar() {
    if ( is_active_sidebar( 'sidebar-1' ) ) {
        woocommerce_get_sidebar();
    }
}
add_action( 'woocommerce_sidebar', 'iron_task_woocommerce_sidebar', 10 );

/**
 * Número de colunas na loja
 */
function iron_task_loop_columns() {
    return 4;
}
add_filter( 'loop_shop_columns', 'iron_task_loop_columns' );

/**
 * Produtos por página
 */
function iron_task_products_per_page() {
    return 12;
}
add_filter( 'loop_shop_per_page', 'iron_task_products_per_page' );

/**
 * Mini cart no header
 */
function iron_task_header_cart() {
    if ( class_exists( 'WooCommerce' ) ) {
        ?>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="navbar__cart" aria-label="<?php esc_attr_e( 'Ver carrinho', 'iron-task' ); ?>">
            <svg class="navbar__cart-icon" viewBox="0 0 24 24" width="24" height="24">
                <path d="M6 6h15l-1.5 9h-12z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/>
                <circle cx="9" cy="20" r="1.5" fill="currentColor"/>
                <circle cx="18" cy="20" r="1.5" fill="currentColor"/>
                <path d="M6 6L5 2H2" stroke="currentColor" stroke-width="1.5" fill="none"/>
            </svg>
            <span class="navbar__cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
        </a>
        <?php
    }
}

/**
 * Customizar botão de adicionar ao carrinho
 */
function iron_task_add_to_cart_text( $text, $product ) {
    return $product->is_type( 'variable' ) ? __( 'Ver opções', 'iron-task' ) : __( 'Adicionar ao Carrinho', 'iron-task' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'iron_task_add_to_cart_text', 10, 2 );

/**
 * Badge de produto personalizado
 */
function iron_task_sale_flash() {
    global $product;
    if ( $product->is_on_sale() ) {
        return '<span class="product-badge product-badge--sale">' . __( 'Oferta', 'iron-task' ) . '</span>';
    }
    return '';
}
add_filter( 'woocommerce_sale_flash', 'iron_task_sale_flash' );

/**
 * Remover breadcrumb padrão do WooCommerce
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Adicionar breadcrumb personalizado
 */
function iron_task_woocommerce_breadcrumb() {
    if ( function_exists( 'iron_task_breadcrumbs' ) ) {
        echo '<div class="container" style="margin-bottom: 2rem;">';
        iron_task_breadcrumbs();
        echo '</div>';
    }
}
add_action( 'woocommerce_before_shop_loop', 'iron_task_woocommerce_breadcrumb', 5 );

/**
 * Modificar estrutura do single product
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
