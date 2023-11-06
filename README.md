# WordPress Base Template

This GitHub repository serves as a versatile base template for developing WordPress themes. While primarily created for personal use, it's open for anyone looking to kickstart their WordPress theme development. The theme is designed to provide a strong foundation for custom WordPress themes, making it easier to get started with web development.

## How to Use this Base Theme:

1. Clone or Download the Repository:

- To get started, clone this repository to your local environment using Git or download it as a ZIP file and extract it to your WordPress themes directory.


2. Theme Activation:

- Inside your WordPress installation directory, navigate to the "wp-content" folder.
- Within "wp-content," you'll find a folder called "themes." This is where you should place the theme folder. Your directory structure should look like this:
```
- wp-content
  - themes
    - my-theme (or your renamed theme folder)
      - (theme files and directories)
```

- In your WordPress admin dashboard, navigate to "Appearance" > "Themes."
- Activate the "my-theme" (or your renamed theme folder) from the list of available themes.


3. Customizing Title and Meta Tags:

- The theme provides a set of custom functions to dynamically generate title and meta tags for different pages. You can find these functions in the `functions/head.php` file. This is where you can define what each page should display in terms of titles and meta information.

`<?php custom_title(); ?>`      
This function generates a custom title tag based on the page type.

`<?php custom_meta(); ?>`       
Use this function to generate custom meta tags for better SEO.


4. CSS Styling:

- The `style.css` file in the root folder contains basic theme information and should be used for WordPress theme identification. 
- For your actual CSS styling, it's recommended to place your styles in the `assets/css/style.css` file. You can use this file to write your custom styles or include additional libraries such as `SCSS` or `Tailwind CSS`.


5. Page Templates:

- The theme includes several sample static pages such as `"about"`, `"service"`, and `"contact"`. These pages serve as a starting point and can be adjusted according to your specific project needs. You can customize these templates by editing the index.php file and changing or creating the file names inside the 'pages' folder.

- Important to mention `"front-page"` and `"404"` are part of the default WordPress structure and serve as the front page and error page templates, respectively. These templates can also be customized to align with your site's branding and content requirements.
    
index.php:
```php
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
```

front-page.php:
```php

// This code utilizes a custom WP_Query to retrieve and display up to 10 posts of the 'news' post type, distinct from the default loop used in WordPress template files such as archive.php.

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

```

6. Custom Post Types:

- If you plan to add or change custom post types, you can do so by editing the `archive.php` and `single.php` templates. These templates are used to display collections of custom post types (archive) and individual custom post type entries (single).
    
archive.php:
```php
<?php 

    // Remember to change permalink structure to /%postname%/ and remember to enable 'Has Archive' option for CPT to use the following method

    if (is_post_type_archive('news')) locate_template('custom-post-type/news/archive.php', true);
    if (is_post_type_archive('portfolio')) locate_template('custom-post-type/portfolio/archive.php', true);

?>
```
    
single.php:
```php
<?php

    get_header();

        if (is_singular('news')) locate_template('custom-post-type/news/single.php', true);
        if (is_singular('portfolio')) locate_template('custom-post-type/portfolio/single.php', true);

    get_footer();

?>
```

7. Search Functionality:

- To enhance WordPress default search functionality, consider installing the `"Search Everything"` plugin mentioned in `search.php`. This plugin enables you to search by custom post types and taxonomies."


8. Password Protection:

- You can protect specific pages with a password using HTTP Basic Authentication, as implemented in the code found in header.php. To secure certain pages, update the array with the appropriate `is_page('page-slug')`, `username`, and `password` for access. This method ensures that only authorized users with the correct credentials can view the protected content.

header.php:
```php
<?php

    if(is_page('secret')):
        $userArray = array(
            "username" => "password"
        );
        basic_auth($userArray);
    endif;

?>
```

9. Understanding the Functions Defined in functions.php:

- This file serves as the central hub for defining various functions and includes additional files, each with specific functions.

functions.php:
```php
<?php

    locate_template('functions/admin.php', true);
    locate_template('functions/security.php', true);
    locate_template('functions/head.php', true);
    locate_template('functions/theme.php', true);

```

admin.php:
- Removes the admin bar from the top of all pages.
- Removes the default post type for situations where you don't need a blog.
- Removes comments entirely from your site, including menu items and support for comments in posts and pages.
- Hides the CPT UI & ACF from the admin bar.

