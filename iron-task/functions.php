<?php
/**
 * Iron Task Theme Functions
 *
 * @package Iron_Task
 * @since 1.0.0
 */

// Evita acesso direto ao arquivo
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
 * Carrega arquivos de inclusão
 */
require_once IRON_TASK_DIR . '/inc/class-iron-task-setup.php';
require_once IRON_TASK_DIR . '/inc/class-iron-task-scripts.php';
require_once IRON_TASK_DIR . '/inc/class-iron-task-widgets.php';
require_once IRON_TASK_DIR . '/inc/class-iron-task-template-tags.php';
require_once IRON_TASK_DIR . '/inc/class-iron-task-woocommerce.php';

/**
 * Instancia as classes principais
 */
function iron_task_init() {
	new Iron_Task_Setup();
	new Iron_Task_Scripts();
	new Iron_Task_Widgets();
	new Iron_Task_Template_Tags();
	
	// Inicializa WooCommerce apenas se o plugin estiver ativo
	if ( class_exists( 'WooCommerce' ) ) {
		new Iron_Task_WooCommerce();
	}
}
add_action( 'after_setup_theme', 'iron_task_init', 9 );

/**
 * Funções helper globais
 */

/**
 * Retorna o SVG do logo Iron Task
 *
 * @return string SVG do logo
 */
function iron_task_get_logo_svg() {
	return '<svg class="navbar__logo-icon" viewBox="0 0 40 32" xmlns="http://www.w3.org/2000/svg">
		<path fill="var(--accent-primary)" d="M20 2L8 8v6c0 6.5 5 12.5 12 14 7-1.5 12-7.5 12-14V8L20 2zm-1 7h2v3h-2V9zm0 5h2v7h-2v-7z"/>
	</svg>';
}

/**
 * Exibe o logo Iron Task
 *
 * @param bool $echo Se deve imprimir ou retornar
 * @return string|void
 */
function iron_task_the_logo( $echo = true ) {
	$logo = iron_task_get_logo_svg();
	
	if ( $echo ) {
		echo $logo;
	}
	
	return $logo;
}

/**
 * Formata preço no padrão brasileiro
 *
 * @param float $value Valor a ser formatado
 * @return string Preço formatado
 */
function iron_task_format_price( $value ) {
	return 'R$ ' . number_format( $value, 2, ',', '.' );
}

/**
 * Verifica se está na página da loja WooCommerce
 *
 * @return bool
 */
function iron_task_is_shop_page() {
	return function_exists( 'is_woocommerce' ) && is_woocommerce();
}

/**
 * Retorna URL de produto mock para demonstração
 *
 * @param int $product_id ID do produto
 * @return string URL do produto
 */
function iron_task_get_product_url( $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_the_ID();
	}
	
	return get_permalink( $product_id );
}

/**
 * Adiciona classes customizadas ao body
 *
 * @param array $classes Classes existentes
 * @return array Classes modificadas
 */
function iron_task_body_classes( $classes ) {
	// Adiciona classe para tema dark/light
	$theme_mode = get_option( 'iron_task_theme_mode', 'dark' );
	$classes[] = 'iron-task-theme-' . $theme_mode;
	
	// Adiciona classe para layout
	if ( is_page_template( 'templates/full-width.php' ) ) {
		$classes[] = 'full-width-layout';
	}
	
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
 * Adiciona suporte a preload para fonts
 */
function iron_task_preload_fonts() {
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php
}
add_action( 'wp_head', 'iron_task_preload_fonts', 1 );

/**
 * Remove versões do WordPress e jQuery do head (segurança)
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

/**
 * Remove emojis não utilizados (performance)
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/**
 * Remove RSS feeds não utilizados (opcional - descomente se necessário)
 */
// remove_action( 'wp_head', 'feed_links', 2 );
// remove_action( 'wp_head', 'feed_links_extra', 3 );

/**
 * Limpa o head do WordPress
 */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

/**
 * Desativa XML-RPC (segurança - opcional)
 */
// add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Adiciona loading lazy nativo em imagens
 */
function iron_task_lazy_images( $attr, $attachment, $size ) {
	$attr['loading'] = 'lazy';
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'iron_task_lazy_images', 10, 3 );

/**
 * Adiciona dimensões explícitas em imagens para evitar CLS
 */
function iron_task_responsive_images( $sizes, $size ) {
	$sizes[] = '(max-width: 480px) 100vw, (max-width: 768px) 50vw, (max-width: 1024px) 33vw, 25vw';
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'iron_task_responsive_images', 10, 2 );

/**
 * Registra meta boxes customizadas
 */
function iron_task_register_meta() {
	register_post_meta(
		'product',
		'_iron_task_featured',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'boolean',
		)
	);
}
add_action( 'init', 'iron_task_register_meta' );

