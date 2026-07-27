</main>

<!-- Footer -->
<footer class="footer" role="contentinfo">
    <div class="footer__container">
        <!-- Marca d'água decorativa -->
        <svg class="footer__watermark" viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <g fill="none" stroke="var(--accent-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" opacity="0.1">
                <path d="M20 60 Q20 30 55 25 Q75 22 90 30 Q100 35 100 50 Q100 65 85 70 Q75 72 60 68 Q45 65 35 55 Q25 45 20 60Z" />
                <path d="M90 30 Q105 20 108 35 Q110 45 100 50" />
                <path d="M105 38 L112 42 M100 42 L108 48" stroke-width="1" />
                <circle cx="95" cy="33" r="2" fill="var(--accent-primary)" />
                <path d="M55 25 Q50 15 55 10 M65 22 Q62 10 68 8 M75 24 Q75 12 80 10" stroke-width="1" />
                <path d="M35 65 L30 85 L25 88 M40 68 L38 88 L33 92" />
                <path d="M75 68 L78 88 L83 92 M85 65 L90 85 L95 88" />
            </g>
        </svg>
        
        <div class="footer__grid">
            <!-- Coluna 1 - Sobre -->
            <div class="footer__col">
                <h4 class="footer__heading"><?php _e( 'SOBRE', 'iron-task' ); ?></h4>
                <p class="footer__text">
                    <?php _e( 'Forjado no fogo. Vestido com propósito. Moda esportiva e streetwear de alto nível para quem busca excelência em cada detalhe.', 'iron-task' ); ?>
                </p>
                <p class="footer__text footer__text--small">
                    <?php _e( '© ' . date( 'Y' ) . ' Iron Task. Todos os direitos reservados.', 'iron-task' ); ?>
                </p>
            </div>
            
            <!-- Coluna 2 - Links -->
            <div class="footer__col">
                <h4 class="footer__heading"><?php _e( 'LINKS', 'iron-task' ); ?></h4>
                <ul class="footer__list">
                    <li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php _e( 'Loja', 'iron-task' ); ?></a></li>
                    <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) ); ?>"><?php _e( 'Carrinho', 'iron-task' ); ?></a></li>
                    <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'checkout' ) ) ); ?>"><?php _e( 'Checkout', 'iron-task' ); ?></a></li>
                    <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php _e( 'Minha Conta', 'iron-task' ); ?></a></li>
                </ul>
            </div>
            
            <!-- Coluna 3 - Ajuda -->
            <div class="footer__col">
                <h4 class="footer__heading"><?php _e( 'AJUDA', 'iron-task' ); ?></h4>
                <ul class="footer__list">
                    <li><a href="#"><?php _e( 'FAQ', 'iron-task' ); ?></a></li>
                    <li><a href="#"><?php _e( 'Entregas', 'iron-task' ); ?></a></li>
                    <li><a href="#"><?php _e( 'Trocas e Devoluções', 'iron-task' ); ?></a></li>
                    <li><a href="#"><?php _e( 'Contato', 'iron-task' ); ?></a></li>
                </ul>
            </div>
            
            <!-- Coluna 4 - Newsletter & Social -->
            <div class="footer__col">
                <h4 class="footer__heading"><?php _e( 'NEWSLETTER', 'iron-task' ); ?></h4>
                <p class="footer__text footer__text--small">
                    <?php _e( 'Receba novidades e ofertas exclusivas.', 'iron-task' ); ?>
                </p>
                <form class="footer__newsletter" method="post" action="">
                    <input type="email" name="newsletter_email" placeholder="<?php esc_attr_e( 'Seu melhor e-mail', 'iron-task' ); ?>" class="footer__input" required>
                    <button type="submit" class="footer__submit"><?php _e( 'INSCREVER', 'iron-task' ); ?></button>
                </form>
                
                <h4 class="footer__heading footer__heading--newsletter"><?php _e( 'SIGA-NOS', 'iron-task' ); ?></h4>
                <div class="footer__social">
                    <?php
                    $instagram = get_theme_mod( 'iron_task_instagram' );
                    $twitter   = get_theme_mod( 'iron_task_twitter' );
                    $tiktok    = get_theme_mod( 'iron_task_tiktok' );
                    ?>
                    <?php if ( $instagram ) : ?>
                    <a href="<?php echo esc_url( $instagram ); ?>" class="footer__social-link" aria-label="Instagram" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" width="18" height="18">
                            <rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    <?php if ( $twitter ) : ?>
                    <a href="<?php echo esc_url( $twitter ); ?>" class="footer__social-link" aria-label="Twitter" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" width="18" height="18">
                            <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    <?php if ( $tiktok ) : ?>
                    <a href="<?php echo esc_url( $tiktok ); ?>" class="footer__social-link" aria-label="TikTok" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" width="18" height="18">
                            <path d="M9 12a4 4 0 101 8a4 4 0 001-8M15 8v8a4 4 0 01-4 4M15 8V2h4l-2 6h2l-4 7V8h-1" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Badges informativos -->
        <div class="footer__badges">
            <span class="footer__badge">🚚 <?php _e( 'Entrega Rápida', 'iron-task' ); ?></span>
            <span class="footer__badge">🔄 <?php _e( 'Troca Fácil', 'iron-task' ); ?></span>
            <span class="footer__badge">🔒 <?php _e( 'Compra Segura', 'iron-task' ); ?></span>
            <span class="footer__badge">⭐ <?php _e( 'Qualidade Premium', 'iron-task' ); ?></span>
        </div>
    </div>
</footer>

<!-- Toast Container -->
<div class="toast-container" id="toast-container" aria-live="polite"></div>

<?php wp_footer(); ?>

</body>
</html>
