<?php get_header(); ?>

<main class="wider">
    <?php get_breadcrumb() ?>

    <div class="archive-header">
        <?php
        $title = get_the_archive_title();
        $titleTrimmed = preg_replace('/^Archives: /', '', $title);
        ?>
        <h1 class="archive-title"><?= $titleTrimmed ?></h1>
    </div>

    <form method="GET" action="" class="project-archive-filter">
        <button type="submit" name="all" value="1" <?= (isset($_GET['all']) && $_GET['all'] == 1) ? 'class="active"' : '' ?>>Visas</button>
        <?php
        $terms = get_terms('project_category');
        foreach ($terms as $term) { ?>
            <button type="submit" name="category" value="<?= $term->slug ?>" <?= (isset($_GET['category']) && $_GET['category'] == $term->slug) ? 'class="active"' : '' ?>><?= $term->name ?></button>
        <?php }
        ?>
        <button type="submit" name="no_category" value="1" <?= (isset($_GET['no_category']) && $_GET['no_category'] == 1) ? 'class="active"' : '' ?>>Citas</button>
    </form>

    <div class="project-archive-wrapper">
        <?php
        $args = [
            'post_type' => 'projects',
            'posts_per_page' => 6,
            'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
        ];

        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'project_category',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['category']),
                ]
            ];
        }

        if (isset($_GET['no_category']) && $_GET['no_category'] == 1) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'project_category',
                    'operator' => 'NOT EXISTS',
                ]
            ];
        }

        $query = new WP_Query($args);
        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post(); ?>
                <a href="<?php the_permalink(); ?>">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('project-archive-item'); ?>>
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'project_category');
                        $price = get_post_meta(get_the_ID(), 'price', true);


                        if (!empty($terms)) {
                            $category = implode(', ', wp_list_pluck($terms, 'name'));
                        } else {
                            $category = 'Cita';
                        }

                        $images = get_post_meta(get_the_ID(), 'image_carousel', true);
                        if (!empty($images)): ?>
                            <img class="border-radius-05" src="<?php echo wp_get_attachment_image_url($images[0], 'large'); ?>" />
                        <?php endif; ?>
                        <div>
                            <div>
                                <p class="gray"><?= $category; ?></p>
                                <h2><?php the_title(); ?></h2>
                                <p><?php the_excerpt(); ?></p>
                            </div>
                            <div class="price-wrapper">
                                <?php if (!empty($price)): ?>
                                    <p class="price">Cena: <strong><?= $price; ?> €</strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No projects found.</p>
        <?php endif;
        wp_reset_postdata(); ?>
    </div>

    <nav class="pagination">
        <?= paginate_links([
            'total' => $query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'format' => '?paged=%#%',
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'mid_size' => 2,
            'end_size' => 1,
            'prev_text' => __('« Previous', 'textdomain'),
            'next_text' => __('Next »', 'textdomain'),
            'add_args' => false,
        ]);
        ?>
    </nav>
</main>

<?php get_footer(); ?>