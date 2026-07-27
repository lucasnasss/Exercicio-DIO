<?php
/**
 * Iron Task Setup Class
 *
 * Configurações básicas do tema
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe de configuração do tema
 */
class Iron_Task_Setup {

	/**
	 * Construtor
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
		add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'init', array( $this, 'register_sidebars' ) );
		add_action( 'init', array( $this, 'register_image_sizes' ) );
	}

	/**
	 * Configurações básicas do tema
	 */
	public function setup() {
		// Suporte a tradução
		load_theme_textdomain( 'iron-task', IRON_TASK_DIR . '/languages' );

		// Adiciona suporte a tags title dinâmicas
		add_theme_support( 'title-tag' );

		// Adiciona suporte a RSS feeds
		add_theme_support( 'automatic-feed-links' );

		// Adiciona suporte a HTML5
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Adiciona suporte a post thumbnails
		add_theme_support( 'post-thumbnails' );

		// Adiciona suporte a custom logo
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 60,
				'width'       => 200,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Adiciona suporte a custom background
		add_theme_support( 'custom-background' );

		// Adiciona suporte a custom header
		add_theme_support(
			'custom-header',
			array(
				'default-image'      => '',
				'default-text-color' => 'C9A44B',
				'width'              => 1920,
				'height'             => 400,
				'flex-height'        => true,
				'flex-width'         => true,
			)
		);

		// Adiciona suporte a editor styles
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor-style.css' );

		// Adiciona suporte a responsive embeds
		add_theme_support( 'responsive-embeds' );

		// Adiciona suporte a WooCommerce
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Adiciona suporte a Customizer
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Define tamanho padrão do thumbnail
		set_post_thumbnail_size( 600, 800, true );

		// Define formato de data
		update_option( 'date_format', 'd \d\e F \d\e Y' );
		update_option( 'time_format', 'H:i' );
	}

	/**
	 * Registra menus de navegação
	 */
	public function register_menus() {
		register_nav_menus(
			array(
				'primary'   => __( 'Menu Principal', 'iron-task' ),
				'mobile'    => __( 'Menu Mobile', 'iron-task' ),
				'footer'    => __( 'Menu Rodapé', 'iron-task' ),
				'secondary' => __( 'Menu Secundário', 'iron-task' ),
			)
		);
	}

	/**
	 * Registra sidebars/widget areas
	 */
	public function register_sidebars() {
		register_sidebar(
			array(
				'name'          => __( 'Sidebar Principal', 'iron-task' ),
				'id'            => 'sidebar-1',
				'description'   => __( 'Adicione widgets aqui para exibir na sidebar.', 'iron-task' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Rodapé - Coluna 1', 'iron-task' ),
				'id'            => 'footer-1',
				'description'   => __( 'Primeira coluna do rodapé.', 'iron-task' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="footer__heading">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Rodapé - Coluna 2', 'iron-task' ),
				'id'            => 'footer-2',
				'description'   => __( 'Segunda coluna do rodapé.', 'iron-task' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="footer__heading">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Rodapé - Coluna 3', 'iron-task' ),
				'id'            => 'footer-3',
				'description'   => __( 'Terceira coluna do rodapé.', 'iron-task' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="footer__heading">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Rodapé - Coluna 4', 'iron-task' ),
				'id'            => 'footer-4',
				'description'   => __( 'Quarta coluna do rodapé.', 'iron-task' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="footer__heading">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Shop Sidebar', 'iron-task' ),
				'id'            => 'shop-sidebar',
				'description'   => __( 'Sidebar para página da loja.', 'iron-task' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	/**
	 * Registra tamanhos de imagem customizados
	 */
	public function register_image_sizes() {
		// Thumbnail para produtos
		add_image_size( 'iron-task-product-thumb', 600, 800, true );

		// Imagem grande para single product
		add_image_size( 'iron-task-product-large', 800, 1067, false );

		// Imagem para hero/destaque
		add_image_size( 'iron-task-hero', 1920, 800, true );

		// Imagem quadrada para grid
		add_image_size( 'iron-task-square', 400, 400, true );

		// Imagem pequena para thumbnails
		add_image_size( 'iron-task-small', 300, 200, true );
	}
}
