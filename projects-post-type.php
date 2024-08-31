<?php

// Register Custom Post Type 'projects'
function create_custom_post_type()
{
    $args = [
        'labels' => [
            'name' => __('Projekti', 'textdomain'),
            'singular_name' => __('Projekts', 'textdomain'),
            'menu_name' => __('Projekti', 'textdomain'),
        ],
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'rewrite' => [
            'slug' => 'projects',
            'with_front' => false,
        ],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'taxonomies' => ['project_category'],
    ];
    register_post_type('projects', $args);
}
add_action('init', 'create_custom_post_type');

function project_category()
{
    $args = [
        'labels' => [
            'name' => __('Project Categories', 'textdomain'),
            'singular_name' => __('Project Category', 'textdomain'),
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => [
            'slug' => 'project-category',
            'with_front' => false,
        ],
    ];

    register_taxonomy('project_category', 'projects', $args);
}
add_action('init', 'project_category');

// Add Price and Image Group Meta Box to 'projects' Post Type
function add_meta_boxes_to_projects()
{
    add_meta_box(
        'price',
        __('Price', 'textdomain'),
        'display_price_meta_box',
        'projects',
        'side',
        'default'
    );

    add_meta_box(
        'image_carousel',
        __('Image Carousel', 'textdomain'),
        'display_image_carousel_meta_box',
        'projects',
        'normal',
        'default'
    );

    add_meta_box(
        'text_group_meta_box',
        __('Text Group', 'textdomain'),
        'display_text_group_meta_box',
        'projects',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_meta_boxes_to_projects');

// Display Price Meta Box HTML
function display_price_meta_box($post)
{
    $price = get_post_meta($post->ID, 'price', true);
    wp_nonce_field('save_price_meta', 'price_meta_nonce');
    echo '<input type="number" id="price_field" name="price" value="' . esc_attr($price) . '" />';
}

// Display Image Carousel Meta Box HTML
function display_image_carousel_meta_box($post)
{
    // Retrieve the existing image carousel
    $image_carousel = get_post_meta($post->ID, 'image_carousel', true);
    $image_carousel = is_array($image_carousel) ? $image_carousel : [];

    // Security nonce
    wp_nonce_field('save_image_carousel_meta', 'image_carousel_meta_nonce');

    // Button to open media library and select images
    echo '<label for="image_carousel_field">' . __('Upload or Select Images:', 'textdomain') . '<br> <small class="image-carousel-description">' . __('(Hover and click over image to delete)', 'textdomain') . '</small><br></label>';
    echo '<div id="image-group-wrapper">';

    // Display already selected images
    foreach ($image_carousel as $image_id) {
        $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
        echo '<div class="image-wrapper" data-id="' . esc_attr($image_id) . '">';
        echo '<img src="' . esc_url($image_url) . '"/>';
        echo '<button class="remove-image">&#10005;</button>';
        echo '</div>';
    }

    echo '</div>';
    echo '<input type="hidden" id="image_carousel_field" name="image_carousel" value="' . esc_attr(implode(',', $image_carousel)) . '" />';
    echo '<button id="upload_image_carousel_button" class="button">' . __('Select Images', 'textdomain') . '</button>';
    echo '<p>The images will be displayed at the top of the post.</p>'


        // Custom script to handle image selection
        ?>
    <script>
        jQuery(document).ready(function ($) {
            var imageGroupFrame;
            $('#upload_image_carousel_button').on('click', function (e) {
                e.preventDefault();
                if (imageGroupFrame) {
                    imageGroupFrame.open();
                    return;
                }
                imageGroupFrame = wp.media({
                    title: '<?php _e('Select Images', 'textdomain'); ?>',
                    button: { text: '<?php _e('Use these images', 'textdomain'); ?>' },
                    multiple: true
                });

                imageGroupFrame.on('select', function () {
                    var selection = imageGroupFrame.state().get('selection').toJSON();
                    var imageIDs = [];
                    $('#image-group-wrapper').html(''); // Clear current images

                    selection.forEach(function (image) {
                        var imageID = image.id;
                        var imageURL = image.sizes.thumbnail.url;
                        imageIDs.push(imageID);
                        $('#image-group-wrapper').append('<div class="image-wrapper" data-id="' + imageID + '">' +
                            '<img src="' + imageURL + '" />' +
                            '<button class="remove-image">&#10005;</button>' +
                            '</div>');
                    });

                    $('#image_carousel_field').val(imageIDs.join(',')); // Store image IDs in hidden field
                });

                imageGroupFrame.open();
            });

            // Remove selected image from group
            $('#image-group-wrapper').on('click', '.remove-image', function () {
                $(this).parent('.image-wrapper').remove();
                var imageIDs = [];
                $('#image-group-wrapper .image-wrapper').each(function () {
                    imageIDs.push($(this).data('id'));
                });
                $('#image_carousel_field').val(imageIDs.join(','));
            });
        });
    </script>
    <?php
}

// Display Text Group Meta Box HTML
function display_text_group_meta_box($post)
{
    // Retrieve the existing text group (array)
    $text_group = get_post_meta($post->ID, 'text_group', true);
    $text_group = is_array($text_group) ? $text_group : [];

    // Security nonce
    wp_nonce_field('save_text_group_meta', 'text_group_meta_nonce');

    // Output fields
    echo '<div id="text-group-wrapper">';

    if (!empty($text_group)) {
        foreach ($text_group as $index => $text) {
            echo '<div class="text-group-field" style="margin-bottom: 10px;">';
            echo '<input type="text" name="text_group[]" value="' . esc_attr($text) . '" style="width: 90%;" />';
            echo '<button class="remove-text-group button" style="color:red; cursor:pointer;">Remove</button>';
            echo '</div>';
        }
    }

    echo '</div>';
    echo '<button id="add_text_group_button" class="button">' . __('Add Text Field', 'textdomain') . '</button>';
    echo '<p>The text will be displayed in an unordered list next to the main content.</p>'

        // Custom script to handle adding/removing text fields
        ?>
    <script>
        jQuery(document).ready(function ($) {
            // Add new text field
            $('#add_text_group_button').on('click', function (e) {
                e.preventDefault();
                $('#text-group-wrapper').append(
                    '<div class="text-group-field" style="margin-bottom: 10px;">' +
                    '<input type="text" name="text_group[]" style="width: 90%;" />' +
                    '<button class="remove-text-group button" style="color:red; cursor:pointer;">Remove</button>' +
                    '</div>'
                );
            });

            // Remove text field
            $('#text-group-wrapper').on('click', '.remove-text-group', function (e) {
                e.preventDefault();
                $(this).parent('.text-group-field').remove();
            });
        });
    </script>
    <?php
}



// Save Price and Image Group Meta Box Data
function save_meta_box_data($post_id)
{
    // Verify nonce for price
    if (isset($_POST['price_meta_nonce']) && wp_verify_nonce($_POST['price_meta_nonce'], 'save_price_meta')) {
        if (isset($_POST['price'])) {
            update_post_meta($post_id, 'price', sanitize_text_field($_POST['price']));
        }
    }

    // Verify nonce for image group
    if (isset($_POST['image_carousel_meta_nonce']) && wp_verify_nonce($_POST['image_carousel_meta_nonce'], 'save_image_carousel_meta')) {
        if (isset($_POST['image_carousel'])) {
            $image_carousel = array_filter(explode(',', sanitize_text_field($_POST['image_carousel'])));
            update_post_meta($post_id, 'image_carousel', $image_carousel);
        }
    }

    // Verify nonce for text group
    if (isset($_POST['text_group_meta_nonce']) && wp_verify_nonce($_POST['text_group_meta_nonce'], 'save_text_group_meta')) {
        if (isset($_POST['text_group'])) {
            $text_group = array_map('sanitize_text_field', $_POST['text_group']);
            update_post_meta($post_id, 'text_group', $text_group);
        }
    }
}
add_action('save_post', 'save_meta_box_data');

function add_admin_css()
{
    wp_enqueue_style('realestate-admin-css', get_template_directory_uri() . '/assets/css/admin.css', [], '1.0', 'all');
}
add_action('admin_enqueue_scripts', 'add_admin_css');
