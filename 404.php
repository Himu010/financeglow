<?php get_header(); 

/**
 * 404 Template
 *
 * This is the 404 template file in a WordPress theme. It is used to display a page 
 * when nothing not found.
 *
 * @package financeGlow
 * @since 1.0
 * @version 1.4
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



?>


<!-- Main Content Section with Correct ID for Skip Link -->
<div id="main-content">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card text-center p-4" style="
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 1.5rem;
                background-color: #fff;
            ">
                <div class="card-body">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/404-not-found.jpeg'); ?>"
                        alt="No Results Found" class="img-fluid no-results-image mb-3" style="
                        width: 150px;
                        height: 150px;
                        object-fit: cover;
                    ">
                    <h2 class="card-title" style="margin-bottom: 1rem;">Oops! 404 Error.</h2>
                    <p class="card-text" style="margin-bottom: 1.5rem;">We couldn't find the page you're looking for.
                        Try searching for something else.</p>


                    <a href="<?php echo esc_url(home_url()); ?>"
                        class="btn btn-secondary"><?php esc_html_e('Return to Home', 'financeglow'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php get_footer(); ?>