/**
 * Adiciona menu de contexto no admin para produtos
 */
function iron_task_product_row_actions( $actions, $post ) {
	if ( 'product' === $post->post_type ) {
		unset( $actions['inline hide-if-no-js'] );
	}
	return $actions;
}
add_filter( 'post_row_actions', 'iron_task_product_row_actions', 10, 2 );

/**
 * Customiza o excerpt length
 */
function iron_task_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'iron_task_excerpt_length' );

/**
 * Customiza o excerpt more
 */
function iron_task_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'iron_task_excerpt_more' );

/**
 * Adiciona timeout de sessão mais longo para WooCommerce
 */
function iron_task_woocommerce_session_duration() {
	return DAY_IN_SECONDS * 7; // 7 dias
}
add_filter( 'wc_session_duration', 'iron_task_woocommerce_session_duration' );

/**
 * Altera número de produtos por página
 */
function iron_task_products_per_page( $columns ) {
	return 12;
}
add_filter( 'loop_shop_per_page', 'iron_task_products_per_page' );

/**
 * Ordenação padrão dos produtos
 */
function iron_task_default_sorting( $default_orderby ) {
	return 'date'; // Mais recentes primeiro
}
add_filter( 'woocommerce_default_catalog_orderby', 'iron_task_default_sorting' );

/**
 * Adiciona wrapper customizado em torno do conteúdo WooCommerce
 */
function iron_task_woocommerce_wrapper_before() {
	?>
	<main id="primary" class="site-main woocommerce-page" role="main">
	<div class="container">
	<?php
}
add_action( 'woocommerce_before_main_content', 'iron_task_woocommerce_wrapper_before', 10 );

function iron_task_woocommerce_wrapper_after() {
	?>
	</div>
	</main>
	<?php
}
add_action( 'woocommerce_after_main_content', 'iron_task_woocommerce_wrapper_after', 10 );

/**
 * Remove sidebar padrão do WooCommerce
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Altera thumbnail do catálogo
 */
function iron_task_product_thumbnail_dimensions() {
	return array(
		'width'  => 600,
		'height' => 800,
		'crop'   => true,
	);
}
add_filter( 'woocommerce_get_image_size_thumbnail', 'iron_task_product_thumbnail_dimensions' );

/**
 * Altera imagem single product
 */
function iron_task_single_product_image_dimensions() {
	return array(
		'width'  => 800,
		'height' => 1067,
		'crop'   => false,
	);
}
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'iron_task_single_product_image_dimensions' );

/**
 * Adiciona suporte a WebP
 */
function iron_task_mime_types( $mimes ) {
	$mimes['webp'] = 'image/webp';
	return $mimes;
}
add_filter( 'upload_mimes', 'iron_task_mime_types' );

/**
 * Habilita WebP para upload
 */
function iron_task_webp_upload_mimes( $existing_mimes ) {
	$existing_mimes['webp'] = 'image/webp';
	return $existing_mimes;
}
add_filter( 'mime_sniffing_categories', 'iron_task_webp_upload_mimes' );

/**
 * Otimiza Google Fonts (se usado)
 */
