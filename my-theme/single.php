<?php

    get_header();

        if (is_singular('news')) locate_template('custom-post-type/single/news.php', true);
        if (is_singular('portfolio')) locate_template('custom-post-type/single/portfolio.php', true);

    get_footer();

?>