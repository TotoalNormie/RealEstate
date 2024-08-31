<?php get_header() ?>
<main class="wider">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php get_footer() ?>