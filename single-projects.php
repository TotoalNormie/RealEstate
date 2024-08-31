<?php get_header() ?>
<main class="wider">
    <?php get_breadcrumb() ?>
    <article>

        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                <h2 class="post-title"><?php the_title(); ?></h2>
                <?php
                $terms = get_the_terms(get_the_ID(), 'project_category');
                $price = get_post_meta(get_the_ID(), 'price', true);

                if (!empty($terms)) {
                    $category = implode(', ', wp_list_pluck($terms, 'name'));
                } else {
                    $category = 'Cita';
                }
                $images = get_post_meta(get_the_ID(), 'image_carousel', true);
                $list = get_post_meta(get_the_ID(), 'text_group', true);
                if (!empty($images)): ?>
                    <section class="splide" class="border-radius-05"
                        data-splide='{"type":"loop","perPage":1,"focus":"center","gap":"1rem","width":"100%"}'>
                        <div class="splide__track border-radius-05">
                            <ul class="splide__list" class="border-radius-05">
                                <?php foreach ($images as $image): ?>
                                    <li class="splide__slide" class="border-radius-05">
                                        <img class="border-radius-05"
                                            src="<?php echo wp_get_attachment_image_url($image, 'large'); ?>" />
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </section>
                <?php endif; ?>
                <h3>Mājas tips:</h3>
                <p><?= $category; ?></p>
                <h3>Papildus informācija:</h3>
                <div class="columns">
                    <section><?php the_content(); ?></section>
                    <section>
                        <div>
                            <?php if (!empty($price)): ?>
                                <p class="price">Cena: <strong><?= $price; ?> €</strong></p>

                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if (!empty($list)): ?>
                                <ul>
                                    <?php foreach ($list as $text): ?>
                                        <li><?= $text; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

    </article>
</main>
<?php get_footer() ?>