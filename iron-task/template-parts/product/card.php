<?php
/**
 * Template part: Product Card
 *
 * Exibe card de produto WooCommerce
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

// Garante que temos um produto válido
if ( ! $product instanceof WC_Product ) {
	$product = wc_get_product( get_the_ID() );
}

if ( ! $product ) {
	return;
}
?>

<article <?php post_class( 'product-card' ); ?>>
	<?php
	// Badge do produto
	$badge = '';
	
	if ( $product->is_on_sale() ) {
		$badge = __( 'Oferta', 'iron-task' );
	} elseif ( $product->is_featured() ) {
		$badge = __( 'Destaque', 'iron-task' );
	} else {
		// Verifica se é novo (menos de 30 dias)
		$created = strtotime( $product->get_date_created() );
		if ( $created && time() - $created < MONTH_IN_SECONDS ) {
			$badge = __( 'Novo', 'iron-task' );
		}
	}
	
	if ( $badge ) :
	?>
	<span class="product-card__badge"><?php echo esc_html( $badge ); ?></span>
	<?php endif; ?>
	
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="product-card__image-link">
		<div class="product-card__image">
			<?php
			if ( $product->get_image_id() ) {
				echo $product->get_image( 'iron-task-product-thumb', array(
					'loading' => 'lazy',
					'class'   => 'attachment-woocommerce_thumbnail',
				) );
			} else {
				// Placeholder quando não há imagem
				echo '<span>' . esc_html( $product->get_name() ) . '</span>';
			}
			?>
		</div>
	</a>
	
	<div class="product-card__info">
		<h3 class="product-card__name">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo esc_html( $product->get_name() ); ?>
			</a>
		</h3>
		
		<div class="product-card__price">
			<?php echo $product->get_price_html(); ?>
		</div>
		
		<?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
		<button class="product-card__add-to-cart btn btn--primary" 
		        data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
		        aria-label="<?php printf( __( 'Adicionar "%s" ao carrinho', 'iron-task' ), $product->get_name() ); ?>">
			<?php _e( 'ADICIONAR', 'iron-task' ); ?>
		</button>
		<?php elseif ( ! $product->is_in_stock() ) : ?>
		<span class="product-card__out-of-stock"><?php _e( 'ESGOTADO', 'iron-task' ); ?></span>
		<?php endif; ?>
	</div>
</article>
