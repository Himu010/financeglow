<?php

/**
 * header Template
 *
 * This is the header template file in a WordPress theme. It is used to display a page 
 * when need to shown header.
 *
 * @package financeGlow
 * @since 1.0
 * @version 1.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



?>


<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Description (Tagline) -->
    <meta name="title" content="<?php bloginfo('name'); // Outputs the site title ?>">
    <meta name="description" content="<?php bloginfo('description'); ?>">
	

    <?php
    // Important for plugins to add meta data, scripts, etc.
    wp_head(); 
    ?>
</head>

<body <?php body_class(); ?>>
    <a href="#main-content" class="skip-link screen-reader-text">Skip to main content</a> <!-- Skip Link Updated -->
    
 




    <?php wp_body_open(); // Required for proper theme functionality ?>
    <?php get_template_part('header-links'); ?>

    <header class="site-header">
        <div class="header-container">
            <!-- Hamburger Menu for Mobile View -->
            <div class="mobile-menu-toggle">
                <span class="menu-icon">&#9776;</span> <!-- Hamburger icon -->
            </div>

          <!-- Site Logo or Title -->
<div class="site-logo">
    <?php if (has_custom_logo()) : ?>
        <!-- Display the custom logo -->
        <a href="<?php echo esc_url(home_url()); ?>">
            <img src="<?php echo esc_url(wp_get_attachment_url(get_theme_mod('custom_logo'))); ?>" 
                alt="<?php bloginfo('name'); ?> Logo" class="site-logo-img" />
        </a>
    <?php else : ?>
        <!-- Display the site title if no logo is set -->
        <h1 class="site-title">
            <a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a>
        </h1>
    <?php endif; ?>
</div>


            <!-- Navigation Menu (Center) -->
            <nav class="nav-menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'menu-list',
                ));
                ?>
            </nav>

            <!-- Search Box (Right) -->
            <div class="search-box">
                <?php get_search_form(); ?>
            </div>
        </div>

        <!-- Mobile Navigation Menu (Hidden by default, shown on click) -->
        <div class="mobile-nav-menu">
            <span class="mobile-nav-close">&times;</span> <!-- Close button -->
            <nav>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'mobile-menu-list',
                ));
                ?>
            </nav>
        </div>
    </header>
