<?php
namespace LogoFly;

class Settings {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function add_menu() {
        add_options_page(
            __('LogoFly Settings', 'logofly'),
            __('LogoFly', 'logofly'),
            'manage_options',
            'logofly',
            [$this, 'render_settings_page']
        );
    }

    public function register_settings() {
        register_setting('logofly_settings', 'logofly_options', [
            'sanitize_callback' => [$this, 'sanitize_options']
        ]);

        add_settings_section(
            'logofly_main',
            __('Branding Settings', 'logofly'),
            null,
            'logofly'
        );

        add_settings_field(
            'logo_url',
            __('Main Logo', 'logofly'),
            [$this, 'render_logo_field'],
            'logofly',
            'logofly_main'
        );

        add_settings_field(
            'logo_animation',
            __('Animation Effect', 'logofly'),
            [$this, 'render_animation_field'],
            'logofly',
            'logofly_main'
        );
    }

    public function render_logo_field() {
        $options = get_option('logofly_options');
        ?>
        <div class="logofly-preview">
            <?php if (!empty($options['logo_url'])) : ?>
                <img src="<?php echo esc_url($options['logo_url']); ?>" style="max-height: 80px;">
            <?php endif; ?>
        </div>
        <input type="text" name="logofly_options[logo_url]" 
               value="<?php echo esc_attr($options['logo_url'] ?? ''); ?>" 
               class="regular-text logofly-logo-url">
        <button type="button" class="button logofly-upload"><?php esc_html_e('Upload Logo', 'logofly'); ?></button>
        <?php
    }

    public function render_animation_field() {
        $options = get_option('logofly_options');
        $effects = ['none', 'fade', 'bounce', 'spin'];
        ?>
        <select name="logofly_options[logo_animation]">
            <?php foreach ($effects as $effect) : ?>
                <option value="<?php echo esc_attr($effect); ?>" 
                    <?php selected($options['logo_animation'] ?? '', $effect); ?>>
                    <?php echo esc_html(ucfirst($effect)); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function render_settings_page() {
        require_once LOGOFLY_PLUGIN_DIR . 'templates/admin-settings.php';
    }

    public function enqueue_assets($hook) {
        if ('settings_page_logofly' !== $hook) return;

        wp_enqueue_media();
        wp_enqueue_style('logofly-admin', LOGOFLY_PLUGIN_URL . 'assets/css/admin.css');
        wp_enqueue_script('logofly-admin', LOGOFLY_PLUGIN_URL . 'assets/js/admin.js', ['jquery'], LOGOFLY_VERSION, true);
    }

    public function sanitize_options($input) {
        $output = [];
        
        if (isset($input['logo_url'])) {
            $output['logo_url'] = esc_url_raw($input['logo_url']);
        }
        
        if (isset($input['logo_animation'])) {
            $output['logo_animation'] = sanitize_text_field($input['logo_animation']);
        }
        
        return $output;
    }
}