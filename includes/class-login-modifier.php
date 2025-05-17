<?php
namespace LogoFly;

class Login_Modifier {
    public function __construct() {
        add_action('login_enqueue_scripts', [$this, 'customize_login']);
        add_filter('login_headerurl', [$this, 'custom_login_url']);
        add_filter('login_headertext', [$this, 'custom_login_title']);
    }

    public function customize_login() {
        $options = get_option('logofly_options');
        if (empty($options['logo_url'])) return;

        $animation = $options['logo_animation'] ?? 'none';
        ?>
        <style type="text/css">
            #login h1 a {
                background-image: url(<?php echo esc_url($options['logo_url']); ?>) !important;
                background-size: contain !important;
                width: 320px !important;
                height: 80px !important;
                <?php echo $this->get_animation_css($animation); ?>
            }
        </style>
        <?php
    }

    private function get_animation_css($effect) {
        switch ($effect) {
            case 'fade':
                return 'animation: logofly-fade 2s infinite alternate;';
            case 'bounce':
                return 'animation: logofly-bounce 1s infinite alternate;';
            case 'spin':
                return 'animation: logofly-spin 3s linear infinite;';
            default:
                return '';
        }
    }

    public function custom_login_url() {
        return home_url();
    }

    public function custom_login_title() {
        return get_bloginfo('name');
    }
}