function iron_task_google_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap';
}

/**
 * Pre-fetch de páginas importantes
 */
function iron_task_prefetch_links() {
	?>
	<link rel="prefetch" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
	<?php
}
add_action( 'wp_head', 'iron_task_prefetch_links', 20 );

/**
 * Adiciona structured data para produtos
 */
function iron_task_product_schema() {
	if ( ! is_product() ) {
		return;
	}
	
	global $product;
	
	if ( ! $product instanceof WC_Product ) {
		return;
	}
	
	$schema = array(
		'@context'        => 'https://schema.org/',
		'@type'           => 'Product',
		'name'            => $product->get_name(),
		'image'           => wp_get_attachment_url( $product->get_image_id() ),
		'description'     => $product->get_short_description(),
		'sku'             => $product->get_sku(),
		'brand'           => array(
			'@type' => 'Brand',
			'name'  => 'Iron Task',
		),
		'offers'          => array(
			'@type'         => 'Offer',
			'url'           => get_permalink(),
			'priceCurrency' => 'BRL',
			'price'         => $product->get_price(),
			'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
		),
	);
	
	?>
	<script type="application/ld+json">
		<?php echo wp_json_encode( $schema ); ?>
	</script>
	<?php
}
add_action( 'wp_footer', 'iron_task_product_schema' );

/**
 * Adiciona Breadcrumbs customizados
 */
function iron_task_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav class="breadcrumbs" aria-label="Breadcrumb">','</nav>' );
		return;
	}
	
	// Fallback breadcrumbs nativos do WooCommerce
	if ( is_product() ) {
		woocommerce_breadcrumb( array(
			'wrap_before' => '<nav class="breadcrumbs" aria-label="Breadcrumb">',
			'wrap_after'  => '</nav>',
		) );
	}
}

/**
 * Customiza mensagem de "Produto adicionado ao carrinho"
 */
function iron_task_added_to_cart_message( $message, $product_id ) {
	$product = wc_get_product( $product_id );
	
	if ( ! $product ) {
		return $message;
	}
	
	return sprintf(
		/* translators: %s: product name */
		__( '"%s" foi adicionado ao seu carrinho!', 'iron-task' ),
		$product->get_name()
	);
}
add_filter( 'wc_add_to_cart_message', 'iron_task_added_to_cart_message', 10, 2 );
add_filter( 'wc_add_to_cart_message_html', '__return_false' );

/**
 * Adiciona botão de voltar no topo
 */
function iron_task_back_to_top() {
	?>
	<button class="back-to-top" id="backToTop" aria-label="Voltar ao topo" style="display:none;">
		<svg viewBox="0 0 24 24" width="24" height="24">
			<path d="M12 19V5M5 12l7-7 7 7" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</button>
	<?php
}
add_action( 'wp_footer', 'iron_task_back_to_top' );

/**
 * Adiciona script inline para back-to-top
 */
function iron_task_back_to_top_script() {
	?>
	<script>
		(function() {
			const btn = document.getElementById('backToTop');
			if (!btn) return;
			
			window.addEventListener('scroll', function() {
				if (window.pageYOffset > 300) {
					btn.style.display = 'flex';
				} else {
					btn.style.display = 'none';
				}
			});
			
			btn.addEventListener('click', function() {
				window.scrollTo({ top: 0, behavior: 'smooth' });
			});
		})();
	</script>
	<style>
		.back-to-top {
			position: fixed;
			bottom: 2rem;
			right: 2rem;
			width: 50px;
			height: 50px;
			background: var(--accent-primary);
			color: var(--bg-primary);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			z-index: 1000;
			transition: all 0.3s ease;
			box-shadow: var(--shadow-md);
		}
		.back-to-top:hover {
			background: var(--accent-secondary);
			transform: translateY(-4px);
		}
	</style>
	<?php
}
add_action( 'wp_footer', 'iron_task_back_to_top_script', 100 );
