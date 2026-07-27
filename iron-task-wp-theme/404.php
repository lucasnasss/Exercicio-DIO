<?php
/**
 * 404 Error Template
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
    <div class="error-404 reveal" style="text-align: center; padding: 5rem 0;">
        <svg class="error-404__icon" viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="width: 200px; height: 160px; margin-bottom: 2rem;">
            <path fill="none" stroke="var(--color-accent-primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M20 60 Q20 30 55 25 Q75 22 90 30 Q100 35 100 50 Q100 65 85 70 Q75 72 60 68 Q45 65 35 55 Q25 45 20 60Z M90 30 Q105 20 108 35 Q110 45 100 50 M55 25 Q50 15 55 10 M65 22 Q62 10 68 8 M75 24 Q75 12 80 10"/>
        </svg>
        
        <h1 class="error-404__title" style="font-family: var(--font-display); font-size: clamp(3rem, 8vw, 6rem); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem; color: var(--color-accent-primary);">404</h1>
        
        <h2 class="error-404__heading" style="font-size: 1.5rem; margin-bottom: 1.5rem;"><?php esc_html_e( 'Página não encontrada', 'iron-task' ); ?></h2>
        
        <p class="error-404__text" style="color: var(--color-text-secondary); max-width: 500px; margin: 0 auto 2rem;">
            <?php esc_html_e( 'Ops! A página que você está procurando não existe ou foi movida. Que tal voltar para a página inicial?', 'iron-task' ); ?>
        </p>
        
        <div class="error-404__actions">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary">
                <?php esc_html_e( 'Voltar ao Início', 'iron-task' ); ?>
            </a>
            
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn--outline">
                    <?php esc_html_e( 'Ver Produtos', 'iron-task' ); ?>
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Search Form -->
        <div class="error-404__search" style="margin-top: 3rem; max-width: 400px; margin-left: auto; margin-right: auto;">
            <h3 style="font-size: 1rem; margin-bottom: 1rem;"><?php esc_html_e( 'Ou tente buscar:', 'iron-task' ); ?></h3>
            <?php get_search_form(); ?>
        </div>
    </div>
</div>

<style>
.error-404__actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}
</style>

<?php
get_footer();
