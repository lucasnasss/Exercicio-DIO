<?php
/**
 * Iron Task Template Tags Class
 *
 * Funções de template customizadas
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe de template tags
 */
class Iron_Task_Template_Tags {

	/**
	 * Construtor
	 */
	public function __construct() {
		// Nada específico no construtor por enquanto
	}

	/**
	 * Exibe o header/navbar
	 */
	public static function header() {
		get_template_part( 'template-parts/header/navbar' );
	}

	/**
	 * Exibe o footer
	 */
	public static function footer() {
		get_template_part( 'template-parts/footer/site' );
	}

	/**
	 * Exibe o menu mobile
	 */
	public static function mobile_menu() {
		get_template_part( 'template-parts/header/mobile-menu' );
	}

	/**
	 * Exibe o mega menu
	 */
	public static function mega_menu() {
		get_template_part( 'template-parts/header/mega-menu' );
	}

	/**
	 * Exibe o loader
	 */
	public static function loader() {
		get_template_part( 'template-parts/global/loader' );
	}

	/**
	 * Exibe toast notifications
	 */
	public static function toast_container() {
		get_template_part( 'template-parts/global/toast' );
	}

	/**
	 * Exibe breadcrumbs
	 *
	 * @param array $args Argumentos dos breadcrumbs
	 */
	public static function breadcrumbs( $args = array() ) {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<nav class="breadcrumbs" aria-label="Breadcrumb">', '</nav>' );
			return;
		}

