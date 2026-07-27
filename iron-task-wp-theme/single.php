<?php
/**
 * Single Post Template
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post reveal' ); ?>>
            <header class="entry-header">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="single-post__thumbnail">
                        <?php the_post_thumbnail( 'iron-task-hero' ); ?>
                    </div>
                <?php endif; ?>
                
                <h1 class="entry-title"><?php the_title(); ?></h1>
                
                <div class="single-post__meta">
                    <span class="single-post__date"><?php echo get_the_date(); ?></span>
                    <span class="single-post__author"><?php esc_html_e( 'Por', 'iron-task' ); ?> <?php the_author(); ?></span>
                    <?php if ( has_category() ) : ?>
                        <span class="single-post__categories"><?php the_category( ', ' ); ?></span>
                    <?php endif; ?>
                </div>
            </header>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Páginas:', 'iron-task' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>

            <footer class="entry-footer">
                <?php
                $tags_list = get_the_tag_list( '', ', ' );
                if ( $tags_list ) :
                ?>
                    <div class="single-post__tags">
                        <strong><?php esc_html_e( 'Tags:', 'iron-task' ); ?></strong>
                        <?php echo $tags_list; ?>
                    </div>
                <?php endif; ?>
            </footer>

            <!-- Author Box -->
            <div class="author-box">
                <div class="author-box__avatar">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                </div>
                <div class="author-box__content">
                    <h3 class="author-box__name"><?php the_author(); ?></h3>
                    <p class="author-box__bio"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
                </div>
            </div>

            <!-- Post Navigation -->
            <nav class="post-navigation">
                <div class="nav-previous"><?php previous_post_link( '%link', '<span class="nav-label">' . __( 'Anterior', 'iron-task' ) . '</span><br>%title' ); ?></div>
                <div class="nav-next"><?php next_post_link( '%link', '<span class="nav-label">' . __( 'Próximo', 'iron-task' ) . '</span><br>%title' ); ?></div>
            </nav>

            <!-- Comments -->
            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        </article>
    <?php endwhile; ?>
</div>

<?php
get_footer();
