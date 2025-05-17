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

        $width = $options['logo_width'] ?? 320;
        $height = $options['logo_height'] ?? 80;
        $animation = $options['logo_animation'] ?? 'none';
        ?>
        <style type="text/css">
            #login h1 a {
                background-image: url(<?php echo esc_url($options['logo_url']); ?>) !important;
                background-size: contain !important;
                width: <?php echo absint($width); ?>px !important;
                height: <?php echo absint($height); ?>px !important;
                <?php echo $this->get_animation_css($animation); ?>
            }
            
            @media (max-width: 480px) {
                #login h1 a {
                    width: <?php echo absint($width * 0.8); ?>px !important;
                    height: <?php echo absint($height * 0.8); ?>px !important;
                }
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