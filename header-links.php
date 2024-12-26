<style>
    
.links-section {
    background-color: #f8f9fa;
    padding: 10px 0;
}

.links-section .date-time {
    font-size: 16px;
}

.links-section .top-social-icon {
    font-size: 20px;
    margin: 0 10px;
    color: #333;
}


.links-section .top-social-icon:hover {
    color: #0073aa;
}

@media (max-width: 767px) {
    .links-section .date-time {
        font-size: 14px;
        text-align: center;
    }

    .links-section .social-icon {
        font-size: 18px;
        margin: 5px;
    }

    .links-section .col-md-9, .links-section .col-md-3 {
        text-align: center;
        margin-bottom: 10px;
    }
}
    
</style>


<div class="links-section">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Section: Date and Time -->
           <div class="col-md-9">
    <div class="date-time">
        <span class="icon-calendar"><i class="fas fa-calendar-alt"></i></span> 
        <span id="local-date"></span>
        <span class="icon-clock ml-3"><i class="fas fa-clock"></i></span> 
        <span id="local-time"></span>
    </div>


<script>
    // Function to update date and time dynamically
    function updateDateTime() {
        const now = new Date();
        
        // Format the date as "Month Day, Year" (e.g., December 26, 2024)
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const formattedDate = now.toLocaleDateString(undefined, options);
        
        // Format the time as "HH:mm:ss" (e.g., 14:23:45)
        const formattedTime = now.toLocaleTimeString(undefined, { hour12: false });

        // Update the DOM elements
        document.getElementById('local-date').textContent = formattedDate;
        document.getElementById('local-time').textContent = formattedTime;
    }

    // Update date and time immediately and set an interval for real-time updates
    updateDateTime();
    setInterval(updateDateTime, 1000); // Updates every second
</script>


            </div>

            <!-- Right Section: Social Media Icons -->
            <div class="col-md-3 text-right">
                <?php 
                $social_media_platforms = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
                foreach ($social_media_platforms as $platform):
                    $url = get_theme_mod("social_link_{$platform}");
                    if ($url): ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" class="top-social-icon <?php echo esc_attr($platform); ?>">
                            <?php echo wp_kses_post(get_social_icon($platform)); ?>
                        </a>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
function get_social_icon($platform) {
    $icons = [
        'facebook' => '<i class="fab fa-facebook-f"></i>',
        'twitter'  => '<i class="fab fa-twitter"></i>',
        'instagram'=> '<i class="fab fa-instagram"></i>',
        'linkedin' => '<i class="fab fa-linkedin-in"></i>',
        'youtube'  => '<i class="fab fa-youtube"></i>',
    ];
    return $icons[$platform] ?? '';
}
?>
