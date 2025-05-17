# LogoFly - WordPress Login Customizer

![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/logofly?style=flat-square)
![License](https://img.shields.io/badge/license-GPLv2%2B-blue.svg?style=flat-square)
![Tested WP Version](https://img.shields.io/badge/Tested%20up%20to-6.5-green.svg?style=flat-square)

Transform your WordPress login screen with pixel-perfect branding control. LogoFly replaces the default WordPress logo with your custom branding while offering precise sizing tools and smooth animations.

![LogoFly Admin Interface](https://github.com/nahiandev/LogoFly/blob/main/screenshots/settings-preview.png)

## ✨ Features

- **Custom Logo Upload**  
  Drag-and-drop interface with media library integration
- **Precision Sizing Tools**  
  - Width/Height controls (50-1000px range)
  - Aspect ratio locking
  - Real-time preview
- **Animation Effects**  
  Choose from 4 effects: None, Fade, Bounce, Spin
- **Mobile Responsive**  
  Automatic scaling for smaller screens
- **Developer Friendly**  
  - Clean object-oriented code
  - WP coding standards
  - Hooks for customization

## 🚀 Installation

1. Download the [latest release](https://github.com/nahiandev/LogoFly/releases)
2. Go to **WordPress Admin → Plugins → Add New → Upload Plugin**
3. Upload the `logofly.zip` file
4. Activate the plugin
5. Configure under **Settings → LogoFly**

## 🛠 Configuration

1. **Upload Your Logo**  
   Click the upload button to select from your media library
2. **Adjust Dimensions**  
   Set exact width/height or use aspect ratio locking
3. **Add Animations** (Optional)  
   Select from subtle motion effects
4. **Save Changes**  
   Instantly see results on your login screen

![Login Screen Customization](https://github.com/nahiandev/LogoFly/blob/main/screenshots/login-preview.png)

## 🧑‍💻 Developers

### Filters Available
```php
// Change default logo size
add_filter('logofly_default_width', function() { return 400; });
add_filter('logofly_default_height', function() { return 120; });

// Modify animation speed
add_filter('logofly_animation_duration', function() { return '5s'; });
```

### Actions Available
```php
// Add custom CSS to login page
add_action('logofly_login_head', function() {
    echo '<style>.login { background: #f0f0f0; }</style>';
});
```