<?php

    get_header();

        if (is_front_page()) locate_template('pages/front-page.php', true);
        if (is_404()) locate_template('pages/404.php', true);

        $is_page = [
            "about" => "pages/about.php",
            "service" => "pages/service.php",
            "contact" => "pages/contact.php",
        ];

        foreach($is_page as $page_name => $dir ){
          if(is_page($page_name)) locate_template($dir, true);
        }

    get_footer();

?>