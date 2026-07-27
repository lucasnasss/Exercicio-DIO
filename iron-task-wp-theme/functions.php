<?php
/**
 * Iron Task Theme Functions
 *
 * @package Iron_Task
 * @since 1.0.0
 */

// Evitar acesso direto ao arquivo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define constantes do tema
 */
define( 'IRON_TASK_VERSION', '1.0.0' );
define( 'IRON_TASK_DIR', get_template_directory() );
define( 'IRON_TASK_URI', get_template_directory_uri() );

/**
 * Setup inicial do tema
 */
function iron_task_setup() {
    // Suporte a tradução
    load_theme_textdomain( 'iron-task', IRON_TASK_DIR . '/languages' );

    // Tags de título dinâmicas
    add_theme_support( 'title-tag' );

    // Feed links
    add_theme_support( 'automatic-feed-links' );

    // Imagens destacadas
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1200, 675, true );
    add_image_size( 'iron-task-hero', 1920, 1080, true );
    add_image_size( 'iron-task-product', 600, 600, true );
    add_image_size( 'iron-task-thumbnail', 300, 300, true );

    // HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Logo personalizado
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 80,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Background personalizado
    add_theme_support( 'custom-background', array(
        'default-color' => '0A0A0C',
    ) );

    // Editor de estilos
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );

    // WooCommerce
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Registrar menus
    register_nav_menus( array(
        'primary'   => __( 'Menu Principal', 'iron-task' ),
        'footer'    => __( 'Menu Rodapé', 'iron-task' ),
        'mobile'    => __( 'Menu Mobile', 'iron-task' ),
    ) );

    // Viewport
    add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'iron_task_setup' );

/**
 * Registrar áreas de widgets
 */
function iron_task_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Barra Lateral', 'iron-task' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Adicione widgets aqui.', 'iron-task' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Rodapé 1', 'iron-task' ),
        'id'            => 'footer-1',
        'description'   => __( 'Primeira coluna do rodapé.', 'iron-task' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Rodapé 2', 'iron-task' ),
        'id'            => 'footer-2',
        'description'   => __( 'Segunda coluna do rodapé.', 'iron-task' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Rodapé 3', 'iron-task' ),
        'id'            => 'footer-3',
        'description'   => __( 'Terceira coluna do rodapé.', 'iron-task' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'iron_task_widgets_init' );

/**
 * Enfileirar scripts e estilos
 */
function iron_task_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'iron-task-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500;700&display=swap',
        array(),
        null
    );

    // Estilo principal
    wp_enqueue_style(
        'iron-task-style',
        get_stylesheet_uri(),
        array( 'iron-task-google-fonts' ),
        IRON_TASK_VERSION
    );

    // WooCommerce styles
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_style( 'woocommerce-general' );
    }

    // Script principal
    wp_enqueue_script(
        'iron-task-main',
        IRON_TASK_URI . '/assets/js/main.js',
        array( 'jquery' ),
        IRON_TASK_VERSION,
        true
    );

    // Localize script para AJAX e outras variáveis
    wp_localize_script( 'iron-task-main', 'ironTaskData', array(
        'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
        'nonce'       => wp_create_nonce( 'iron_task_nonce' ),
        'homeUrl'     => home_url( '/' ),
        'cartCount'   => function_exists( 'WC' ) ? WC()->cart->get_cart_contents_count() : 0,
        'themeMod'    => get_option( 'iron_task_theme', 'dark' ),
        'i18n'        => array(
            'addToCart'     => __( 'Adicionado ao carrinho', 'iron-task' ),
            'removeFromCart'=> __( 'Removido do carrinho', 'iron-task' ),
            'error'         => __( 'Ocorreu um erro. Tente novamente.', 'iron-task' ),
            'loading'       => __( 'Carregando...', 'iron-task' ),
        ),
    ) );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'iron_task_scripts' );

/**
 * Incluir arquivos adicionais
 */
require_once IRON_TASK_DIR . '/inc/customizer.php';
require_once IRON_TASK_DIR . '/inc/template-functions.php';
require_once IRON_TASK_DIR . '/inc/template-tags.php';

/**
 * Compatibilidade com WooCommerce
 */
