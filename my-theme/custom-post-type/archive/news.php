<?php get_header(); ?>

        <!-- The Loop -->
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <!-- post output, loop functions: the_title(), the_content(), etc -->
        <?php endwhile; else: ?>
        <!-- 404 -->
        <?php endif; wp_reset_postdata(); ?>
        
        <!-- pagination -->
        <?php the_posts_pagination(); ?>

<?php get_footer(); ?>