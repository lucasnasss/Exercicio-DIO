<?php
/**
 * Footer Template
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
</main><!-- #main-content -->

<!-- Footer -->
<footer class="footer" role="contentinfo">
    <div class="footer__container">
        <svg class="footer__watermark" viewBox="0 0 120 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path fill="var(--color-accent-primary)" opacity="0.06" d="M20 60 Q20 30 55 25 Q75 22 90 30 Q100 35 100 50 Q100 65 85 70 Q75 72 60 68 Q45 65 35 55 Q25 45 20 60Z M90 30 Q105 20 108 35 Q110 45 100 50 M55 25 Q50 15 55 10 M65 22 Q62 10 68 8 M75 24 Q75 12 80 10"/>
        </svg>
        
        <div class="footer__grid">
            <!-- Coluna 1: Sobre -->
            <div class="footer__col">
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                <?php else : ?>
                    <h4 class="footer__heading"><?php bloginfo( 'name' ); ?></h4>
                    <p class="footer__text"><?php esc_html_e( 'Forjado no fogo.', 'iron-task' ); ?><br><?php esc_html_e( 'Vestido com propósito.', 'iron-task' ); ?></p>
                    <p class="footer__text footer__text--small">&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Todos os direitos reservados.', 'iron-task' ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Coluna 2: Navegação -->
            <div class="footer__col">
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                <?php else : ?>
                    <h4 class="footer__heading"><?php esc_html_e( 'NAVEGAÇÃO', 'iron-task' ); ?></h4>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer__list',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => 'iron_task_footer_fallback_menu',
                    ) );
                    ?>
                <?php endif; ?>
            </div>

            <!-- Coluna 3: Suporte -->
            <div class="footer__col">
                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                <?php else : ?>
                    <h4 class="footer__heading"><?php esc_html_e( 'SUPORTE', 'iron-task' ); ?></h4>
                    <ul class="footer__list">
                        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'faq' ) ) ); ?>"><?php esc_html_e( 'FAQ', 'iron-task' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'privacidade' ) ) ); ?>"><?php esc_html_e( 'Política de Privacidade', 'iron-task' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'termos' ) ) ); ?>"><?php esc_html_e( 'Termos de Uso', 'iron-task' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contato' ) ) ); ?>"><?php esc_html_e( 'Fale Conosco', 'iron-task' ); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Coluna 4: Social & Newsletter -->
            <div class="footer__col">
                <h4 class="footer__heading"><?php esc_html_e( 'SIGA A ALCATEIA', 'iron-task' ); ?></h4>
                <div class="footer__social">
                    <a href="#" aria-label="Instagram" class="footer__social-link">
                        <svg viewBox="0 0 24 24" width="18" height="18">
                            <rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Twitter" class="footer__social-link">
                        <svg viewBox="0 0 24 24" width="18" height="18">
                            <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="TikTok" class="footer__social-link">
                        <svg viewBox="0 0 24 24" width="18" height="18">
                            <path d="M9 12a4 4 0 101 8a4 4 0 001-8M15 8v8a4 4 0 01-4 4M15 8V2h4l-2 6h2l-4 7V8h-1" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                    </a>
                </div>

                <h4 class="footer__heading footer__heading--newsletter"><?php esc_html_e( 'NEWSLETTER', 'iron-task' ); ?></h4>
                <form class="footer__newsletter" id="newsletter-form" method="post">
                    <input type="email" name="newsletter_email" placeholder="<?php esc_attr_e( 'Seu melhor e-mail', 'iron-task' ); ?>" class="footer__input" aria-label="<?php esc_attr_e( 'E-mail para newsletter', 'iron-task' ); ?>" required>
                    <button type="submit" class="footer__submit"><?php esc_html_e( 'INSCREVER', 'iron-task' ); ?></button>
                </form>
            </div>
        </div>

        <!-- Badges -->
        <div class="footer__badges">
            <span class="footer__badge">🔒 <?php esc_html_e( 'Compra Segura', 'iron-task' ); ?></span>
            <span class="footer__badge">🚚 <?php esc_html_e( 'Entrega Rápida', 'iron-task' ); ?></span>
            <span class="footer__badge">🔄 <?php esc_html_e( 'Troca Fácil', 'iron-task' ); ?></span>
        </div>
    </div>
</footer>

<!-- Toast Container -->
<div class="toast-container" id="toast-container" aria-live="polite"></div>

<?php wp_footer(); ?>
</body>
</html>
