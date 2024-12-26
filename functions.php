<?php

/**
 * functions Template
 *
 * This is the functions template file in a WordPress theme. It is used to load
 * all functionality
 *
 * @package financeGlow
 * @since 1.0
 * @version 1.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}








// functions.php
function financeglow_enqueue_styles() {
    // Enqueue Bootstrap CSS (bundled with the theme)
    wp_enqueue_style('financeglow-bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '6.6.2');

    // Enqueue FontAwesome (bundled with the theme)
    wp_enqueue_style('financeglow-fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '6.6.0');

    // Enqueue your main stylesheet
    wp_enqueue_style('financeglow-main-style', get_stylesheet_uri());

    // Enqueue jQuery (WordPress includes it by default)
    wp_enqueue_script('jquery');

    // Enqueue Popper.js for Bootstrap tooltips and popovers (bundled with the theme)
    wp_enqueue_script('financeglow-popper', get_template_directory_uri() . '/assets/js/popper.min.js', array('jquery'), '1.16.0', true);

    // Enqueue Bootstrap JS (bundled with the theme)
    wp_enqueue_script('financeglow-bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery', 'financeglow-popper'), '4.5.2', true);

    // Path to the script file in your theme directory
    $script_path = get_template_directory() . '/assets/js/script.js';

    // Enqueue the script, using filemtime() for cache busting (version)
    wp_enqueue_script(
        'financeglow-custom-js', // Handle name
        get_template_directory_uri() . '/assets/js/script.js', // Script URL
        array('jquery'), // Dependencies (e.g., jQuery)
        filemtime($script_path), // Cache busting version based on file modification time
        true // Load in footer
    );

    // Back to Top Button Script
    wp_add_inline_script('financeglow-custom-js', '
        document.getElementById("back-to-top").addEventListener("click", function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    ');

    // Localize the max pages variable
    wp_localize_script('financeglow-custom-js', 'maxPages', array('value' => (int) $GLOBALS['wp_query']->max_num_pages));
}
add_action('wp_enqueue_scripts', 'financeglow_enqueue_styles');



// Enqueue additional styles for templates
function theme_enqueue_styles()
{
    // Enqueue additional styles if a selected template exists
    if (get_option('selected_template')) {
        $selected_template = get_option('selected_template');
        wp_enqueue_style('template-style', esc_url(get_template_directory_uri() . '/templates/' . $selected_template));
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// Theme setup
function financeglow_theme_setup()
{
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'financeglow'), // Ensure consistent text domain
    ));

    // Add support for title tag
    add_theme_support('title-tag');

    // Add support for automatic feed links
    add_theme_support('automatic-feed-links');

    // Add support for HTML5 markup
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'caption', 'style', 'script'));

    // Add support for custom logo
    add_theme_support('custom-logo');

    // Add support for custom background
    add_theme_support('custom-background');

    // Add support for custom header
    add_theme_support('custom-header');
    
    //add wp_block style
     add_theme_support('wp-block-styles');
     
     //add responsive embed
     add_theme_support( 'responsive-embeds' );
     
     //support align wide
     add_theme_support( 'align-wide' );
     
     // Add support for title tag
     add_theme_support('title-tag');
     
     //add fav icon
     add_theme_support('site-icon');

     
     
    add_editor_style( 'assets/css/editor-style.css' ); // Adjust the path as necessary
    // Other theme supports...

}
add_action('after_setup_theme', 'financeglow_theme_setup');

// Enqueue comment-reply script if comments are open
function financeglow_enqueue_comment_reply() {
    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'financeglow_enqueue_comment_reply');


// Create default primary menu after switching theme
function financeglow_create_default_primary_menu() {
    // Create a new menu named "Primary Menu" (or any name you'd like)
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    // Create the menu if it doesn't exist
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Assign the new menu to the primary location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);

        // Optionally, create default pages (Home, About, Contact) if they don't exist
        $default_pages = array(
            'Home'    => esc_url(home_url('/')),
            'Sample Page'   => esc_url(home_url('/sample-page')),
            
        );

        // Add default links to the newly created menu
        foreach ($default_pages as $page_title => $page_url) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'   => $page_title,
                'menu-item-url'     => $page_url, // Link to a URL
                'menu-item-status'  => 'publish'  // Ensure the menu item is published
            ));
        }
    } else {
        // If the menu exists, assign it to the primary location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_exists->term_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_switch_theme', 'financeglow_create_default_primary_menu');


// Ensure theme supports post categories and tags
function add_category_and_tag_support()
{
    register_taxonomy_for_object_type('category', 'post'); // Add categories to posts
    register_taxonomy_for_object_type('post_tag', 'post'); // Add tags to posts
}
add_action('init', 'add_category_and_tag_support');

// Register sidebar widgets
function custom_theme_widgets_init()
{
    register_sidebar(array(
        'name' => __('Main Sidebar', 'financeglow'), // Ensure consistent text domain
        'id' => 'main-sidebar',
        'description' => __('Widgets in this area will be shown in the sidebar.', 'financeglow'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    // Additional Widget Areas
    register_sidebar(array(
        'name' => __('Home Sidebar Widget 1', 'financeglow'),
        'id' => 'bottom-widget-1',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Home Sidebar Widget 2', 'financeglow'),
        'id' => 'bottom-widget-2',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'custom_theme_widgets_init');





function financeglow_customize_register($wp_customize)
{
    // Add "Site Settings" Section
    $wp_customize->add_section('financeglow_site_settings', array(
        'title'       => __('Site Settings', 'financeglow'),
        'description' => __('Configure your site settings here.', 'financeglow'),
        'priority'    => 30,
    ));

   $wp_customize->add_setting(
    'show_date',
    array(
        'default'           => true,
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_boolean',
    )
);

$wp_customize->add_setting(
    'show_author',
    array(
        'default'           => true,
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_boolean',
    )
);

$wp_customize->add_setting(
    'show_category',
    array(
        'default'           => true,
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_boolean',
    )
);

/**
 * Sanitization callback for boolean values.
 *
 * @param mixed $value The value to sanitize.
 * @return bool The sanitized boolean value.
 */
