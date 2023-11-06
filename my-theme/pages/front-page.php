<h1>Front Page</h1>

<?php

  // Args for querying posts of the 'news' post type
  $args = array(
      'post_type'      => 'news',
      'posts_per_page' => 10,
  );

  // Create a new query object
  $query = new WP_Query($args);

?>

<!-- The Loop -->
<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
    <?php the_title(); ?>
<?php endwhile; endif; ?>

<?php
  // Reset post data when you're done with the custom query
  wp_reset_postdata();
?>
