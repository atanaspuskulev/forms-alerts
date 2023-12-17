<?php

use JetBrains\PhpStorm\NoReturn;

class FormsAlert
{
    private static bool|null $instance = null;
    public static function instantiate(): void
    {
        if(!self::$instance) {
            self::init();
        }
    }

    public static function init(): void
    {
        self::$instance = true;

        add_action('login_enqueue_scripts', ['FormsAlert', 'loadFormsAlertResources']);
    }

    public static function loadFormsAlertResources(): void
    {
        wp_register_script('forms-alerts.js', plugin_dir_url( __FILE__ ) . 'js/forms-alerts.js', ['jquery'], '1.0');
        wp_enqueue_script('forms-alerts.js');
        wp_localize_script(
            'forms-alerts.js',
            'FormsAlert',
            [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'forms_alerts_ajax_nonce' => wp_create_nonce('forms_alerts_ajax_nonce')
            ]
        );
    }

    #[NoReturn] public static function handleLoginForm(): void
    {
        check_ajax_referer('forms_alerts_ajax_nonce', 'nonce');

        echo self::handleSession('loginAttempts');

        exit;
    }
    #[NoReturn] public static function handleRegisterForm(): void
    {
        check_ajax_referer('forms_alerts_ajax_nonce', 'nonce');

        echo self::handleSession('registerAttempts');

        exit;
    }

    #[NoReturn] private static function handleSession(string $sessionKey): int
    {
        if(!isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = 0;
        }

        $_SESSION[$sessionKey]++;

        return (int) $_SESSION[$sessionKey];
    }
}