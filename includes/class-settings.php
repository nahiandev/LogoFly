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
            __('Logo Image', 'logofly'),
            [$this, 'render_logo_field'],
            'logofly',
            'logofly_main'
        );

        add_settings_field(
            'logo_size',
            __('Logo Dimensions', 'logofly'),
            [$this, 'render_size_fields'],
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
                <img src="<?php echo esc_url($options['logo_url']); ?>" 
                     style="max-width: 100%; height: auto;">
            <?php endif; ?>
        </div>
        <input type="text" name="logofly_options[logo_url]" 
               value="<?php echo esc_attr($options['logo_url'] ?? ''); ?>" 
               class="regular-text logofly-logo-url">
        <button type="button" class="button logofly-upload">
            <?php esc_html_e('Upload Logo', 'logofly'); ?>
        </button>
        <?php
    }

    public function render_size_fields() {
        $options = get_option('logofly_options');
        ?>
        <div class="logofly-size-fields">
            <div>
                <label><?php esc_html_e('Width (px)', 'logofly'); ?></label>
                <input type="number" name="logofly_options[logo_width]" 
                       value="<?php echo esc_attr($options['logo_width'] ?? 320); ?>"
                       min="50" max="1000" step="1">
            </div>
            <div>
                <label><?php esc_html_e('Height (px)', 'logofly'); ?></label>
                <input type="number" name="logofly_options[logo_height]" 
                       value="<?php echo esc_attr($options['logo_height'] ?? 80); ?>"
                       min="20" max="500" step="1">
            </div>
            <div>
                <label>
                    <input type="checkbox" name="logofly_options[lock_aspect]" 
                           <?php checked($options['lock_aspect'] ?? true); ?>>
                    <?php esc_html_e('Lock aspect ratio', 'logofly'); ?>
                </label>
            </div>
        </div>
        <?php
    }

    public function render_animation_field() {
        $options = get_option('logofly_options');
        $effects = ['none' => 'None', 'fade' => 'Fade', 'bounce' => 'Bounce', 'spin' => 'Spin'];
        ?>
        <select name="logofly_options[logo_animation]">
            <?php foreach ($effects as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" 
                    <?php selected($options['logo_animation'] ?? 'none', $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('LogoFly Settings', 'logofly'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('logofly_settings');
                do_settings_sections('logofly');
                submit_button();
                ?>
            </form>
        </div>
        <?php
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
        
        if (isset($input['logo_width'])) {
            $output['logo_width'] = absint($input['logo_width']);
        }
        
        if (isset($input['logo_height'])) {
            $output['logo_height'] = absint($input['logo_height']);
        }
        
        if (isset($input['lock_aspect'])) {
            $output['lock_aspect'] = (bool)$input['lock_aspect'];
        }
        
        if (isset($input['logo_animation'])) {
            $output['logo_animation'] = sanitize_key($input['logo_animation']);
        }
        
        return $output;
    }
}