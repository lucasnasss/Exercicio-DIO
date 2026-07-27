<?php
/**
 * Sidebar template
 *
 * Template para sidebar padrão
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