function sanitize_boolean($value) {
    return (bool) $value; // Ensures the value is strictly true or false.
}


    $wp_customize->add_control('show_date', array(
        'type'    => 'checkbox',
        'label'   => __('Show Date', 'financeglow'),
        'section' => 'financeglow_site_settings',
    ));
    $wp_customize->add_control('show_author', array(
        'type'    => 'checkbox',
        'label'   => __('Show Author', 'financeglow'),
        'section' => 'financeglow_site_settings',
    ));
    $wp_customize->add_control('show_category', array(
        'type'    => 'checkbox',
        'label'   => __('Show Categories', 'financeglow'),
        'section' => 'financeglow_site_settings',
    ));


// Add settings and controls for each social media link
    $social_media_platforms = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
    foreach ($social_media_platforms as $platform) {
        $wp_customize->add_setting("social_link_{$platform}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("social_link_{$platform}", array(
            'label'   => ucfirst($platform) . ' URL',
            'section' => 'financeglow_site_settings',
            'type'    => 'url',
        ));
    }


    // Add About Us Setting
    $wp_customize->add_setting('site_description', array(
        'default'           => 'Write Your Site About from Customizer',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage', // Enables live preview (optional)
    ));

    // Add Control for About Us
    $wp_customize->add_control('site_description', array(
        'label'       => __('About Us', 'financeglow'),
        'section'     => 'financeglow_site_settings', // Use an existing section name
        'type'        => 'textarea',
        'description' => __('Write about your site here.','financeglow'),
    ));


   // Add Footer Text Setting to the Site Settings Section
    $wp_customize->add_setting('footer_text', array(
        'default'           => 'FinanceGlow.Net',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage', // Optional: Enables live preview
    ));

    // Add Control for Footer Text
    $wp_customize->add_control('footer_text', array(
        'label'       => __('Footer Text', 'financeglow'),
        'section'     => 'financeglow_site_settings', // Existing section name
        'type'        => 'text',
        'description' => __('Customize the footer copyright text.', 'financeglow'),
    ));
}
add_action('customize_register', 'financeglow_customize_register');

