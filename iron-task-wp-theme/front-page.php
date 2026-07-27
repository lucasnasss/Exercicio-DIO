<?php
/**
 * Front Page Template (Página Inicial)
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- Hero Section -->
<section class="hero">
    <svg class="hero__watermark" viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path fill="var(--color-accent-primary)" opacity="0.08" d="M20 60 Q20 30 55 25 Q75 22 90 30 Q100 35 100 50 Q100 65 85 70 Q75 72 60 68 Q45 65 35 55 Q25 45 20 60Z M90 30 Q105 20 108 35 Q110 45 100 50 M55 25 Q50 15 55 10 M65 22 Q62 10 68 8 M75 24 Q75 12 80 10"/>
    </svg>
    <div class="hero__content container reveal">
        <h1 class="hero__title"><?php esc_html_e( 'FORJADO', 'iron-task' ); ?><br><?php esc_html_e( 'NO FOGO', 'iron-task' ); ?></h1>
        <p class="hero__subtitle"><?php esc_html_e( 'Vestido com propósito. Como você.', 'iron-task' ); ?></p>
        <?php 
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id && $shop_page_id > 0 ) :
        ?>
            <a href="<?php echo esc_url( get_permalink( $shop_page_id ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'VER CATÁLOGO', 'iron-task' ); ?></a>
        <?php endif; ?>
    </div>
</section>

<!-- Manifesto Section -->
<section class="section reveal">
    <div class="container">
        <h2 class="section__heading"><?php esc_html_e( 'MANIFESTO', 'iron-task' ); ?></h2>
        <p class="manifesto__text"><?php esc_html_e( '"Não é sobre chegar. É sobre continuar quando todos param."', 'iron-task' ); ?></p>
        <p class="manifesto__text"><?php esc_html_e( '"Forjado no fogo. Vestido com propósito."', 'iron-task' ); ?></p>
        <p class="manifesto__text"><?php esc_html_e( '"Roupas que aguentam o tranco. Como você."', 'iron-task' ); ?></p>
    </div>
</section>

<!-- Produtos em Destaque -->
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<section class="section section--dark reveal">
    <div class="container">
        <h2 class="section__heading"><?php esc_html_e( 'DESTAQUES', 'iron-task' ); ?></h2>
        <?php echo do_shortcode( '[products limit="4" columns="4" visibility="featured"]' ); ?>
    </div>
</section>
<?php endif; ?>

<!-- Coleções -->
<section class="section reveal">
    <div class="container">
        <h2 class="section__heading"><?php esc_html_e( 'COLEÇÕES', 'iron-task' ); ?></h2>
        <div class="collection-grid">
            <div class="collection-card" onclick="window.location.href='<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>'">
                <div class="collection-card__content">
                    <div class="collection-card__subtitle"><?php esc_html_e( 'LANÇAMENTO', 'iron-task' ); ?></div>
                    <div class="collection-card__title"><?php esc_html_e( 'FORJADO NO FOGO', 'iron-task' ); ?></div>
                </div>
            </div>
            <div class="collection-stack">
                <div class="collection-card" onclick="window.location.href='<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>?orderby=newness'">
                    <div class="collection-card__content">
                        <div class="collection-card__subtitle"><?php esc_html_e( 'LIMITADO', 'iron-task' ); ?></div>
                        <div class="collection-card__title"><?php esc_html_e( 'RESISTÊNCIA', 'iron-task' ); ?></div>
                    </div>
                </div>
                <div class="collection-card" onclick="window.location.href='<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>'">
                    <div class="collection-card__content">
                        <div class="collection-card__subtitle"><?php esc_html_e( 'ATEMPORAL', 'iron-task' ); ?></div>
                        <div class="collection-card__title"><?php esc_html_e( 'ESSENTIALS', 'iron-task' ); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Diferenciais -->
<section class="section section--elevated reveal">
    <div class="container">
        <h2 class="section__heading"><?php esc_html_e( 'DIFERENCIAIS', 'iron-task' ); ?></h2>
        <div class="benefits-grid">
            <div class="benefit-card">
                <svg class="benefit-card__icon" viewBox="0 0 24 24">
                    <path d="M12 2l3 7h7l-5.5 4 2 7-6.5-4.5L5.5 20l2-7L2 9h7z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
                <div class="benefit-card__title"><?php esc_html_e( 'COSTURA REFORÇADA', 'iron-task' ); ?></div>
                <div class="benefit-card__text"><?php esc_html_e( 'Costura dupla em pontos de tensão.', 'iron-task' ); ?></div>
            </div>
            <div class="benefit-card">
                <svg class="benefit-card__icon" viewBox="0 0 24 24">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
                <div class="benefit-card__title"><?php esc_html_e( 'TECIDO PREMIUM', 'iron-task' ); ?></div>
                <div class="benefit-card__text"><?php esc_html_e( 'Algodão egípcio de alta performance.', 'iron-task' ); ?></div>
            </div>
            <div class="benefit-card">
                <svg class="benefit-card__icon" viewBox="0 0 24 24">
                    <rect x="1" y="3" width="15" height="13" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <path d="M23 7l-7 4 7 4V7z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
                <div class="benefit-card__title"><?php esc_html_e( 'FRETE GRÁTIS', 'iron-task' ); ?></div>
                <div class="benefit-card__text"><?php esc_html_e( 'Acima de R$299 para todo Brasil.', 'iron-task' ); ?></div>
            </div>
            <div class="benefit-card">
                <svg class="benefit-card__icon" viewBox="0 0 24 24">
                    <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
                <div class="benefit-card__title"><?php esc_html_e( 'TROCA FÁCIL', 'iron-task' ); ?></div>
                <div class="benefit-card__text"><?php esc_html_e( '30 dias para trocar, sem burocracia.', 'iron-task' ); ?></div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="cta-banner reveal">
    <p class="cta-banner__text"><?php esc_html_e( 'PRONTO PARA ENTRAR NA ARENA?', 'iron-task' ); ?></p>
    <?php if ( $shop_page_id && $shop_page_id > 0 ) : ?>
        <a href="<?php echo esc_url( get_permalink( $shop_page_id ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'VER CATÁLOGO COMPLETO', 'iron-task' ); ?></a>
    <?php endif; ?>
</section>

<?php
get_footer();
