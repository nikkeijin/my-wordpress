<!--

Install Search Everything plugin to add Custom Post Type, Custom Taxonomy and such into the WordPress default search function, so you will be able to search by:
https://example.com/?s=KEYWORD

Search Everything Plugin:
https://wordpress.org/plugins/search-everything/

-->

<!-- Get the searchform.php -->
<?php get_search_form(); ?>

<!-- The loop to display the search results -->
<?php if (have_posts()): ?>

<?php
  if (isset($_GET['s']) && empty($_GET['s'])) {

    echo 'Enter a KEYWORD to search!';

  } else {

    echo 'You are searching for: "' . $_GET['s'] . '".<br>
    Found: "' . $wp_query->found_posts . '" articles!';

  }
?>

<ul>
  <?php while(have_posts()): the_post(); ?>
  <li>
    <a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
  </li>
  <?php endwhile; ?>
</ul>

<?php else: ?>
  <p>There were no articles matching the searched KEYWORD...</p>
<?php endif; ?>
