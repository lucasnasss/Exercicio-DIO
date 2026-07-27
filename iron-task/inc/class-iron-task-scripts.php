<?php
/**
 * Iron Task Scripts Class
 *
 * Gerenciamento de scripts e estilos
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe de gerenciamento de scripts
 */
class Iron_Task_Scripts {

	/**
	 * Construtor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'style_loader_src', array( $this, 'add_css_version' ), 10, 2 );
		add_filter( 'script_loader_src', array( $this, 'add_js_version' ), 10, 2 );
	}

	/**
	 * Carrega os estilos do tema
	 */
	public function enqueue_styles() {
		// Estilo principal do tema
		wp_enqueue_style(
			'iron-task-style',
			get_stylesheet_uri(),
			array(),
			IRON_TASK_VERSION
		);

		// Google Fonts - Bebas Neue
		wp_enqueue_style(
			'iron-task-fonts',
			'https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap',
			array(),
			null
		);

		// Dashicons para ícones do admin
		wp_enqueue_style( 'dashicons' );
	}

	/**
	 * Carrega os scripts do tema
	 */
	public function enqueue_scripts() {
		// Script principal do tema
		wp_enqueue_script(
			'iron-task-main',
			IRON_TASK_URI . '/assets/js/main.js',
			array(),
			IRON_TASK_VERSION,
			true
		);

		// Localiza script com variáveis do WordPress
		wp_localize_script(
			'iron-task-main',
			'ironTaskConfig',
			array(
				'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
				'nonce'         => wp_create_nonce( 'iron_task_nonce' ),
				'siteUrl'       => get_site_url(),
				'themeUrl'      => get_template_directory_uri(),
				'cartCount'     => WC()->cart ? WC()->cart->get_cart_contents_count() : 0,
				'isWooCommerce' => class_exists( 'WooCommerce' ),
				'i18n'          => array(
					'addToCart'     => __( 'Adicionar ao Carrinho', 'iron-task' ),
					'addedToCart'   => __( 'foi adicionado ao seu carrinho!', 'iron-task' ),
					'loading'       => __( 'Carregando...', 'iron-task' ),
					'search'        => __( 'Buscar produtos...', 'iron-task' ),
					'noResults'     => __( 'Nenhum produto encontrado.', 'iron-task' ),
					'error'         => __( 'Ocorreu um erro. Tente novamente.', 'iron-task' ),
					'close'         => __( 'Fechar', 'iron-task' ),
					'menu'          => __( 'Menu', 'iron-task' ),
					'cart'          => __( 'Carrinho', 'iron-task' ),
					'emptyCart'     => __( 'Seu carrinho está vazio.', 'iron-task' ),
					'viewCart'      => __( 'Ver Carrinho', 'iron-task' ),
					'checkout'      => __( 'Finalizar Compra', 'iron-task' ),
					'quickView'     => __( 'Visualização Rápida', 'iron-task' ),
					'sale'          => __( 'Oferta', 'iron-task' ),
					'new'           => __( 'Novo', 'iron-task' ),
					'limited'       => __( 'Limitado', 'iron-task' ),
				),
			)
		);

		// Comment reply script
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Remove jQuery migrate (performance)
		if ( wp_script_is( 'jquery', 'registered' ) ) {
			wp_deregister_script( 'jquery' );
			wp_register_script(
				'jquery',
				includes_url( '/js/jquery/jquery.min.js' ),
				array(),
				'3.7.1',
				true
			);
			wp_enqueue_script( 'jquery' );
		}
	}

	/**
	 * Adiciona versão aos arquivos CSS
	 *
	 * @param string $src URL do arquivo
	 * @param string $handle Handle do arquivo
	 * @return string URL modificada
	 */
	public function add_css_version( $src, $handle ) {
		if ( strpos( $src, IRON_TASK_URI ) !== false ) {
			$src = add_query_arg( 'ver', IRON_TASK_VERSION, $src );
		}
		return $src;
	}

	/**
	 * Adiciona versão aos arquivos JS
	 *
	 * @param string $src URL do arquivo
	 * @param string $handle Handle do arquivo
	 * @return string URL modificada
	 */
	public function add_js_version( $src, $handle ) {
		if ( strpos( $src, IRON_TASK_URI ) !== false ) {
			$src = add_query_arg( 'ver', IRON_TASK_VERSION, $src );
		}
		return $src;
	}

	/**
	 * Adiciona script inline para theme toggle
	 */
	public static function theme_toggle_script() {
		?>
		<script>
			(function() {
				// Theme toggle immediate execution
				const saved = localStorage.getItem('iron-task-theme');
				const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
				
				if (saved === 'light' || (!saved && !prefersDark)) {
					document.documentElement.setAttribute('data-theme', 'light');
				} else {
					document.documentElement.setAttribute('data-theme', 'dark');
				}
			})();
		</script>
		<?php
	}
}
