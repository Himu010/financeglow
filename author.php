<?php get_header(); 


/**
 * author Template
 *
 * This is the author template file in a WordPress theme. It is used to display a page 
 * when someone request to view author profile.
 *
 * @package financeGlow
 * @since 1.0
 * @version 1.4
 */




?>


<!-- Main Content Section with Correct ID for Skip Link -->
<div id="main-content">
<div class="container my-5">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="card p-3 mb-3 w-100">
                <h1 class="card-title text-center">
                    <?php echo esc_html(the_archive_title()); ?>
                </h1>
            </div>
        </div>
    </div>

    <!-- Author Avatar -->
    <div class="row">
        <div class="col-12">
            <div class="card p-3 mb-3 text-center w-100">
                <?php 
                    // Get the author's avatar with sanitization for attributes
                    echo get_avatar(
                        get_the_author_meta('ID'), 
                        150, 
                        '', 
                        '', 
                        array('class' => 'rounded-circle img-fluid')
                    );
                ?>
            </div>
        </div>
    </div>

    <!-- Author Name -->
    <div class="row">
        <div class="col-12">
            <div class="card p-3 mb-3 text-center w-100">
                <h2 class="card-title">
                    <?php echo esc_html(get_the_author_meta('display_name')); ?>
                </h2>
            </div>
        </div>
    </div>

    <!-- Author Bio -->
    <div class="row">
        <div class="col-12">
            <div class="card p-3 mb-3 w-100">
                <h3 class="card-title"><?php esc_html_e('About the Author', 'financeglow'); ?></h3>
                <p class="card-text">
                    <?php echo esc_html(get_the_author_meta('description')); ?>
                </p>
            </div>
        </div>
    </div>
</div>
</div>

<?php get_footer(); ?>
