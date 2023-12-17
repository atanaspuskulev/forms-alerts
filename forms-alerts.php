<?php
/**
 * Plugin Name: Forms Alerts
 * Description: This plugin overrides with alerts Login and Registration forms.
 * Version: 1.0
 * Require: PHP >= 8.0
 * Author: Atanas Pyuskyulev
 */
if(!session_id()) {
    session_start();
}

require_once plugin_dir_path(__FILE__) . 'FormsAlert.php';

add_action('init', ['FormsAlert', 'instantiate']);
add_action('wp_ajax_handle_loginform', ['FormsAlert', 'handleLoginForm']);
add_action('wp_ajax_nopriv_handle_loginform', ['FormsAlert', 'handleLoginForm']);
add_action('wp_ajax_handle_registerform', ['FormsAlert', 'handleLoginForm']);
add_action('wp_ajax_nopriv_handle_registerform', ['FormsAlert', 'handleRegisterForm']);

function forms_information() {
    if(isset($_SESSION['loginAttempts']) || isset($_SESSION['registerAttempts'])) {
        if(!isset($_GET['action']) && !empty($_SESSION['loginAttempts'])) {
            echo '<div class="forms-information">
                <p>Login Attempts: ' . (int) $_SESSION['loginAttempts'] . '</p>
              </div>';
        }

        if(isset($_GET['action']) && $_GET['action'] === 'register' && !empty($_SESSION['registerAttempts'])) {
            echo '<div class="forms-information">
                <p>Register Attempts: ' . (int) $_SESSION['registerAttempts'] . '</p>
              </div>';
        }
    }

}

add_filter('login_message', 'forms_information');
