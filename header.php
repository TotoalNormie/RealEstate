<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <header>
            <div>

                <a href="/" class="logo">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    if (has_custom_logo()): ?>
                        <img src="<?= esc_url($logo[0]) ?>" alt="">
                    <?php endif; ?>

                </a>
            </div>
            <nav>
                <div class="desktop">
                    <?php
                    wp_nav_menu(array(
                        "menu" => "Header Menu",
                        "menu_class" => "header",
                    ));
                    ?>
                </div>
                <button class="mobile-menu-button" id="open-mobile-menu"><i class="ph ph-list"></i></button>
            </nav>
            <aside class="mobile-sidebar">
                <button class="mobile-menu-button" id="close-mobile-menu"><i class="ph ph-x"></i></button>
                <hr>
                <nav>
                    <?php
                    wp_nav_menu(array(
                        "menu" => "Header Menu",
                        "menu_class" => "header",
                    ));
                    ?>
                </nav>
            </aside>
        </header>