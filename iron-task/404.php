<?php
/**
 * 404 error page template
 *
 * Template para página de erro 404
 *
 * @package Iron_Task
 * @since 1.0.0
 */

get_header();
?>

<div class="app-view">
    <div class="container">
        <section class="error-404">
            <h1>404</h1>
            <p><?php _e( 'Ops! Página não encontrada.', 'iron-task' ); ?></p>
            <p class="error-404__message"><?php _e( 'A página que você está procurando não existe ou foi movida.', 'iron-task' ); ?></p>
            
            <div class="error-404__actions">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">
                    <?php _e( 'VOLTAR AO INÍCIO', 'iron-task' ); ?>
                </a>
                
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn--secondary">
                    <?php _e( 'VER LOJA', 'iron-task' ); ?>
                </a>
                <?php endif; ?>
            </div>
            
            <!-- Formulário de busca -->
            <div class="error-404__search">
                <p><?php _e( 'Ou tente buscar:', 'iron-task' ); ?></p>
                <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <label>
                        <span class="screen-reader-text"><?php _e( 'Buscar por:', 'iron-task' ); ?></span>
                        <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'O que você procura?', 'iron-task' ); ?>" value="" name="s">
                    </label>
                    <button type="submit" class="search-submit btn btn--primary"><?php _e( 'BUSCAR', 'iron-task' ); ?></button>
                </form>
            </div>
        </section>
    </div>
</div>

<?php
get_footer();
