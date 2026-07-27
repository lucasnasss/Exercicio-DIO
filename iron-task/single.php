<?php
/**
 * Single post template
 *
 * Template para posts individuais do blog
 *
 * @package Iron_Task
 * @since 1.0.0
 */

get_header();
?>

<div class="app-view">
    <div class="container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>
                <header class="entry-header">
                    <?php
                    // Categorias
                    $categories = get_the_category();
                    if ( ! empty( $categories ) ) {
                        echo '<span class="entry-category">' . esc_html( $categories[0]->name ) . '</span>';
                    }
                    ?>
                    
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    
                    <div class="entry-meta">
                        <span class="entry-date"><?php echo get_the_date(); ?></span>
                        <span class="entry-author"><?php _e( 'por', 'iron-task' ); ?> <?php the_author(); ?></span>
                    </div>
                </header>
                
                <?php if ( has_post_thumbnail() ) : ?>
                <figure class="entry-thumbnail">
                    <?php the_post_thumbnail( 'large' ); ?>
                </figure>
                <?php endif; ?>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                
                <footer class="entry-footer">
                    <?php
                    // Tags
                    $tags = get_the_tags();
                    if ( ! empty( $tags ) ) {
                        echo '<div class="entry-tags">';
                        foreach ( $tags as $tag ) {
                            echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="entry-tag">#' . esc_html( $tag->name ) . '</a>';
                        }
                        echo '</div>';
                    }
                    ?>
                    
                    <!-- Compartilhamento -->
                    <div class="entry-share">
                        <span><?php _e( 'Compartilhar:', 'iron-task' ); ?></span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                            Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener" aria-label="Twitter">
                            Twitter
                        </a>
                        <a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' - ' . get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
                            WhatsApp
                        </a>
                    </div>
                </footer>
            </article>
            
            <!-- Autor -->
            <div class="entry-author">
                <div class="entry-author__avatar">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                </div>
                <div class="entry-author__info">
                    <h3><?php the_author(); ?></h3>
                    <p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
                </div>
            </div>
            
            <!-- Posts relacionados -->
            <div class="related-posts">
                <h2><?php _e( 'Leia também', 'iron-task' ); ?></h2>
                <?php
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    $related_args = array(
                        'category__in'   => wp_list_pluck( $categories, 'term_id' ),
                        'post__not_in'   => array( get_the_ID() ),
                        'posts_per_page' => 3,
                        'ignore_sticky_posts' => true,
                    );
                    
                    $related_query = new WP_Query( $related_args );
                    
                    if ( $related_query->have_posts() ) {
                        echo '<div class="related-posts-grid">';
                        
                        while ( $related_query->have_posts() ) {
                            $related_query->the_post();
                            ?>
                            <article class="related-post-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="related-post-card__link">
                                    <?php the_post_thumbnail( 'medium' ); ?>
                                </a>
                                <?php endif; ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <span class="related-post-card__date"><?php echo get_the_date(); ?></span>
                            </article>
                            <?php
                        }
                        
                        echo '</div>';
                        wp_reset_postdata();
                    }
                }
                ?>
            </div>
            
            <!-- Comentários -->
            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
            
            <?php
        endwhile;
        ?>
    </div>
</div>

<?php
get_footer();
