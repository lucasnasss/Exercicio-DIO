<?php
/**
 * Iron Task Widgets Class
 *
 * Registro de widgets customizados
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe de registro de widgets
 */
class Iron_Task_Widgets {

	/**
	 * Construtor
	 */
	public function __construct() {
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}

	/**
	 * Registra widgets customizados
	 */
	public function register_widgets() {
		register_widget( 'Iron_Task_Products_Widget' );
		register_widget( 'Iron_Task_Social_Widget' );
		register_widget( 'Iron_Task_Newsletter_Widget' );
		register_widget( 'Iron_Task_Categories_Widget' );
	}
}

/**
 * Widget de Produtos em Destaque
 */
class Iron_Task_Products_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'iron_task_products',
			__( 'Iron Task - Produtos', 'iron-task' ),
			array(
				'description' => __( 'Exibe produtos da loja WooCommerce.', 'iron-task' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Produtos', 'iron-task' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 4;
		$type  = ! empty( $instance['type'] ) ? $instance['type'] : 'recent';

		echo $args['before_widget'];
		
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		$query_args = array(
			'post_type'      => 'product',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
		);

		switch ( $type ) {
			case 'featured':
				$query_args['meta_query'] = array(
					array(
						'key'     => '_featured',
						'value'   => 'yes',
						'compare' => '=',
					),
				);
				break;
			case 'sale':
				$query_args['meta_query'] = array(
					'relation' => 'AND',
					array(
						'key'     => '_sale_price',
						'value'   => 0,
						'compare' => '>',
						'type'    => 'NUMERIC',
					),
				);
				break;
			case 'top_rated':
				$query_args['orderby'] = 'meta_value_num';
				$query_args['meta_key'] = '_wc_average_rating';
				break;
			default:
				$query_args['orderby'] = 'date';
				$query_args['order']   = 'DESC';
		}

		$products = new WP_Query( $query_args );

		if ( $products->have_posts() ) {
			echo '<ul class="product-list">';
			
			while ( $products->have_posts() ) {
				$products->the_post();
				
				global $product;
				
				echo '<li class="product-item">';
				echo '<a href="' . get_permalink() . '" class="product-link">';
				
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'thumbnail', array( 'class' => 'product-thumb' ) );
				} else {
					echo '<div class="product-thumb-placeholder">' . get_the_title() . '</div>';
				}
				
				echo '<span class="product-name">' . get_the_title() . '</span>';
				
				if ( $product ) {
					echo '<span class="product-price">' . $product->get_price_html() . '</span>';
				}
				
				echo '</a>';
				echo '</li>';
			}
			
			echo '</ul>';
		}

		wp_reset_postdata();
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 4;
		$type  = ! empty( $instance['type'] ) ? $instance['type'] : 'recent';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php _e( 'Título:', 'iron-task' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php _e( 'Número de produtos:', 'iron-task' ); ?>
			</label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number"
			       value="<?php echo esc_attr( $count ); ?>" min="1" max="10">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>">
				<?php _e( 'Tipo:', 'iron-task' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
				<option value="recent" <?php selected( $type, 'recent' ); ?>><?php _e( 'Recentes', 'iron-task' ); ?></option>
				<option value="featured" <?php selected( $type, 'featured' ); ?>><?php _e( 'Destaques', 'iron-task' ); ?></option>
				<option value="sale" <?php selected( $type, 'sale' ); ?>><?php _e( 'Em Promoção', 'iron-task' ); ?></option>
				<option value="top_rated" <?php selected( $type, 'top_rated' ); ?>><?php _e( 'Mais Avaliados', 'iron-task' ); ?></option>
			</select>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = absint( $new_instance['count'] );
		$instance['type']  = sanitize_text_field( $new_instance['type'] );
		return $instance;
	}
}

/**
 * Widget de Redes Sociais
 */
