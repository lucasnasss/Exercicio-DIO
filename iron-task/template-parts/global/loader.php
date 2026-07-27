<?php
/**
 * Template part: Loader Animation
 *
 * Exibe animação de carregamento inicial
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

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