if ( class_exists( 'WooCommerce' ) ) {
    require_once IRON_TASK_DIR . '/inc/woocommerce.php';
}

/**
 * Configurar largura do conteúdo
 */
if ( ! isset( $content_width ) ) {
    $content_width = 1200;
}

/**
 * Adicionar classes personalizadas ao body
 */
function iron_task_body_classes( $classes ) {
    // Adicionar classe se for singular
    if ( is_singular() ) {
        $classes[] = 'singular';
    }

    // Adicionar classe se tiver sidebar
    if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() ) {
        $classes[] = 'has-sidebar';
    }

    // Tema claro/escuro
    $theme_mod = get_option( 'iron_task_theme', 'dark' );
    $classes[] = 'theme-' . esc_attr( $theme_mod );

    return $classes;
}
add_filter( 'body_class', 'iron_task_body_classes' );

/**
 * Preload de recursos críticos
 */
function iron_task_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'iron_task_resource_hints', 10, 2 );

/**
 * Remover versão do WordPress do head (segurança)
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Remover emojis do WordPress (performance)
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

/**
 * Adicionar suporte a blocos do Gutenberg
 */
function iron_task_block_editor_styles() {
    wp_enqueue_style(
        'iron-task-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500;700&display=swap',
        array(),
        null
    );
}
add_action( 'enqueue_block_editor_assets', 'iron_task_block_editor_styles' );

/**
 * Customizar excerpt
 */
function iron_task_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'iron_task_excerpt_length' );

function iron_task_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'iron_task_excerpt_more' );

/**
 * Registrar padrões de blocos
 */
function iron_task_register_block_patterns() {
    if ( function_exists( 'register_block_pattern' ) ) {
        register_block_pattern(
            'iron-task/hero',
            array(
                'title'       => __( 'Hero Iron Task', 'iron-task' ),
                'description' => __( 'Seção hero com estilo Iron Task', 'iron-task' ),
                'content'     => '<!-- wp:cover {"align":"full","style":{"spacing":{"padding":{"top":"var(--wp--preset--spacing--70)","bottom":"var(--wp--preset--spacing--70)"}}}} --><div class="wp-block-cover alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":1} --><h1 class="has-text-align-center">FORJADO NO FOGO</h1><!-- /wp:heading --></div></div><!-- /wp:cover -->',
            )
        );
    }
}
add_action( 'init', 'iron_task_register_block_patterns' );

/**
 * Filtro para modificar query principal
 */
function iron_task_pre_get_posts( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        // Posts por página na loja WooCommerce
        if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
            $query->set( 'posts_per_page', 12 );
        }
    }
}
add_action( 'pre_get_posts', 'iron_task_pre_get_posts' );

/**
 * Adicionar endpoint de API personalizado para AJAX
 */
function iron_task_ajax_handlers() {
    // Para usuários logados
    add_action( 'wp_ajax_iron_task_add_to_cart', 'iron_task_ajax_add_to_cart' );
    // Para visitantes
    add_action( 'wp_ajax_nopriv_iron_task_add_to_cart', 'iron_task_ajax_add_to_cart' );
}
add_action( 'wp_ajax_init', 'iron_task_ajax_handlers' );

/**
 * Handler AJAX para adicionar ao carrinho
 */
function iron_task_ajax_add_to_cart() {
    check_ajax_referer( 'iron_task_nonce', 'nonce' );

    if ( ! class_exists( 'WooCommerce' ) ) {
        wp_send_json_error( array( 'message' => __( 'WooCommerce não está ativo.', 'iron-task' ) ) );
    }

    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    $quantity   = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;

    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => __( 'Produto inválido.', 'iron-task' ) ) );
    }

    $added = WC()->cart->add_to_cart( $product_id, $quantity );

    if ( $added ) {
        wp_send_json_success( array(
            'message'   => __( 'Produto adicionado ao carrinho!', 'iron-task' ),
            'cartCount' => WC()->cart->get_cart_contents_count(),
        ) );
    } else {
        wp_send_json_error( array( 'message' => __( 'Não foi possível adicionar ao carrinho.', 'iron-task' ) ) );
    }
}
