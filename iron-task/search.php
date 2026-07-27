<?php
/**
 * Search results template
 *
 * Template para resultados de busca
 *
 * @package Iron_Task
 * @since 1.0.0
 */

get_header();
?>

<div class="app-view">
    <div class="container">
        <header class="search-results-header">
            <h1><?php _e( 'RESULTADOS DA BUSCA', 'iron-task' ); ?></h1>
            <p class="search-query">
                <?php printf( __( 'Buscando por: "%s"', 'iron-task' ), get_search_query() ); ?>
            </p>
        </header>
        
        <div class="search-results-content">
            <?php
            if ( have_posts() ) :
                ?>
                <p class="woocommerce-result-count">
                    <?php
                    global $wp_query;
                    printf(
                        /* translators: %d: número de resultados */
                        _n( '%d resultado encontrado', '%d resultados encontrados', $wp_query->found_posts, 'iron-task' ),
                        $wp_query->found_posts
                    );
                    ?>
                </p>
                
                <div class="products-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        
                        // Se for produto WooCommerce
                        if ( function_exists( 'wc_get_product' ) && get_post_type() === 'product' ) {
                            wc_get_template_part( 'content', 'product' );
                        } else {
                            // Post ou página normal
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result-card' ); ?>>
                                <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="search-result-card__link">
                                    <?php the_post_thumbnail( 'medium' ); ?>
                                </a>
                                <?php endif; ?>
                                
                                <div class="search-result-card__content">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <p class="search-result-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                                    <span class="search-result-card__type">
                                        <?php
                                        $post_type = get_post_type_object( get_post_type() );
                                        echo esc_html( $post_type->labels->singular_name );
                                        ?>
                                    </span>
                                </div>
                            </article>
                            <?php
                        }
                    endwhile;
                    ?>
                </div>
                
                <!-- Paginação -->
                <nav class="archive-pagination" aria-label="<?php _e( 'Paginação', 'iron-task' ); ?>">
                    <?php
                    the_posts_pagination(
                        array(
                            'mid_size'  => 2,
                            'prev_text' => '&larr; ' . __( 'Anterior', 'iron-task' ),
                            'next_text' => __( 'Próxima', 'iron-task' ) . ' &rarr;',
                        )
                    );
                    ?>
                </nav>
                <?php
            else :
                ?>
                <section class="search-no-results">
                    <h2><?php _e( 'Nenhum resultado encontrado', 'iron-task' ); ?></h2>
                    <p><?php _e( 'Não encontramos nenhum resultado para sua busca. Tente outros termos.', 'iron-task' ); ?></p>
                    
                    <!-- Formulário de busca -->
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <label>
                            <span class="screen-reader-text"><?php _e( 'Buscar por:', 'iron-task' ); ?></span>
                            <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Buscar...', 'iron-task' ); ?>" value="" name="s">
                        </label>
                        <button type="submit" class="search-submit btn btn--primary"><?php _e( 'BUSCAR', 'iron-task' ); ?></button>
                    </form>
                </section>
                <?php
            endif;
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
