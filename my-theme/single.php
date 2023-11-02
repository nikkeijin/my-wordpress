<?php

    get_header();

        if (is_singular('news')) locate_template('custom-post-type/news/single.php', true);
        if (is_singular('portfolio')) locate_template('custom-post-type/portfolio/single.php', true);

    get_footer();

?>