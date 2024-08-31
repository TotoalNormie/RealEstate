<?php

include 'projects-post-type.php';
function realestate_setup()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    register_nav_menus([
        'header-menu' => 'Header Menu',
    ]);
}
add_action('after_setup_theme', 'realestate_setup');

function realestate_regiter_styles()
{
    wp_enqueue_style('realestate-style', get_template_directory_uri() . '/style.css', [], wp_get_theme()->get('Version'), 'all');
    wp_enqueue_style('splide-css', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css', [], '4.1.4', 'all');
    wp_enqueue_style('realestate-home', get_template_directory_uri() . '/assets/css/home.css', ['realestate-style'], '1.0', 'all');
    wp_enqueue_style('realestate-header', get_template_directory_uri() . '/assets/css/header.css', ['realestate-style'], '1.0', 'all');
    wp_enqueue_style('realestate-footer', get_template_directory_uri() . '/assets/css/footer.css', ['realestate-style'], '1.0', 'all');

}

add_action('wp_enqueue_scripts', 'realestate_regiter_styles');
function realestate_enqueue_scripts()
{
    wp_enqueue_script('phosphor-icons', 'https://unpkg.com/@phosphor-icons/web@2.1.1/src/index.js', [], '2.2.1', true);
    wp_enqueue_script('splide-js', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js', [], '4.1.4', true);
    wp_enqueue_script('realestate-splide-init', get_template_directory_uri() . '/assets/js/splide-init.js', [], '1.0', true);
    wp_enqueue_script('mobile-js', get_template_directory_uri() . '/assets/js/mobile.js', ['splide-js'], '1.0', true);
}
add_action('wp_enqueue_scripts', 'realestate_enqueue_scripts');


function realestate_widgets_init()
{
    register_sidebar(array(
        'name' => 'Footer Widget',
        'id' => 'footer',
        'description' => "Widget in footer",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'realestate_widgets_init');

function get_breadcrumb()
{
    if (!is_home()) {
        echo "<a href='" . get_bloginfo('url') . "'>Galvenā lapa</a> &#187;&nbsp;&nbsp;";
    }
    if (is_archive()) {
        echo wp_kses(
            strip_tags(str_replace('Archives: ', '', get_the_archive_title())),
            ['span' => ['class' => []]]
        );
    }
    if (is_category() || is_single() || is_post_type_archive()) {
        if (is_category()) {
            the_category(' &bull;&nbsp;&nbsp;');
        }
        if (is_single()) {
            if (get_post_type() != 'post') {
                echo "<a href='" . get_post_type_archive_link(get_post_type()) . "'>" . get_post_type() . "</a>";
            }
            echo " &#187;&nbsp;&nbsp;";
            the_title();
        }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}

// function filter_custom_posts_query($query)
// {
//     if (is_admin() || !$query->is_main_query())
//         return;
//     // Ensure we are querying the custom post type 'projects'
//     if (is_post_type_archive('projects') || is_tax('post_tag')) {
//         // Handle the "Other" button (posts without tags)
//         if (isset($_GET['no_tag']) && $_GET['no_tag'] == 1) {
//             // Query for posts without tags
//             $query->set('tax_query', array(
//                 array(
//                     'taxonomy' => 'post_tag',
//                     'operator' => 'NOT EXISTS', // Fetch posts with no tags
//                 ),
//             ));
//         } elseif (isset($_GET['tag']) && !empty($_GET['tag'])) {
//             // Query for posts with the selected tag in the custom post type
//             $query->set('tax_query', array(
//                 array(
//                     'taxonomy' => 'post_tag',
//                     'field' => 'term_id',
//                     'terms' => $_GET['tag'], // Filter posts by the tag ID
//                 ),
//             ));
//         }

//         // Also make sure the post type is set to 'projects'
//         $query->set('post_type', 'projects');
//     }
// }
// add_action('pre_get_posts', 'filter_custom_posts_query');


