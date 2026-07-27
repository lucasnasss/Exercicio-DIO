<?php
/**
 * Iron Task WooCommerce Class
 *
 * Integração e customizações do WooCommerce
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe de integração WooCommerce
 */
class Iron_Task_WooCommerce {

	/**
	 * Construtor
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'woocommerce_support' ), 11 );
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'disable_default_styles' ) );
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_count_fragments' ) );
		add_filter( 'loop_shop_columns', array( $this, 'shop_columns' ) );
		add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'thumbnail_columns' ) );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'product_gallery_wrapper' ), 5 );
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'product_gallery_close' ), 25 );
		add_filter( 'woocommerce_product_image_size', array( $this, 'single_product_image_size' ) );
		add_filter( 'woocommerce_get_image_size_thumbnail', array( $this, 'catalog_image_size' ) );
		add_filter( 'single_product_archive_thumbnail_size', array( $this, 'archive_thumbnail_size' ) );
	}

	/**
	 * Declara suporte ao WooCommerce
	 */
	public function woocommerce_support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Desabilita estilos padrão do WooCommerce
	 *
	 * @param array $enqueue_styles Estilos a serem carregados
	 * @return array
	 */
	public function disable_default_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );
		unset( $enqueue_styles['woocommerce-layout'] );
		unset( $enqueue_styles['woocommerce-smallscreen'] );
		return $enqueue_styles;
	}

	/**
	 * Atualiza fragmentos do carrinho via AJAX
	 *
	 * @param array $fragments Fragmentos do carrinho
	 * @return array
	 */
	public function cart_count_fragments( $fragments ) {
		ob_start();
		?>
		<span class="navbar__cart-count" id="cart-count" aria-live="polite">
			<?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?>
		</span>
		<?php
		$fragments['#cart-count'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Número de colunas na loja
	 *
	 * @return int
	 */
	public function shop_columns() {
		return 4;
	}

	/**
	 * Colunas de thumbnails
	 *
	 * @return int
	 */
	public function thumbnail_columns() {
		return 4;
	}

	/**
	 * Wrapper da galeria do produto
	 */
	public function product_gallery_wrapper() {
		echo '<div class="product-image">';
	}

	/**
	 * Fecha wrapper da galeria
	 */
	public function product_gallery_close() {
		echo '</div>';
	}

	/**
	 * Tamanho da imagem single product
	 *
	 * @return array
	 */
	public function single_product_image_size() {
		return 'iron-task-product-large';
	}

	/**
	 * Tamanho da imagem do catálogo
	 *
	 * @return array
	 */
	public function catalog_image_size() {
		return array(
			'width'  => 600,
			'height' => 800,
			'crop'   => true,
		);
	}

	/**
	 * Tamanho do thumbnail no archive
	 *
	 * @return string
	 */
	public function archive_thumbnail_size() {
		return 'iron-task-product-thumb';
	}

	/**
	 * Wrapper antes do conteúdo WooCommerce
	 */
	public static function wrapper_before() {
		?>
		<main id="primary" class="site-main woocommerce-page" role="main">
		<div class="container">
		<?php
	}

	/**
	 * Wrapper depois do conteúdo WooCommerce
	 */
	public static function wrapper_after() {
		?>
		</div>
		</main>
		<?php
	}

	/**
	 * Exibe mini cart no header
	 */
	public static function mini_cart() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}
		?>
		<div class="mini-cart" id="mini-cart" aria-hidden="true">
			<div class="mini-cart__container">
				<?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
					<ul class="mini-cart__items">
						<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>
							<?php
							$product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $product && $product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
								?>
								<li class="mini-cart__item">
									<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="mini-cart__product-link">
										<?php echo $product->get_image( 'thumbnail' ); ?>
										<div class="mini-cart__product-info">
											<span class="mini-cart__product-name"><?php echo esc_html( $product->get_name() ); ?></span>
											<span class="mini-cart__product-quantity"><?php echo esc_html( $cart_item['quantity'] ); ?>x</span>
											<span class="mini-cart__product-price"><?php echo WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] ); ?></span>
										</div>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<div class="mini-cart__footer">
						<div class="mini-cart__subtotal">
							<span><?php _e( 'Subtotal:', 'iron-task' ); ?></span>
							<span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
						</div>
						<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn btn--primary mini-cart__view-cart">
							<?php _e( 'Ver Carrinho', 'iron-task' ); ?>
						</a>
						<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn--secondary mini-cart__checkout">
							<?php _e( 'Finalizar', 'iron-task' ); ?>
						</a>
					</div>
				<?php else : ?>
					<p class="mini-cart__empty"><?php _e( 'Seu carrinho está vazio.', 'iron-task' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Produto relacionado customizado
	 *
	 * @param array $args Argumentos dos relacionados
	 * @return array
	 */
	public function related_products_args( $args ) {
		$args['posts_per_page'] = 4;
		$args['columns']        = 4;
		return $args;
	}

	/**
	 * Upsells products customizado
	 *
	 * @param array $args Argumentos dos upsells
	 * @return array
	 */
	public function upsells_products_args( $args ) {
		$args['posts_per_page'] = 4;
		$args['columns']        = 4;
		return $args;
	}
}
