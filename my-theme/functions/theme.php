<?php

/*

################################################## 

Redirect to the 404 page 

*/
function redirect_author_archive_to_home()
{
    if (is_author()) wp_redirect(esc_url(home_url('404')));
}
add_action('template_redirect', 'redirect_author_archive_to_home');


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

    $news_taxonomies = get_object_taxonomies('news');
    $portfolio_taxonomies = get_object_taxonomies('portfolio');

    if (is_tax($courses_taxonomies)) $template = locate_template('custom-post-type/news/archive.php');
    if (is_tax($jobs_taxonomies)) $template = locate_template('custom-post-type/portfolio/archive.php');

    return $template;

}
add_filter('taxonomy_template', 'taxonomy_archive_template');


/* 

################################################## 

Posts per page for archive.php and taxonomy.php

*/
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

Taxonomy term with the link to redirect to the corresponding term archive page
Usage example: the_taxonomy_term('portfolio');

You may also customize the taxonomy term by page type adding a if with to have multiple ways of how to display the design of:
if (is_post_type_archive('job'))
if (is_tax('profession'))
if (is_singular('job'))

*/
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

/* 

################################################## 

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
