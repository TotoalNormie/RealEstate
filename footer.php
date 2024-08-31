<footer>
    <div>
        <a href="/" class="logo">
            <?php
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if (has_custom_logo()): ?>
                <img src="<?= esc_url($logo[0]) ?>" alt="">
            <?php endif; ?>

        </a>
        <div class="content">
            <?php if (is_active_sidebar('footer')):
                dynamic_sidebar('footer');
            endif; ?>
        </div>
    </div>
    <img src="<" alt="">
</footer>
<?php wp_footer(); ?>
</body>

</html>