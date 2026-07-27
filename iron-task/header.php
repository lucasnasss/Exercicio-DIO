<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="dark">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
    
    <!-- Theme toggle immediate execution -->
    <script>
        (function() {
            const saved = localStorage.getItem('iron-task-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'light' || (!saved && !prefersDark)) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>
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
        <p class="loader__text"><?php _e( 'FORJADO NO FOGO', 'iron-task' ); ?></p>
    </div>
</div>

<!-- Navbar -->
<header class="navbar" id="navbar" role="banner">
    <div class="navbar__container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar__logo" aria-label="<?php bloginfo( 'name' ); ?>">
            <?php
            // Tenta exibir logo customizado do WordPress
            if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                // Logo SVG padrão
                echo iron_task_get_logo_svg();
                ?>
                <span class="navbar__logo-text"><?php bloginfo( 'name' ); ?></span>
                <?php
            }
            ?>
        </a>
        
        <nav class="navbar__nav" role="navigation" aria-label="<?php _e( 'Navegação principal', 'iron-task' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'navbar__list',
                'fallback_cb'    => false,
                'depth'          => 2,
            ) );
            ?>
        </nav>
        
        <div class="navbar__actions">
            <!-- Botão de busca -->
            <button class="navbar__action-btn" id="btn-search" aria-label="<?php _e( 'Buscar', 'iron-task' ); ?>">
                <svg viewBox="0 0 24 24" width="20" height="20">
                    <circle cx="10.5" cy="10.5" r="6.5" stroke="currentColor" stroke-width="1.8" fill="none"/>
                    <path d="M15.5 15.5L21 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </button>
            
            <!-- Toggle de tema -->
            <button class="navbar__action-btn" id="btn-theme" aria-label="<?php _e( 'Alternar tema', 'iron-task' ); ?>">
                <svg class="navbar__icon-sun" viewBox="0 0 24 24" width="20" height="20">
                    <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.8" fill="none"/>
                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <svg class="navbar__icon-moon" viewBox="0 0 24 24" width="20" height="20">
                    <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <!-- Carrinho WooCommerce -->
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
            <button class="navbar__action-btn navbar__cart-btn" id="btn-cart" aria-label="<?php _e( 'Carrinho de compras', 'iron-task' ); ?>">
                <svg viewBox="0 0 24 24" width="20" height="20">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 10a4 4 0 01-8 0" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                </svg>
                <span class="navbar__cart-count" id="cart-count" aria-live="polite">
                    <?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?>
                </span>
            </button>
            <?php endif; ?>
            
            <!-- Menu hamburger (mobile) -->
            <button class="navbar__hamburger" id="btn-menu" aria-label="<?php _e( 'Abrir menu', 'iron-task' ); ?>" aria-expanded="false">
                <span class="navbar__hamburger-line"></span>
                <span class="navbar__hamburger-line"></span>
                <span class="navbar__hamburger-line"></span>
            </button>
        </div>
    </div>
    
    <!-- Mega Menu -->
    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
    <div class="mega-menu" id="mega-menu" aria-hidden="true">
        <div class="mega-menu__container">
            <div class="mega-menu__col">
                <h4 class="mega-menu__heading"><?php _e( 'CATEGORIAS', 'iron-task' ); ?></h4>
                <?php
                $product_categories = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'number'     => 6,
                ) );
                
                if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) :
                ?>
                <ul class="mega-menu__list">
                    <?php foreach ( $product_categories as $category ) : ?>
                    <li><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <div class="mega-menu__col">
                <h4 class="mega-menu__heading"><?php _e( 'COLEÇÕES', 'iron-task' ); ?></h4>
                <ul class="mega-menu__list">
                    <li><a href="<?php echo esc_url( home_url( '/?orderby=popularity' ) ); ?>"><?php _e( 'Mais Populares', 'iron-task' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/?orderby=date' ) ); ?>"><?php _e( 'Lançamentos', 'iron-task' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/?orderby=price-desc' ) ); ?>"><?php _e( 'Edições Limitadas', 'iron-task' ); ?></a></li>
                </ul>
            </div>
            <div class="mega-menu__col mega-menu__col--featured">
                <div class="mega-menu__featured-img">
                    <?php _e( 'NOVA<br>COLEÇÃO', 'iron-task' ); ?>
                </div>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="mega-menu__featured-link">
                    <?php _e( 'Ver Coleção →', 'iron-task' ); ?>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</header>

<!-- Menu Mobile Overlay -->
<div class="mobile-overlay" id="mobile-overlay" aria-hidden="true"></div>

<!-- Menu Mobile -->
<aside class="mobile-menu" id="mobile-menu" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php _e( 'Menu', 'iron-task' ); ?>">
    <div class="mobile-menu__header">
        <span class="mobile-menu__logo-text"><?php bloginfo( 'name' ); ?></span>
        <button class="mobile-menu__close" id="btn-menu-close" aria-label="<?php _e( 'Fechar menu', 'iron-task' ); ?>">
            <svg viewBox="0 0 24 24" width="24" height="24">
                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
    <nav class="mobile-menu__nav" role="navigation">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'mobile',
            'container'      => false,
            'menu_class'     => 'mobile-menu__list',
            'fallback_cb'    => 'wp_page_menu',
            'depth'          => 2,
        ) );
        ?>
    </nav>
    <div class="mobile-menu__footer">
        <div class="mobile-menu__social">
            <?php
            $instagram = get_theme_mod( 'iron_task_instagram' );
            $twitter   = get_theme_mod( 'iron_task_twitter' );
            $tiktok    = get_theme_mod( 'iron_task_tiktok' );
            ?>
            <?php if ( $instagram ) : ?>
            <a href="<?php echo esc_url( $instagram ); ?>" aria-label="Instagram">
                <svg viewBox="0 0 24 24" width="20" height="20">
                    <rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/>
                </svg>
            </a>
            <?php endif; ?>
            <?php if ( $twitter ) : ?>
            <a href="<?php echo esc_url( $twitter ); ?>" aria-label="Twitter">
                <svg viewBox="0 0 24 24" width="20" height="20">
                    <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/>
                </svg>
            </a>
            <?php endif; ?>
            <?php if ( $tiktok ) : ?>
            <a href="<?php echo esc_url( $tiktok ); ?>" aria-label="TikTok">
                <svg viewBox="0 0 24 24" width="20" height="20">
                    <path d="M9 12a4 4 0 101 8a4 4 0 001-8M15 8v8a4 4 0 01-4 4M15 8V2h4l-2 6h2l-4 7V8h-1" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
            </a>
            <?php endif; ?>
        </div>
    </div>
</aside>

<!-- Conteúdo principal -->
<main id="primary" class="site-main" role="main">
