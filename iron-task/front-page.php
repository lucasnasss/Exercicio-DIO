<?php
/**
 * Front page template
 *
 * Template para a página inicial do site
 *
 * @package Iron_Task
 * @since 1.0.0
 */

get_header();
?>

<div class="app-view">
    <!-- Hero Section -->
    <section class="hero section" id="hero">
        <div class="container">
            <div class="hero__content">
                <h1 class="hero__title section__heading">
                    <?php _e( 'FORJADO NO FOGO', 'iron-task' ); ?>
                </h1>
                <p class="hero__subtitle">
                    <?php _e( 'Vestido com propósito', 'iron-task' ); ?>
                </p>
                <p class="hero__description">
                    <?php _e( 'Moda esportiva e streetwear de alto nível para quem busca excelência em cada detalhe.', 'iron-task' ); ?>
                </p>
                <div class="hero__actions">
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--primary">
                        <?php _e( 'VER COLEÇÃO', 'iron-task' ); ?>
                    </a>
                    <a href="#featured" class="btn btn--secondary">
                        <?php _e( 'SAIBA MAIS', 'iron-task' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Produtos em Destaque -->
    <section class="section section--dark" id="featured">
        <div class="container">
            <h2 class="section__heading"><?php _e( 'EM DESTAQUE', 'iron-task' ); ?></h2>
            <p class="section__description"><?php _e( 'Peças selecionadas para quem exige o melhor.', 'iron-task' ); ?></p>
            
            <?php
            if ( class_exists( 'WooCommerce' ) ) {
                $featured_products = wc_get_products( array(
                    'limit'    => 8,
                    'featured' => true,
                    'status'   => 'publish',
                ) );

                if ( ! empty( $featured_products ) ) {
                    echo '<div class="products-grid">';
                    
                    foreach ( $featured_products as $product ) {
                        wc_get_template_part( 'content', 'product' );
                    }
                    
                    echo '</div>';
                    
                    echo '<div class="section__cta">';
                    echo '<a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="btn btn--secondary">';
                    _e( 'VER TODOS OS PRODUTOS', 'iron-task' );
                    echo '</a>';
                    echo '</div>';
                } else {
                    // Fallback: produtos recentes se não houver destaques
                    $recent_products = wc_get_products( array(
                        'limit' => 8,
                        'order' => 'DESC',
                        'status' => 'publish',
                    ) );

                    if ( ! empty( $recent_products ) ) {
                        echo '<div class="products-grid">';
                        
                        foreach ( $recent_products as $product ) {
                            wc_get_template_part( 'content', 'product' );
                        }
                        
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>
    </section>

    <!-- Categorias -->
    <section class="section" id="categories">
        <div class="container">
            <h2 class="section__heading"><?php _e( 'CATEGORIAS', 'iron-task' ); ?></h2>
            
            <?php
            $product_categories = get_terms( array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'number'     => 4,
            ) );

            if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) :
            ?>
            <div class="categories-grid">
                <?php foreach ( $product_categories as $category ) : ?>
                <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category-card">
                    <span class="category-card__name"><?php echo esc_html( $category->name ); ?></span>
                    <span class="category-card__count"><?php echo sprintf( _n( '%d produto', '%d produtos', $category->count, 'iron-task' ), $category->count ); ?></span>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Sobre / Features -->
    <section class="section section--dark" id="features">
        <div class="container">
            <h2 class="section__heading"><?php _e( 'POR QUE IRON TASK?', 'iron-task' ); ?></h2>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-card__icon">🚚</div>
                    <h3 class="feature-card__title"><?php _e( 'ENTREGA RÁPIDA', 'iron-task' ); ?></h3>
                    <p class="feature-card__text"><?php _e( 'Receba seu pedido em até 7 dias úteis em todo o Brasil.', 'iron-task' ); ?></p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-card__icon">🔄</div>
                    <h3 class="feature-card__title"><?php _e( 'TROCA FÁCIL', 'iron-task' ); ?></h3>
                    <p class="feature-card__text"><?php _e( 'Primeira troca grátis em até 30 dias após o recebimento.', 'iron-task' ); ?></p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-card__icon">⭐</div>
                    <h3 class="feature-card__title"><?php _e( 'QUALIDADE PREMIUM', 'iron-task' ); ?></h3>
                    <p class="feature-card__text"><?php _e( 'Tecidos de alta performance que resistem ao treino mais pesado.', 'iron-task' ); ?></p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-card__icon">🔒</div>
                    <h3 class="feature-card__title"><?php _e( 'COMPRA SEGURA', 'iron-task' ); ?></h3>
                    <p class="feature-card__text"><?php _e( 'Seus dados protegidos com criptografia de ponta a ponta.', 'iron-task' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section" id="testimonials">
        <div class="container">
            <h2 class="section__heading"><?php _e( 'QUEM VESTE', 'iron-task' ); ?></h2>
            
            <div class="testimonials-slider">
                <div class="testimonial-card">
                    <p class="testimonial-card__text">"A qualidade é absurda. Treino pesado há 3 anos e as camisetas estão intactas."</p>
                    <p class="testimonial-card__author">— Lucas M., São Paulo</p>
                </div>
                
                <div class="testimonial-card">
                    <p class="testimonial-card__text">"Finalmente roupas que aguentam o tranco. O estilo é um bônus."</p>
                    <p class="testimonial-card__author">— Rafaela S., Rio de Janeiro</p>
                </div>
                
                <div class="testimonial-card">
                    <p class="testimonial-card__text">"A jaqueta Aço virou meu uniforme diário. Leve, resistente e estilosa."</p>
                    <p class="testimonial-card__author">— Thiago P., Belo Horizonte</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="section section--dark cta-section" id="cta">
        <div class="container">
            <h2 class="cta-section__title section__heading"><?php _e( 'PRONTO PARA O PRÓXIMO NÍVEL?', 'iron-task' ); ?></h2>
            <p class="cta-section__text"><?php _e( 'Junte-se à elite. Vista Iron Task.', 'iron-task' ); ?></p>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--primary">
                <?php _e( 'COMPRAR AGORA', 'iron-task' ); ?>
            </a>
        </div>
    </section>
</div>

<?php
get_footer();
