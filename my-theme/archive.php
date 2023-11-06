<?php 

    get_header();

        // Remember to change permalink structure to /%postname%/ and remember to enable 'Has Archive' option for CPT to use the following method
        if (is_post_type_archive('news')) locate_template('custom-post-type/news/archive.php', true);
        if (is_post_type_archive('portfolio')) locate_template('custom-post-type/portfolio/archive.php', true);

    get_footer();

?>
