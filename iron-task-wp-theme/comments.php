<?php
/**
 * Comments Template
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area reveal">
    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ( '1' === $comment_count ) {
                printf(
                    /* translators: 1: title. */
                    esc_html__( 'Um comentário em &ldquo;%1$s&rdquo;', 'iron-task' ),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html( _n( '%1$s comentário em &ldquo;%2$s&rdquo;', '%1$s comentários em &ldquo;%2$s&rdquo;', $comment_count, 'iron-task' ) ),
                    number_format_i18n( $comment_count ),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 50,
                'callback'   => 'iron_task_comment_callback',
            ) );
            ?>
        </ol>

        <?php
        the_comments_pagination( array(
            'prev_text' => '&larr; ' . esc_html__( 'Anteriores', 'iron-task' ),
            'next_text' => esc_html__( 'Próximos', 'iron-task' ) . ' &rarr;',
        ) );
        ?>

        <?php if ( ! comments_open() ) : ?>
            <p class="no-comments"><?php esc_html_e( 'Os comentários estão fechados.', 'iron-task' ); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    comment_form( array(
        'class_form'         => 'comment-form',
        'title_reply'        => __( 'Deixe um comentário', 'iron-task' ),
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h3>',
        'submit_button'      => '<button name="%1$s" type="submit" id="%2$s" class="btn btn--primary">%4$s</button>',
        'submit_field'       => '<div class="form-submit">%1$s %2$s</div>',
        'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comentário', 'noun', 'iron-task' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required></textarea></p>',
        'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __( 'Seu endereço de e-mail não será publicado.', 'iron-task' ) . '</span>' . ( $req ? $required_text : '' ) . '</p>',
    ) );
    ?>
</div>
