<?php
/**
 * Archive Template
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
    <header class="archive-header reveal">
        <?php
        the_archive_title( '<h1 class="archive-title">', '</h1>' );
        the_archive_description( '<div class="archive-description">', '</div>' );
        ?>
    </header>

    <?php if ( have_posts() ) : ?>
        <div class="posts-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card reveal' ); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" class="post-card__image">
                            <?php the_post_thumbnail( 'iron-task-product' ); ?>
                        </a>
                    <?php endif; ?>
                    <div class="post-card__content">
                        <h2 class="post-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-card__meta">
                            <span class="post-card__date"><?php echo get_the_date(); ?></span>
                            <span class="post-card__author"><?php the_author(); ?></span>
                        </div>
                        <div class="post-card__excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn btn--outline"><?php esc_html_e( 'Ler mais', 'iron-task' ); ?></a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => __( 'Anterior', 'iron-task' ),
            'next_text' => __( 'Próxima', 'iron-task' ),
        ) ); ?>

    <?php else : ?>
        <div class="no-results">
            <h2><?php esc_html_e( 'Nenhum conteúdo encontrado', 'iron-task' ); ?></h2>
            <p><?php esc_html_e( 'Desculpe, mas nenhum conteúdo foi encontrado.', 'iron-task' ); ?></p>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();
