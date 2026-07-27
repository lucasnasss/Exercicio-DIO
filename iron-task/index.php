<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package Iron_Task
 * @since 1.0.0
 */

get_header();
?>

<div class="app-view">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;

            // Paginação
            the_posts_pagination(
                array(
                    'mid_size'  => 2,
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                )
            );

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

<?php
get_footer();