//live preview customizer

function financeglow_customize_preview_js() {
    wp_enqueue_script(
        'financeglow-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js', // Create this file
        array('customize-preview'),
        null,
        true
    );
}
add_action('customize_preview_init', 'financeglow_customize_preview_js');




// Track post views
function set_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count === '') {
        $count = 0;
        add_post_meta($postID, $count_key, '1', true);
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function track_post_views($post_id)
{
    if (!is_single())
        return;
    if (empty($post_id))
        $post_id = get_the_ID();
    set_post_views($post_id);
}
add_action('wp_head', 'track_post_views');

function exclude_admin_from_post_views($exclude)
{
    if (current_user_can('manage_options'))
        return true;
    return $exclude;
}
add_filter('wpb_exclude_post_views', 'exclude_admin_from_post_views');



// Add featured box when post
function add_featured_meta_box()
{
    add_meta_box(
        'featured_meta_box',
        esc_html__('Featured Post', 'financeglow'),
        'featured_meta_box_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_featured_meta_box');


function featured_meta_box_callback($post)
{
    wp_nonce_field('save_featured_meta_box', 'featured_meta_box_nonce');
    $is_featured = get_post_meta($post->ID, '_is_featured', true);
    ?>
<label for="featured_post_checkbox">
    <input type="checkbox" id="featured_post_checkbox" name="featured_post_checkbox" value="1"
        <?php checked($is_featured, '1'); ?> />
    <?php esc_html_e('Mark this post as Featured', 'financeglow'); ?>
</label>
<?php
}

function save_featured_meta_box_data($post_id)
{
    if (!isset($_POST['featured_meta_box_nonce']) || !wp_verify_nonce($_POST['featured_meta_box_nonce'], 'save_featured_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['featured_post_checkbox'])) {
        update_post_meta($post_id, '_is_featured', '1');
    } else {
        delete_post_meta($post_id, '_is_featured');
    }
}
add_action('save_post', 'save_featured_meta_box_data');



// Register sidebar
function financeglow_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', 'financeglow'),
        'id' => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'financeglow_widgets_init');

// Add header links
function add_header_links()
{
    get_template_part('links/header-links');
}
add_action('wp_head', 'add_header_links');

function register_footer_menu()
{
    register_nav_menu('footer', __('Footer Menu', 'financeglow'));
}
add_action('init', 'register_footer_menu');

// Automatically create "Filter Archive" page with custom template upon theme activation
function create_filter_archive_page()
{
    if (!get_page_by_path('filter-archive')) {
        $page_data = array(
            'post_title' => 'Filter Archive (Do not Delete)',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'filter-archive',
        );

        $page_id = wp_insert_post($page_data);
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'filter-archive-template.php');
        }
    }
}
add_action('after_switch_theme', 'create_filter_archive_page');

// Recreate the "Filter Archive" page if it's deleted
function recreate_filter_archive_page()
{
    // Using WP_Query to check if the "Filter Archive" page exists
    $args = array(
        'post_type'      => 'page',
        'title'          => 'Filter Archive',
        'post_status'    => 'publish',
        'posts_per_page' => 1, // We only need to check for a single page
    );
    
    $query = new WP_Query($args);

    // If the page doesn't exist, recreate it
    if (!$query->have_posts()) {
        create_filter_archive_page();
    }

    // Reset the query data
    wp_reset_postdata();
}
add_action('wp', 'recreate_filter_archive_page');






