<?php get_header(); ?>

<div class="archive-page">
    <header class="archive-header">
        <h1><?php the_archive_title(); ?></h1>
        <p><?php the_archive_description(); ?></p>
    </header>

    <?php if (have_posts()): ?>
        <div class="post-list">
            <?php while (have_posts()):
                the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <nav class="pagination">
            <?php
            the_posts_pagination([
                'mid_size' => 2,
                'prev_text' => __('« Previous', 'textdomain'),
                'next_text' => __('Next »', 'textdomain'),
            ]);
            ?>
        </nav>

    <?php else: ?>
        <p><?php _e('No posts found.', 'textdomain'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>