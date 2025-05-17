<div class="wrap">
    <h1><?php esc_html_e('LogoFly Settings', 'logofly'); ?></h1>
    
    <!-- <div class="logofly-header">
        <h2><?php esc_html_e('Brand Your Login Screen', 'logofly'); ?></h2>
    </div> -->
    
    <form method="post" action="options.php">
        <?php
        settings_fields('logofly_settings');
        do_settings_sections('logofly');
        submit_button(__('Save Changes', 'logofly'));
        ?>
    </form>
</div>