// Add arrow to menu items with submenu
function add_arrow_to_menu_items_with_submenu($items, $args)
{
    foreach ($items as &$item) {
        if (in_array('menu-item-has-children', $item->classes, true)) {
            // Add Font Awesome chevron down icon to items with submenus
            $item->title .= ' <span class="submenu-arrow"><i class="fas fa-chevron-down"></i></span>';
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'add_arrow_to_menu_items_with_submenu', 10, 2);

// Extra theme templates
function financeglow_theme_options_page()
{
    add_submenu_page(
        'themes.php', // Parent menu slug for Appearance menu
        __('Theme Templates', 'financeglow'), // Page title
        __('Theme Templates', 'financeglow'), // Menu title
        'manage_options', // Capability required to access
        'financeglow-options', // Menu slug
        'financeglow_options_page_html' // Callback function to display page content
    );
}
add_action('admin_menu', 'financeglow_theme_options_page');

function financeglow_options_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Check if the user has submitted the settings
    if (isset($_POST['financeglow_template_option'])) {
        update_option('financeglow_template_option', sanitize_text_field($_POST['financeglow_template_option']));
        echo '<div class="updated"><p>' . esc_html__('Settings saved!', 'financeglow') . '</p></div>';
    }

    $current_option = get_option('financeglow_template_option', 'style-one');
    $templates = [
        'default' => [
            'name' => __('Default Theme', 'financeglow'),
            'image' => esc_url(get_template_directory_uri() . '/assets/images/default-theme.png')
        ],
        'style-one' => [
            'name' => __('Style One', 'financeglow'),
            'image' => esc_url(get_template_directory_uri() . '/assets/images/style-one.png')
        ],
        'style-two' => [
            'name' => __('Style Two', 'financeglow'),
            'image' => esc_url(get_template_directory_uri() . '/assets/images/style-two.png')
        ],
        'style-three' => [
            'name' => __('Style Three', 'financeglow'),
            'image' => esc_url(get_template_directory_uri() . '/assets/images/style-three.png')
        ],
    ];
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Theme Templates', 'financeglow'); ?></h1>
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <?php foreach ($templates as $key => $template): ?>
                <div style="border: 1px solid #ccc; border-radius: 8px; padding: 10px; width: 200px; text-align: center;">
                    <img src="<?php echo esc_url($template['image']); ?>" alt="<?php echo esc_attr($template['name']); ?>"
                        style="width: 100%; border-radius: 5px;">
                    <h3><?php echo esc_html($template['name']); ?></h3>
                    <form method="POST" style="margin-top: 10px;">
                        <input type="hidden" name="financeglow_template_option" value="<?php echo esc_attr($key); ?>">
                        <input type="submit" value="<?php esc_attr_e('Activate', 'financeglow'); ?>"
                            class="button button-primary">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <style>
        .wrap h1 {
            text-align: center;
        }

        img {
            border-radius: 5px;
            max-height: 150px;
            object-fit: cover;
        }
    </style>
    <?php
}




// Security headers
function add_security_headers($headers)
{
    $headers['X-Content-Type-Options'] = 'nosniff';
    $headers['X-XSS-Protection'] = '1; mode=block';
    $headers['X-Frame-Options'] = 'DENY';
    return $headers;
}
add_filter('wp_headers', 'add_security_headers');



//register blcok style

function financeglow_enqueue_block_styles() {
    // Enqueue the style for both frontend and editor
    wp_enqueue_style('financeglow-block-styles', get_template_directory_uri() . '/assets/css/block-styles.css', [], '1.0');
}
add_action('enqueue_block_assets', 'financeglow_enqueue_block_styles');


// Register custom block styles for paragraphs, buttons, and images
function financeglow_register_block_styles() {
    // Custom Paragraph Block Style
    register_block_style(
        'core/paragraph',
        [
            'name'  => 'custom-paragraph-style',
            'label' => __('Custom Paragraph Style', 'financeglow'),
        ]
    );
    
    // Custom Button Block Style
    register_block_style(
        'core/button',
        [
            'name'  => 'custom-button-style',
            'label' => __('Custom Button Style', 'financeglow'),
        ]
    );

    // Custom Image Block Style
    register_block_style(
        'core/image',
        [
            'name'  => 'custom-image-style',
            'label' => __('Custom Image Style', 'financeglow'),
        ]
    );
}
add_action('init', 'financeglow_register_block_styles');

// register block pattern
// Include the block patterns file
require get_template_directory() . '/block-patterns.php';


function financeglow_excerpt_length($length) {
    return 20; // Set the excerpt length to 260 characters
}
add_filter('excerpt_length', 'financeglow_excerpt_length');

function financeglow_excerpt_more($more) {
    return '...'; // Set custom text or leave it as '...' for the read more link
}
add_filter('excerpt_more', 'financeglow_excerpt_more');


?>
