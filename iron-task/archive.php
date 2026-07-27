<?php
/**
 * Archive template
 *
 * Template para arquivos (categorias, tags, datas, autores)
 *
 * @package Iron_Task
 * @since 1.0.0
 */

get_header();
?>

<div class="app-view">
    <div class="container">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php
                if ( is_category() ) {
                    single_cat_title();
                } elseif ( is_tag() ) {
                    single_tag_title();
                } elseif ( is_author() ) {
                    the_author_meta( 'display_name', get_query_var( 'author' ) );
                } elseif ( is_year() ) {
                    echo get_the_date( 'Y' );
                } elseif ( is_month() ) {
                    echo get_the_date( 'F Y' );
                } elseif ( is_day() ) {
                    echo get_the_date();
                } elseif ( is_post_type_archive() ) {
                    post_type_archive_title();
                } else {
                    _e( 'Arquivo', 'iron-task' );
                }
                ?>
            </h1>
            
            <?php
            // Descrição do arquivo
            $term_description = term_description();
            if ( $term_description ) {
                echo '<p class="archive-description">' . $term_description . '</p>';
            }
            ?>
        </header>
        
        <div class="archive-content">
            <?php
            if ( have_posts() ) :
                ?>
                <div class="posts-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'archive-post-card' ); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="archive-post-card__link">
                                <?php the_post_thumbnail( 'medium' ); ?>
                            </a>
                            <?php endif; ?>
                            
                            <div class="archive-post-card__content">
                                <span class="archive-post-card__category">
                                    <?php
                                    $categories = get_the_category();
                                    if ( ! empty( $categories ) ) {
                                        echo esc_html( $categories[0]->name );
                                    }
                                    ?>
                                </span>
                                
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                
                                <p class="archive-post-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                                
                                <div class="archive-post-card__meta">
                                    <span class="archive-post-card__date"><?php echo get_the_date(); ?></span>
                                    <span class="archive-post-card__author"><?php the_author(); ?></span>
                                </div>
                            </div>
                        </article>
                        <?php
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
                    <h2><?php _e( 'Nada encontrado', 'iron-task' ); ?></h2>
                    <p><?php _e( 'Desculpe, mas nenhum conteúdo foi encontrado nesta seção.', 'iron-task' ); ?></p>
                </section>
                <?php
            endif;
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
