<?php
/**
 * Template Tags
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Exibir logo do site
 */
function iron_task_the_logo() {
    if ( has_custom_logo() ) {
        the_custom_logo();
    } else {
        ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar__logo">
            <svg class="navbar__logo-icon" viewBox="0 0 40 32" xmlns="http://www.w3.org/2000/svg">
                <path fill="var(--color-accent-primary)" d="M20 2L8 8v6c0 6.5 5 12.5 12 14 7-1.5 12-7.5 12-14V8L20 2zm-1 7h2v3h-2V9zm0 5h2v7h-2v-7z"/>
            </svg>
            <span><?php bloginfo( 'name' ); ?></span>
        </a>
        <?php
    }
}

/**
 * Exibir contador do carrinho
 */
function iron_task_cart_count() {
    if ( class_exists( 'WooCommerce' ) ) {
        echo '<span class="navbar__cart-count" id="cart-count">' . esc_html( WC()->cart->get_cart_contents_count() ) . '</span>';
    }
}

/**
 * Exibir ícone de tema
 */
function iron_task_theme_toggle_icon() {
    $current_theme = get_option( 'iron_task_theme', 'dark' );
    ?>
    <svg class="theme-toggle__icon theme-toggle__icon--light" viewBox="0 0 24 24" width="20" height="20"<?php echo $current_theme === 'light' ? ' style="display:none;"' : ''; ?>>
        <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
        <path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="1.5"/>
    </svg>
    <svg class="theme-toggle__icon theme-toggle__icon--dark" viewBox="0 0 24 24" width="20" height="20"<?php echo $current_theme === 'dark' ? ' style="display:none;"' : ''; ?>>
        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" stroke="currentColor" stroke-width="1.5" fill="none"/>
    </svg>
    <?php
}

/**
 * Exibir breadcrumbs
 */
function iron_task_breadcrumbs() {
    echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'iron-task' ) . '">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'iron-task' ) . '</a>';
    
    if ( is_category() || is_single() ) {
        echo ' <span class="breadcrumb__sep">/</span> ';
        the_category( ' <span class="breadcrumb__sep">/</span> ' );
        
        if ( is_single() ) {
            echo ' <span class="breadcrumb__sep">/</span> ';
            the_title( '<span>', '</span>' );
        }
    } elseif ( is_page() ) {
        echo ' <span class="breadcrumb__sep">/</span> ';
        the_title( '<span>', '</span>' );
    } elseif ( is_search() ) {
        echo ' <span class="breadcrumb__sep">/</span> ';
        printf( __( 'Busca: %s', 'iron-task' ), get_search_query() );
    } elseif ( is_archive() ) {
        echo ' <span class="breadcrumb__sep">/</span> ';
        post_type_archive_title( '<span>', '</span>' );
    }
    
    echo '</nav>';
}

/**
 * Exibir tempo de leitura do post
 */
function iron_task_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    $reading_time = ceil( $word_count / 200 );
    
    return sprintf(
        /* translators: %d: reading time in minutes */
        _n( '%d minuto de leitura', '%d minutos de leitura', $reading_time, 'iron-task' ),
        $reading_time
    );
}

/**
 * Exibir share buttons
 */
function iron_task_share_buttons() {
    $url = urlencode( get_permalink() );
    $title = urlencode( get_the_title() );
    ?>
    <div class="share-buttons">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank" rel="noopener" class="share-button share-button--facebook" aria-label="<?php esc_attr_e( 'Compartilhar no Facebook', 'iron-task' ); ?>">
            <svg viewBox="0 0 24 24" width="18" height="18"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>" target="_blank" rel="noopener" class="share-button share-button--twitter" aria-label="<?php esc_attr_e( 'Compartilhar no Twitter', 'iron-task' ); ?>">
            <svg viewBox="0 0 24 24" width="18" height="18"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
        </a>
        <a href="https://wa.me/?text=<?php echo $title; ?>%20<?php echo $url; ?>" target="_blank" rel="noopener" class="share-button share-button--whatsapp" aria-label="<?php esc_attr_e( 'Compartilhar no WhatsApp', 'iron-task' ); ?>">
            <svg viewBox="0 0 24 24" width="18" height="18"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" fill="currentColor"/></svg>
        </a>
        <a href="mailto:?subject=<?php echo $title; ?>&body=<?php echo $url; ?>" class="share-button share-button--email" aria-label="<?php esc_attr_e( 'Compartilhar por e-mail', 'iron-task' ); ?>">
            <svg viewBox="0 0 24 24" width="18" height="18"><rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M22 6l-10 7L2 6" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
        </a>
    </div>
    <?php
}
