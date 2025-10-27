<?php
/**
 * Theme functions for Wide Zone.
 */

declare(strict_types=1);

add_action('after_setup_theme', function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style']);
    add_theme_support('editor-styles');
    add_editor_style(['style.css', 'assets/css/util.css']);
});

add_action('wp_enqueue_scripts', function (): void {
    wp_enqueue_style(
        'widezone-util',
        get_template_directory_uri() . '/assets/css/util.css',
        [],
        wp_get_theme()->get('Version')
    );
});

add_action('init', function (): void {
    widezone_register_taxonomies();
    widezone_register_post_types();
    widezone_register_post_meta();
    widezone_register_pattern_category();
    widezone_register_block_patterns();
});

/**
 * Register custom taxonomies.
 */
function widezone_register_taxonomies(): void
{
    register_taxonomy(
        'region',
        ['project'],
        [
            'label' => __('Regions', 'widezone'),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'rewrite' => ['slug' => 'region'],
        ]
    );

    register_taxonomy(
        'horizon',
        ['project'],
        [
            'label' => __('Horizons', 'widezone'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'rewrite' => ['slug' => 'horizon'],
        ]
    );
}

/**
 * Register custom post types.
 */
function widezone_register_post_types(): void
{
    register_post_type('industry', [
        'label' => __('Industries', 'widezone'),
        'labels' => [
            'name' => __('Industries', 'widezone'),
            'singular_name' => __('Industry', 'widezone'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-chart-pie',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite' => ['slug' => 'industries'],
    ]);

    register_post_type('project', [
        'label' => __('Projects', 'widezone'),
        'labels' => [
            'name' => __('Projects', 'widezone'),
            'singular_name' => __('Project', 'widezone'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'taxonomies' => ['region', 'horizon'],
        'rewrite' => ['slug' => 'projects'],
    ]);

    register_post_type('insight', [
        'label' => __('Insights', 'widezone'),
        'labels' => [
            'name' => __('Insights', 'widezone'),
            'singular_name' => __('Insight', 'widezone'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'menu_position' => 8,
        'menu_icon' => 'dashicons-lightbulb',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments'],
        'rewrite' => ['slug' => 'insights'],
    ]);

    register_post_type('job', [
        'label' => __('Jobs', 'widezone'),
        'labels' => [
            'name' => __('Jobs', 'widezone'),
            'singular_name' => __('Job', 'widezone'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'menu_position' => 9,
        'menu_icon' => 'dashicons-businessperson',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite' => ['slug' => 'careers'],
    ]);

    register_post_type('office', [
        'label' => __('Offices', 'widezone'),
        'labels' => [
            'name' => __('Offices', 'widezone'),
            'singular_name' => __('Office', 'widezone'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => false,
        'menu_position' => 10,
        'menu_icon' => 'dashicons-location-alt',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite' => ['slug' => 'offices'],
    ]);
}

/**
 * Register post meta fields.
 */
function widezone_register_post_meta(): void
{
    register_post_meta('industry', 'industry_icon_svg', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'wp_kses_post',
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('project', 'project_metrics', [
        'type' => 'object',
        'single' => true,
        'show_in_rest' => [
            'schema' => [
                'type' => 'object',
                'additionalProperties' => true,
            ],
        ],
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('project', 'project_industry', [
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint',
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('job', 'job_department', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('job', 'job_location', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('job', 'job_type', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('job', 'job_apply_url', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'esc_url_raw',
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('office', 'office_city', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('office', 'office_country', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('office', 'office_address', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'wp_kses_post',
        'auth_callback' => '__return_true',
    ]);

    register_post_meta('office', 'office_map_url', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'esc_url_raw',
        'auth_callback' => '__return_true',
    ]);
}

/**
 * Register the custom pattern category.
 */
function widezone_register_pattern_category(): void
{
    if (function_exists('register_block_pattern_category')) {
        register_block_pattern_category('wide-zone', [
            'label' => __('Wide Zone', 'widezone'),
        ]);
    }
}

/**
 * Load block patterns from the patterns directory.
 */
function widezone_register_block_patterns(): void
{
    if (!function_exists('register_block_pattern')) {
        return;
    }

    $pattern_files = glob(get_template_directory() . '/patterns/*.php');

    if (!$pattern_files) {
        return;
    }

    foreach ($pattern_files as $pattern_file) {
        $pattern = require $pattern_file;

        if (!is_array($pattern) || empty($pattern['title']) || empty($pattern['content'])) {
            continue;
        }

        register_block_pattern($pattern['name'] ?? sanitize_title($pattern['title']), $pattern);
    }
}

add_action('after_switch_theme', function (): void {
    if (function_exists('wp_insert_term')) {
        $terms = ['Short', 'Mid', 'Long'];
        foreach ($terms as $term) {
            if (!term_exists($term, 'horizon')) {
                wp_insert_term($term, 'horizon');
            }
        }
    }
});