class Iron_Task_Social_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'iron_task_social',
			__( 'Iron Task - Redes Sociais', 'iron-task' ),
			array(
				'description' => __( 'Exibe ícones de redes sociais.', 'iron-task' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Siga-nos', 'iron-task' );

		echo $args['before_widget'];
		
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}
		?>
		<div class="social-links">
			<?php if ( ! empty( $instance['instagram'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['instagram'] ); ?>" target="_blank" rel="noopener" aria-label="Instagram">
					<svg viewBox="0 0 24 24" width="20" height="20">
						<rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
						<circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
						<circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/>
					</svg>
				</a>
			<?php endif; ?>
			
			<?php if ( ! empty( $instance['twitter'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['twitter'] ); ?>" target="_blank" rel="noopener" aria-label="Twitter">
					<svg viewBox="0 0 24 24" width="20" height="20">
						<path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/>
					</svg>
				</a>
			<?php endif; ?>
			
			<?php if ( ! empty( $instance['tiktok'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['tiktok'] ); ?>" target="_blank" rel="noopener" aria-label="TikTok">
					<svg viewBox="0 0 24 24" width="20" height="20">
						<path d="M9 12a4 4 0 101 8a4 4 0 001-8M15 8v8a4 4 0 01-4 4M15 8V2h4l-2 6h2l-4 7V8h-1" stroke="currentColor" stroke-width="1.5" fill="none"/>
					</svg>
				</a>
			<?php endif; ?>
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title     = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$instagram = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
		$twitter   = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
		$tiktok    = ! empty( $instance['tiktok'] ) ? $instance['tiktok'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php _e( 'Título:', 'iron-task' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>">
				<?php _e( 'Instagram URL:', 'iron-task' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="url"
			       value="<?php echo esc_url( $instagram ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>">
				<?php _e( 'Twitter URL:', 'iron-task' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="url"
			       value="<?php echo esc_url( $twitter ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tiktok' ) ); ?>">
				<?php _e( 'TikTok URL:', 'iron-task' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tiktok' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'tiktok' ) ); ?>" type="url"
			       value="<?php echo esc_url( $tiktok ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance            = array();
		$instance['title']   = sanitize_text_field( $new_instance['title'] );
		$instance['instagram'] = esc_url_raw( $new_instance['instagram'] );
		$instance['twitter']   = esc_url_raw( $new_instance['twitter'] );
		$instance['tiktok']    = esc_url_raw( $new_instance['tiktok'] );
		return $instance;
	}
}

/**
 * Widget de Newsletter
 */
class Iron_Task_Newsletter_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'iron_task_newsletter',
			__( 'Iron Task - Newsletter', 'iron-task' ),
			array(
				'description' => __( 'Formulário de inscrição para newsletter.', 'iron-task' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Newsletter', 'iron-task' );
		$description = ! empty( $instance['description'] ) ? $instance['description'] : __( 'Receba novidades e ofertas exclusivas.', 'iron-task' );

		echo $args['before_widget'];
		
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}
		
		if ( ! empty( $description ) ) {
			echo '<p class="newsletter-desc">' . esc_html( $description ) . '</p>';
		}
		?>
		<form class="footer__newsletter" method="post" action="">
			<input type="email" name="newsletter_email" placeholder="<?php esc_attr_e( 'Seu melhor e-mail', 'iron-task' ); ?>" class="footer__input" required>
			<button type="submit" class="footer__submit"><?php _e( 'INSCREVER', 'iron-task' ); ?></button>
		</form>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$description = ! empty( $instance['description'] ) ? $instance['description'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php _e( 'Título:', 'iron-task' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">
				<?php _e( 'Descrição:', 'iron-task' ); ?>
			</label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"
			          name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" rows="3"><?php echo esc_textarea( $description ); ?></textarea>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance            = array();
		$instance['title']   = sanitize_text_field( $new_instance['title'] );
		$instance['description'] = sanitize_textarea_field( $new_instance['description'] );
		return $instance;
	}
}

/**
 * Widget de Categorias de Produtos
 */
class Iron_Task_Categories_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'iron_task_categories',
			__( 'Iron Task - Categorias', 'iron-task' ),
			array(
				'description' => __( 'Exibe categorias de produtos WooCommerce.', 'iron-task' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Categorias', 'iron-task' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 0;

		echo $args['before_widget'];
		
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		$categories = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
				'number'     => $count > 0 ? $count : '',
			)
		);

		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			echo '<ul class="category-list">';
			
			foreach ( $categories as $category ) {
				echo '<li><a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a></li>';
			}
			
			echo '</ul>';
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 0;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php _e( 'Título:', 'iron-task' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php _e( 'Número de categorias (0 = todas):', 'iron-task' ); ?>
			</label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number"
			       value="<?php echo esc_attr( $count ); ?>" min="0">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = absint( $new_instance['count'] );
		return $instance;
	}
}
