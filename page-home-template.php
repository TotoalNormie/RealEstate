<?php
/*
Template Name: Home Template
*/

get_header();
?>

<div>
    <div class="tagline-wrapper">
        <div class="image-grid">
            <a href="<?= get_post_type_archive_link('projects') ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/1.jpg'); ?>" alt="image 1">
            </a>
            <a href="<?= get_post_type_archive_link('projects') ?>"><img
                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/2.jpg'); ?>" alt="image 2">
            </a>
            <a href="<?= get_post_type_archive_link('projects') ?>"><img
                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/3.jpg'); ?>" alt="image 3">
            </a>
            <a href="<?= get_post_type_archive_link('projects') ?>"><img
                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/4.jpg'); ?>" alt="image 4">
            </a>
        </div>
        <div class="tagline-container">
            <h1>
                <?php bloginfo('name'); ?>
            </h1>
            <p>Īss mājaslapas apraksts un vēl citi vārdi aprakstam lai pagarināt tekstu.</p>
            <div class="link-wrapper">
                <?php if (get_post_type_archive_link('projects')): ?>
                    <a class="primary" href="<?= get_post_type_archive_link('projects') ?>">Mūsu Projekti</a>
                <?php endif; ?>

                <?php if (get_page_by_path('about')): ?>
                    <a class="secondary" href="<?= home_url('/about') ?>">Par Mums</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="tagline-wrapper mobile">
        <div class="image-grid">
            <a href="<?= get_post_type_archive_link('projects') ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/1.jpg'); ?>" alt="image 1">
            </a>
            <a href="<?= get_post_type_archive_link('projects') ?>"><img
                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/2.jpg'); ?>" alt="image 2">
            </a>
        </div>
        <div class="tagline-container">
            <h1>
                <?php bloginfo('name'); ?>
            </h1>
            <p>Īss mājaslapas apraksts un vēl citi vārdi aprakstam lai pagarināt tekstu.</p>
            <div class="link-wrapper">
                <?php if (get_post_type_archive_link('projects')): ?>
                    <a class="primary" href="<?= get_post_type_archive_link('projects') ?>">Mūsu Projekti</a>
                <?php endif; ?>

                <?php if (get_page_by_path('about')): ?>
                    <a class="secondary" href="<?= home_url('/about') ?>">Par Mums</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="image-grid">
            <a href="<?= get_post_type_archive_link('projects') ?>"><img
                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/3.jpg'); ?>" alt="image 3">
            </a>
            <a href="<?= get_post_type_archive_link('projects') ?>"><img
                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/4.jpg'); ?>" alt="image 4">
            </a>
        </div>
    </div>
</div>
<main>
    <?php
    if (have_posts()):
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>
</div>

<?php
get_footer();
?>