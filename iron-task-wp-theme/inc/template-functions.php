<?php
/**
 * Template Functions
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Fallback menu para localização primary
 */
function iron_task_fallback_menu() {
    echo '<ul class="navbar__menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" class="navbar__link">' . __( 'Início', 'iron-task' ) . '</a></li>';
    
    if ( class_exists( 'WooCommerce' ) ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id > 0 ) {
            echo '<li><a href="' . esc_url( get_permalink( $shop_page_id ) ) . '" class="navbar__link">' . __( 'Loja', 'iron-task' ) . '</a></li>';
        }
    }
    
    echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '" class="navbar__link">' . __( 'Blog', 'iron-task' ) . '</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contato' ) ) . '" class="navbar__link">' . __( 'Contato', 'iron-task' ) . '</a></li>';
    echo '</ul>';
}

/**
 * Fallback menu para footer
 */
function iron_task_footer_fallback_menu() {
    echo '<ul class="footer__list">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Início', 'iron-task' ) . '</a></li>';
    
    if ( class_exists( 'WooCommerce' ) ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id > 0 ) {
            echo '<li><a href="' . esc_url( get_permalink( $shop_page_id ) ) . '">' . __( 'Loja', 'iron-task' ) . '</a></li>';
        }
    }
    
    echo '<li><a href="' . esc_url( home_url( '/sobre' ) ) . '">' . __( 'Sobre', 'iron-task' ) . '</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contato' ) ) . '">' . __( 'Contato', 'iron-task' ) . '</a></li>';
    echo '</ul>';
}

/**
 * Callback para comentários
 */
function iron_task_comment_callback( $comment, $args, $depth ) {
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment-item' ); ?>>
        <article class="comment-body">
            <header class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, 50, '', '', array( 'class' => 'comment-avatar' ) ); ?>
                    <div class="comment-author-info">
                        <strong class="fn"><?php comment_author_link(); ?></strong>
                        <span class="comment-date"><?php comment_date(); ?></span>
                    </div>
                </div>
            </header>
            
            <div class="comment-content">
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <p class="comment-awaiting-moderation"><?php esc_html_e( 'Seu comentário está aguardando moderação.', 'iron-task' ); ?></p>
                <?php endif; ?>
                <?php comment_text(); ?>
            </div>
            
            <footer class="comment-actions">
                <?php
                comment_reply_link( array_merge( $args, array(
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<span class="reply-link">',
                    'after'     => '</span>',
                ) ) );
                ?>
                <?php edit_comment_link( __( 'Editar', 'iron-task' ), '<span class="edit-link">', '</span>' ); ?>
            </footer>
        </article>
    <?php
}

/**
 * Formatar preço WooCommerce
 */
function iron_task_format_price( $price ) {
    return 'R$ ' . number_format( $price, 2, ',', '.' );
}

/**
 * Adicionar wrapper em torno do conteúdo
 */
function iron_task_content_wrapper_start() {
    echo '<div class="container">';
}

function iron_task_content_wrapper_end() {
    echo '</div>';
}

/**
 * Get SVG icon
 */
function iron_task_get_icon( $icon_name, $atts = array() ) {
    $icons = array(
        'cart' => '<svg viewBox="0 0 24 24" width="24" height="24"><path d="M6 6h15l-1.5 9h-12z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/><circle cx="9" cy="20" r="1.5" fill="currentColor"/><circle cx="18" cy="20" r="1.5" fill="currentColor"/><path d="M6 6L5 2H2" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>',
        'search' => '<svg viewBox="0 0 24 24" width="20" height="20"><circle cx="10.5" cy="10.5" r="6.5" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M15.5 15.5L21 21" stroke="currentColor" stroke-width="1.5"/></svg>',
        'user' => '<svg viewBox="0 0 24 24" width="20" height="20"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M4 20c0-4.4 3.6-8 8-8s8 3.6 8 8" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>',
        'close' => '<svg viewBox="0 0 24 24" width="24" height="24"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
        'menu' => '<svg viewBox="0 0 24 24" width="24" height="24"><path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
    );
    
    if ( isset( $icons[ $icon_name ] ) ) {
        return $icons[ $icon_name ];
    }
    
    return '';
}

/**
 * Exibir badge de produto
 */
function iron_task_product_badge( $product ) {
    if ( ! $product instanceof WC_Product ) {
        return;
    }
    
    $badge = '';
    
    if ( $product->is_on_sale() ) {
        $badge = '<span class="product-badge product-badge--sale">' . __( 'Oferta', 'iron-task' ) . '</span>';
    } elseif ( $product->is_featured() ) {
        $badge = '<span class="product-badge product-badge--featured">' . __( 'Destaque', 'iron-task' ) . '</span>';
    } else {
        $newness = strtotime( $product->get_date_created() );
        $now = time();
        $days_old = ( $now - $newness ) / DAY_IN_SECONDS;
        
        if ( $days_old < 7 ) {
            $badge = '<span class="product-badge product-badge--new">' . __( 'Novo', 'iron-task' ) . '</span>';
        }
    }
    
    echo $badge;
}