head.php:
- Enqueues CSS and JavaScript files for your theme.
- Adds the defer attribute to specified script tags for improved page loading performance.
- Defines functions for customizing the title and meta tags for different types of pages, including the `front-page`, `archive`, `singular`, and `static-pages`.

security.php:
- Enhances site security by protecting it from malicious requests, including those with excessively long URIs and potentially harmful keywords.
- Removes the WordPress version number from your site's headers to improve security.

theme.php:
- Modifies the template for `taxonomy archives` for specific custom post types.
```php

// Remember to Attach to Post Type * in your CPT UI Plugin if you are using such plugin

function taxonomy_archive_template($template = '')
{

    $courses_taxonomies = get_object_taxonomies('courses');
    $jobs_taxonomies = get_object_taxonomies('jobs');

    if (is_tax($courses_taxonomies)) $template = locate_template('custom-post-type/news/archive.php');
    if (is_tax($jobs_taxonomies)) $template = locate_template('custom-post-type/portfolio/archive.php');

    return $template;
}
add_filter('taxonomy_template', 'taxonomy_archive_template');

```
- Sets the number of posts per page for `archive.php` and `taxonomy.php` templates for specific custom post types.
```php

function archive_posts_per_page($query)
{
    if (is_admin() || !$query->is_main_query()) return;

    $post_types_to_modify = array(
        'news' => 10,
        'portfolio' => 12,
    );

    foreach ($post_types_to_modify as $post_type => $posts_per_page) {
        if (is_post_type_archive($post_type) || is_tax(get_object_taxonomies($post_type))) {
            $query->set('post_type', $post_type);
            $query->set('posts_per_page', $posts_per_page);
            return;
        }
    }
}
add_action('pre_get_posts', 'archive_posts_per_page');

```

- Display taxonomy terms with links for the current post.
```php

// Usage example: the_taxonomy_term('your_taxonomy');

function the_taxonomy_term($taxonomy) 
{
    $terms = get_the_terms(get_the_ID(), $taxonomy);
    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $term_link = get_term_link($term, $taxonomy);
            if (!is_wp_error( $term_link )) {
                echo '<a href="' . esc_url( $term_link ) . '">' . $term->name . '</a>';
            }
        }
    }
}

```

- Display the NAME of a specific taxonomy term for the current post.
```php

// Usage example: the_taxonomy_term_name('your_taxonomy');

function the_taxonomy_term_name($taxonomy)
{
    $terms = get_the_terms(get_the_ID(), $taxonomy);
    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $term_link = get_term_link($term, $taxonomy);
            if (!is_wp_error($term_link)) {
                echo $term->name;
            }
        }
    }
}

```

- Display the URL of a specific taxonomy term for the current post.
```php

// Usage example: the_taxonomy_term_url('your_taxonomy');

function the_taxonomy_term_url($taxonomy)
{
    $terms = get_the_terms(get_the_ID(), $taxonomy);
    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $term_link = get_term_link($term, $taxonomy);
            if (!is_wp_error($term_link)) {
                echo esc_url($term_link);
            }
        }
    }
}

```

- Get and return the NAME of a specific taxonomy term by its slug.
```php

// Usage example: get_specific_taxonomy_term_name('your_taxonomy', 'specific-term-slug');

function get_specific_taxonomy_term_name($taxonomy, $term_slug)

{
    $term = get_term_by('slug', $term_slug, $taxonomy);

    if ($term && !is_wp_error($term)) {
        echo $term->name;
    }
}

```

- Get and return the URL of a specific taxonomy term by its slug.
```php

// Usage example: get_specific_taxonomy_term_url('your_taxonomy', 'specific-term-slug');

function get_specific_taxonomy_term_url($taxonomy, $term_slug)
{
    $term = get_term_by('slug', $term_slug, $taxonomy);

    if ($term && !is_wp_error($term)) {
        $term_link = get_term_link($term, $taxonomy);

        if (!is_wp_error($term_link)) {
            echo esc_url($term_link);
        }
    }
}

```

For more functions and additional code snippets, please visit [here](https://github.com/nikkeijin/wordpress/tree/main/codes).

10. Extending Functionality with Plugins:

- Enhance your theme's capabilities by incorporating plugins.

- Explore a selection of recommended plugins [here](https://github.com/nikkeijin/wordpress/tree/main/plugins).


##### Consider this base theme as your canvas to create something extraordinary. Embrace its adaptability, and let your imagination run wild to craft a website that truly reflects your project's individuality!