		if ( class_exists( 'WooCommerce' ) && is_product() ) {
			$default_args = array(
				'wrap_before' => '<nav class="breadcrumbs" aria-label="Breadcrumb">',
				'wrap_after'  => '</nav>',
			);
			$args         = wp_parse_args( $args, $default_args );
			woocommerce_breadcrumb( $args );
		}
	}

	/**
	 * Exibe card de produto
	 *
	 * @param int|WP_Post $product_id ID do produto ou post object
	 */
	public static function product_card( $product_id = null ) {
		if ( ! $product_id ) {
			$product_id = get_the_ID();
		}

		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			return;
		}

		get_template_part(
			'template-parts/product/card',
			'',
			array(
				'product' => $product,
			)
		);
	}

	/**
	 * Verifica se tem produtos em destaque
	 *
	 * @return bool
	 */
	public static function has_featured_products() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return false;
		}

		$featured = wc_get_products(
			array(
				'limit'    => 1,
				'featured' => true,
				'status'   => 'publish',
			)
		);

		return ! empty( $featured );
	}

	/**
	 * Retorna produtos em destaque
	 *
	 * @param int $limit Número de produtos
	 * @return array
	 */
	public static function get_featured_products( $limit = 4 ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return array();
		}

		return wc_get_products(
			array(
				'limit'    => $limit,
				'featured' => true,
				'status'   => 'publish',
			)
		);
	}

	/**
	 * Retorna produtos recentes
	 *
	 * @param int $limit Número de produtos
	 * @return array
	 */
	public static function get_recent_products( $limit = 4 ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return array();
		}

		return wc_get_products(
			array(
				'limit' => $limit,
				'order' => 'DESC',
				'status' => 'publish',
			)
		);
	}

	/**
	 * Retorna produtos em promoção
	 *
	 * @param int $limit Número de produtos
	 * @return array
	 */
	public static function get_sale_products( $limit = 4 ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return array();
		}

		return wc_get_products(
			array(
				'limit'     => $limit,
				'on_sale'   => true,
				'status'    => 'publish',
			)
		);
	}

	/**
	 * Exibe grid de produtos
	 *
	 * @param WP_Query $query Query dos produtos
	 */
	public static function products_grid( $query ) {
		if ( ! $query->have_posts() ) {
			return;
		}

		echo '<div class="products-grid">';

		while ( $query->have_posts() ) {
			$query->the_post();
			self::product_card();
		}

		echo '</div>';

		wp_reset_postdata();
	}

	/**
	 * Exibe seção de hero
	 *
	 * @param array $args Argumentos do hero
	 */
	public static function hero_section( $args = array() ) {
		$defaults = array(
			'title'       => '',
			'subtitle'    => '',
			'description' => '',
			'button_text' => '',
			'button_url'  => '',
			'image'       => '',
			'class'       => '',
		);

		$args = wp_parse_args( $args, $defaults );

		get_template_part( 'template-parts/sections/hero', '', $args );
	}

	/**
	 * Exibe seção de features
	 *
	 * @param array $features Lista de features
	 */
	public static function features_section( $features = array() ) {
		get_template_part( 'template-parts/sections/features', '', array( 'features' => $features ) );
	}

	/**
	 * Exibe seção de testimonials
	 *
	 * @param array $testimonials Lista de testimonials
	 */
	public static function testimonials_section( $testimonials = array() ) {
		get_template_part( 'template-parts/sections/testimonials', '', array( 'testimonials' => $testimonials ) );
	}

	/**
	 * Exibe call-to-action
	 *
	 * @param array $args Argumentos do CTA
	 */
	public static function cta_section( $args = array() ) {
		$defaults = array(
			'title'       => '',
			'description' => '',
			'button_text' => '',
			'button_url'  => '',
			'class'       => '',
		);

		$args = wp_parse_args( $args, $defaults );

		get_template_part( 'template-parts/sections/cta', '', $args );
	}

	/**
	 * Formata preço
	 *
	 * @param float $price Preço
	 * @return string
	 */
	public static function format_price( $price ) {
		return 'R$ ' . number_format( (float) $price, 2, ',', '.' );
	}

	/**
	 * Retorna badge do produto
	 *
	 * @param WC_Product $product Produto WooCommerce
	 * @return string
	 */
	public static function get_product_badge( $product ) {
		if ( ! $product instanceof WC_Product ) {
			return '';
		}

		$badge = '';

		if ( $product->is_on_sale() ) {
			$badge = __( 'Oferta', 'iron-task' );
		} elseif ( $product->is_featured() ) {
			$badge = __( 'Destaque', 'iron-task' );
		} else {
			// Verifica se é novo (menos de 30 dias)
			$created = strtotime( $product->get_date_created() );
			if ( time() - $created < MONTH_IN_SECONDS ) {
				$badge = __( 'Novo', 'iron-task' );
			}
		}

		return $badge;
	}

	/**
	 * Exibe badge do produto
	 *
	 * @param WC_Product $product Produto WooCommerce
	 */
	public static function the_product_badge( $product ) {
		$badge = self::get_product_badge( $product );

		if ( ! empty( $badge ) ) {
			echo '<span class="product-card__badge">' . esc_html( $badge ) . '</span>';
		}
	}

	/**
	 * Retorna classes para o body
	 *
	 * @return string
	 */
	public static function body_classes() {
		$classes = array();

		if ( is_front_page() ) {
			$classes[] = 'front-page';
		}

		if ( is_home() ) {
			$classes[] = 'blog';
		}

		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_shop() ) {
				$classes[] = 'shop-page';
			}

			if ( is_product() ) {
				$classes[] = 'product-page';
			}

			if ( is_cart() ) {
				$classes[] = 'cart-page';
			}

			if ( is_checkout() ) {
				$classes[] = 'checkout-page';
			}

			if ( is_account_page() ) {
				$classes[] = 'account-page';
			}
		}

		return implode( ' ', $classes );
	}

	/**
	 * Exibe ícone de busca
	 */
	public static function search_icon() {
		?>
		<svg viewBox="0 0 24 24" width="20" height="20">
			<circle cx="10.5" cy="10.5" r="6.5" stroke="currentColor" stroke-width="1.8" fill="none"/>
			<path d="M15.5 15.5L21 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
		</svg>
		<?php
	}

	/**
	 * Exibe ícone de carrinho
	 */
	public static function cart_icon() {
		?>
		<svg viewBox="0 0 24 24" width="20" height="20">
			<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M16 10a4 4 0 01-8 0" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round"/>
		</svg>
		<?php
	}

	/**
	 * Exibe ícone de tema (sol/lua)
	 */
	public static function theme_icon() {
		?>
		<svg class="navbar__icon-sun" viewBox="0 0 24 24" width="20" height="20">
			<circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.8" fill="none"/>
			<path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
		</svg>
		<svg class="navbar__icon-moon" viewBox="0 0 24 24" width="20" height="20">
			<path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
		<?php
	}

	/**
	 * Exibe ícone de menu hambúrguer
	 */
	public static function hamburger_icon() {
		?>
		<span class="navbar__hamburger-line"></span>
		<span class="navbar__hamburger-line"></span>
		<span class="navbar__hamburger-line"></span>
		<?php
	}

	/**
	 * Exibe ícone de fechar
	 */
	public static function close_icon() {
		?>
		<svg viewBox="0 0 24 24" width="24" height="24">
			<path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
		</svg>
		<?php
	}

	/**
	 * Exibe ícones sociais
	 *
	 * @param string $platform Plataforma (instagram, twitter, tiktok)
	 */
	public static function social_icon( $platform = 'instagram' ) {
		switch ( $platform ) {
			case 'instagram':
				?>
				<svg viewBox="0 0 24 24" width="20" height="20">
					<rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
					<circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
					<circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/>
				</svg>
				<?php
				break;

			case 'twitter':
				?>
				<svg viewBox="0 0 24 24" width="20" height="20">
					<path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/>
				</svg>
				<?php
				break;

			case 'tiktok':
				?>
				<svg viewBox="0 0 24 24" width="20" height="20">
					<path d="M9 12a4 4 0 101 8a4 4 0 001-8M15 8v8a4 4 0 01-4 4M15 8V2h4l-2 6h2l-4 7V8h-1" stroke="currentColor" stroke-width="1.5" fill="none"/>
				</svg>
				<?php
				break;
		}
	}
}
