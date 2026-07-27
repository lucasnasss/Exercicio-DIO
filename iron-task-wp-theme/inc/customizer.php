<?php
/**
 * Customizer Settings
 *
 * @package Iron_Task
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Adicionar seção personalizada ao Customizer
 */
function iron_task_customize_register( $wp_customize ) {
    // Seção Iron Task
    $wp_customize->add_section( 'iron_task_settings', array(
        'title'    => __( 'Configurações Iron Task', 'iron-task' ),
        'priority' => 30,
    ) );

    // Tema padrão (dark/light)
    $wp_customize->add_setting( 'iron_task_theme', array(
        'default'           => 'dark',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'iron_task_theme', array(
        'label'   => __( 'Tema Padrão', 'iron-task' ),
        'section' => 'iron_task_settings',
        'type'    => 'select',
        'choices' => array(
            'dark'   => __( 'Escuro', 'iron-task' ),
            'light'  => __( 'Claro', 'iron-task' ),
            'system' => __( 'Seguir sistema', 'iron-task' ),
        ),
    ) );

    // Mostrar/ocultar loader
    $wp_customize->add_setting( 'iron_task_show_loader', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );

    $wp_customize->add_control( 'iron_task_show_loader', array(
        'label'   => __( 'Mostrar tela de carregamento', 'iron-task' ),
        'section' => 'iron_task_settings',
        'type'    => 'checkbox',
    ) );

    // Texto do manifesto
    $wp_customize->add_setting( 'iron_task_manifesto_1', array(
        'default'           => '"Não é sobre chegar. É sobre continuar quando todos param."',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'iron_task_manifesto_1', array(
        'label'   => __( 'Frase do Manifesto 1', 'iron-task' ),
        'section' => 'iron_task_settings',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'iron_task_manifesto_2', array(
        'default'           => '"Forjado no fogo. Vestido com propósito."',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'iron_task_manifesto_2', array(
        'label'   => __( 'Frase do Manifesto 2', 'iron-task' ),
        'section' => 'iron_task_settings',
        'type'    => 'text',
    ) );

    // Cores personalizadas
    $wp_customize->add_setting( 'iron_task_accent_color', array(
        'default'           => '#C9A44B',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'iron_task_accent_color', array(
        'label'   => __( 'Cor de Destaque', 'iron-task' ),
        'section' => 'iron_task_settings',
    ) ) );
}
add_action( 'customize_register', 'iron_task_customize_register' );

/**
 * Output de CSS personalizado do Customizer
 */
function iron_task_customizer_css() {
    $accent_color = get_theme_mod( 'iron_task_accent_color', '#C9A44B' );
    
    if ( $accent_color !== '#C9A44B' ) {
        ?>
        <style>
            :root {
                --color-accent-primary: <?php echo esc_attr( $accent_color ); ?>;
            }
        </style>
        <?php
    }
}
add_action( 'wp_head', 'iron_task_customizer_css' );
