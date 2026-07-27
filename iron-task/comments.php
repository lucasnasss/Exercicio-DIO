<?php
/**
 * Comments template
 *
 * Template para área de comentários
 *
 * @package Iron_Task
 * @since 1.0.0
 */

// Não carregar se o post estiver protegido por senha
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			if ( '1' === $comment_count ) {
				printf(
					/* translators: 1: título do post */
					esc_html__( 'Um comentário em &ldquo;%1$s&rdquo;', 'iron-task' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf(
					/* translators: 1: número de comentários, 2: título do post */
					esc_html( _nx( '%1$s comentário em &ldquo;%2$s&rdquo;', '%1$s comentários em &ldquo;%2$s&rdquo;', $comment_count, 'iron-task' ) ),
					number_format_i18n( $comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2>

		<ul class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ul',
					'short_ping'  => true,
					'avatar_size' => 50,
					'callback'    => null,
				)
			);
			?>
		</ul>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => '&larr; ' . __( 'Anterior', 'iron-task' ),
				'next_text' => __( 'Próxima', 'iron-task' ) . ' &rarr;',
			)
		);
		?>

		<?php if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php _e( 'Os comentários estão fechados.', 'iron-task' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_form'         => 'comment-form',
			'title_reply'        => __( 'Deixe um comentário', 'iron-task' ),
			'title_reply_to'     => __( 'Responder a %s', 'iron-task' ),
			'cancel_reply_link'  => __( 'Cancelar resposta', 'iron-task' ),
			'label_submit'       => __( 'ENVIAR COMENTÁRIO', 'iron-task' ),
			'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comentário', 'noun', 'iron-task' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required></textarea></p>',
			'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __( 'Seu endereço de e-mail não será publicado.', 'iron-task' ) . '</span>' . ( $req ? '<span class="required-field-message">' . __( 'Campos obrigatórios marcados com <span class="required">*</span>', 'iron-task' ) . '</span>' : '' ) . '</p>',
		)
	);
	?>
</div>
