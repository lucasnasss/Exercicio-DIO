<?php
/**
 * Header Template
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="<?php echo esc_attr( get_option( 'iron_task_theme', 'dark' ) ); ?>">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0A0A0C">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Loader -->
<div id="loader" class="loader" aria-hidden="true">
    <div class="loader__inner">
        <svg class="loader__svg" viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" stroke="var(--accent-primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path class="loader__stroke" d="M20 60 Q20 30 55 25 Q75 22 90 30 Q100 35 100 50 Q100 65 85 70 Q75 72 60 68 Q45 65 35 55 Q25 45 20 60Z" />
                <path class="loader__stroke" d="M90 30 Q105 20 108 35 Q110 45 100 50" />
                <path class="loader__stroke" d="M105 38 L112 42 M100 42 L108 48" stroke-width="2" />
                <circle class="loader__stroke" cx="95" cy="33" r="2" fill="var(--accent-primary)" />
                <path class="loader__stroke" d="M55 25 Q50 15 55 10 M65 22 Q62 10 68 8 M75 24 Q75 12 80 10" stroke-width="2" />
                <path class="loader__stroke" d="M35 65 L30 85 L25 88 M40 68 L38 88 L33 92" />
                <path class="loader__stroke" d="M75 68 L78 88 L83 92 M85 65 L90 85 L95 88" />
            </g>
        </svg>
        <p class="loader__text"><?php esc_html_e( 'FORJADO NO FOGO', 'iron-task' ); ?></p>
    </div>
</div>

<!-- Navbar -->
<header class="navbar" id="navbar" role="banner">
    <div class="navbar__container">
        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar__logo" aria-label="<?php esc_attr_e( 'Iron Task — Página Inicial', 'iron-task' ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <svg class="navbar__logo-icon" viewBox="0 0 40 32" xmlns="http://www.w3.org/2000/svg">
                    <path fill="var(--color-accent-primary)" d="M20 2L8 8v6c0 6.5 5 12.5 12 14 7-1.5 12-7.5 12-14V8L20 2zm-1 7h2v3h-2V9zm0 5h2v7h-2v-7z"/>
                </svg>
                <span><?php bloginfo( 'name' ); ?></span>
            <?php endif; ?>
        </a>

        <!-- Navegação Principal -->
        <nav class="navbar__nav" id="navbar-nav" role="navigation" aria-label="<?php esc_attr_e( 'Menu principal', 'iron-task' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'navbar__menu',
                'container'      => false,
                'depth'          => 2,
                'fallback_cb'    => 'iron_task_fallback_menu',
            ) );
            ?>
        </nav>

        <!-- Ações -->
        <div class="navbar__actions">
            <!-- Tema Toggle -->
            <button class="navbar__theme-toggle" id="theme-toggle" aria-label="<?php esc_attr_e( 'Alternar tema', 'iron-task' ); ?>">
                <svg class="theme-toggle__icon theme-toggle__icon--light" viewBox="0 0 24 24" width="20" height="20">
                    <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <svg class="theme-toggle__icon theme-toggle__icon--dark" viewBox="0 0 24 24" width="20" height="20" style="display:none;">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
            </button>

            <!-- Carrinho WooCommerce -->
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="navbar__cart" aria-label="<?php esc_attr_e( 'Ver carrinho', 'iron-task' ); ?>">
                    <svg class="navbar__cart-icon" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M6 6h15l-1.5 9h-12z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/>
                        <circle cx="9" cy="20" r="1.5" fill="currentColor"/>
                        <circle cx="18" cy="20" r="1.5" fill="currentColor"/>
                        <path d="M6 6L5 2H2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    </svg>
                    <span class="navbar__cart-count" id="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                </a>
            <?php endif; ?>

            <!-- Menu Mobile Toggle -->
            <button class="navbar__menu-toggle" id="menu-toggle" aria-label="<?php esc_attr_e( 'Abrir menu', 'iron-task' ); ?>" aria-expanded="false">
                <svg class="menu-toggle__icon menu-toggle__icon--open" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <svg class="menu-toggle__icon menu-toggle__icon--close" viewBox="0 0 24 24" width="24" height="24" style="display:none;">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>
</header>

<main id="main-content" class="site-content" role="main">
