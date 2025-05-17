<?php
/*
Plugin Name: LogoFly
Description: Premium WordPress login customizer with logo resizing and animations.
Version: 1.0.0
Author: Ibne Nahian(@nahiandev)
Author URI: https://github.com/nahiandev
Text Domain: logofly
Plugin URI: https://github.com/nahiandev/LogoFly
*/


defined('ABSPATH') || exit;

// Define plugin constants
define('LOGOFLY_VERSION', '1.1.0');
define('LOGOFLY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LOGOFLY_PLUGIN_URL', plugin_dir_url(__FILE__));

// Autoload classes
spl_autoload_register(function ($class) {
    if (strpos($class, 'LogoFly\\') === 0) {
        $class = str_replace('LogoFly\\', '', $class);
        require_once LOGOFLY_PLUGIN_DIR . 'includes/class-' . strtolower(str_replace('_', '-', $class)) . '.php';
    }
});

// Initialize plugin
add_action('plugins_loaded', function() {
    new LogoFly\Settings();
    new LogoFly\Login_Modifier();
});