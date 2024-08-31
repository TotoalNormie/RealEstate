<?php get_header() ?>
<div>
    <?php if (have_posts()):
        while (have_posts()):
            the_post(); ?>
            <h2><?php the_title(); ?></h2>
            <div><?php the_content(); ?></div>
        <?php endwhile; else: ?>
        <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>

</div>
<?php get_footer() ?>