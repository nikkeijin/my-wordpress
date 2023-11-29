<?php get_header(); ?>

    <!--
        ################################################## 

        To use this template, you gotta disable the following code from your functions/theme.php: 
        add_action('template_redirect', 'redirect_author_archive_to_home');

    -->

    <!-- SETTINGS -->
    <?php $user_data = get_userdata($author); ?>
    <?php $author_avatar = get_avatar($user_data->ID); ?>

    <!-- PROFILE -->
    <?= $author_avatar ?>
    <hr />
    <?= $user_data->first_name ?>
    <hr />
    <?= $user_data->last_name ?>
    <hr />
    <?= $user_data->nickname ?>
    <hr />
    <?= $user_data->user_url ?>
    <hr />
    <?= $user_data->description ?>
    <hr />

  <!-- LOOP -->
  <?php while (have_posts()) : the_post(); ?>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      <hr />
  <?php endwhile; ?>
  <?php wp_reset_postdata(); ?>
  <?php the_posts_pagination(); ?>

<?php get_footer(); ?>
