<?php

/* 

################################################## 

Return to home page if came from outside and return to previous page if came from WP

*/
function return_button()
{
    echo '<a href="' . (wp_get_referer() ? wp_get_referer() : esc_url(home_url())) . '">GO BACK</a>';
}


/* 

################################################## 

Avoid taxonomies loading the default archive.php
Remember to Attach to Post Type * in your CPT UI Plugin if you are using such plugin

*/
function taxonomy_archive_template($template = '')
{

    $courses_taxonomies = get_object_taxonomies('courses');
    $jobs_taxonomies = get_object_taxonomies('jobs');

    if (is_tax($courses_taxonomies)) $template = locate_template('custom-post-type/archive/courses.php');
    if (is_tax($jobs_taxonomies)) $template = locate_template('custom-post-type/archive/jobs.php');

    return $template;
}
add_filter('taxonomy_template', 'taxonomy_archive_template');


/* 

################################################## 

Custom Loop for author.php

*/
function custom_author_posts_query($query)
{
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    if (is_author()) {
        $author_id = get_queried_object_id();
        $query->set('post_type', 'portfolio');
        $query->set('author', $author_id);
        $query->set('posts_per_page', 5);
    }
}
add_action('pre_get_posts', 'custom_author_posts_query');


/* 

################################################## 

Pagination for default loop

*/
function custom_posts_per_page( $query )
{
    
    if ( is_admin() ) {
        return;
    }

    if ( $query->is_post_type_archive('news') ) set_query_var('posts_per_page', 10);
    if ( $query->is_post_type_archive('portfolio') ) set_query_var('posts_per_page', 5);

}
add_action( 'pre_get_posts', 'custom_posts_per_page' );


/* 

################################################## 

Clear the 'previous' and 'next' from the_posts_pagination function

*/
function custom_posts_pagination()
{
    the_posts_pagination(
        array(
            'prev_text' => '',
            'next_text' => '',
        )
    );
}


/* 

################################################## 

Display taxonomy term

Usage example: 
the_taxonomy_term_name('your_taxonomy');
get_specific_taxonomy_term_name('your_taxonomy', 'specific-term-slug');

*/
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

function get_specific_taxonomy_term_name($taxonomy, $term_slug)
{
    $term = get_term_by('slug', $term_slug, $taxonomy);

    if ($term && !is_wp_error($term)) {
        echo $term->name;
    }
}

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
