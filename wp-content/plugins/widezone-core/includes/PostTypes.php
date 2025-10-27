<?php
declare( strict_types=1 );

/**
 * Register custom post types when missing.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class PostTypes {
    /**
     * Registers post types.
     */
    public static function register(): void {
        static::register_industry();
        static::register_project();
        static::register_insight();
        static::register_job();
        static::register_office();
        static::register_resource();
        static::register_application();
    }

    protected static function register_industry(): void {
        if ( post_type_exists( 'industry' ) ) {
            return;
        }

        register_post_type(
            'industry',
            [
                'labels' => [
                    'name'               => __( 'Industries', 'widezone-core' ),
                    'singular_name'      => __( 'Industry', 'widezone-core' ),
                    'add_new_item'       => __( 'Add New Industry', 'widezone-core' ),
                    'edit_item'          => __( 'Edit Industry', 'widezone-core' ),
                    'new_item'           => __( 'New Industry', 'widezone-core' ),
                    'view_item'          => __( 'View Industry', 'widezone-core' ),
                    'search_items'       => __( 'Search Industries', 'widezone-core' ),
                    'not_found'          => __( 'No industries found.', 'widezone-core' ),
                    'not_found_in_trash' => __( 'No industries found in Trash.', 'widezone-core' ),
                    'all_items'          => __( 'All Industries', 'widezone-core' ),
                ],
                'public'             => true,
                'show_in_rest'       => true,
                'has_archive'        => true,
                'menu_position'      => 20,
                'menu_icon'          => 'dashicons-portfolio',
                'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            ]
        );
    }

    protected static function register_project(): void {
        if ( post_type_exists( 'project' ) ) {
            return;
        }

        register_post_type(
            'project',
            [
                'labels' => [
                    'name'          => __( 'Projects', 'widezone-core' ),
                    'singular_name' => __( 'Project', 'widezone-core' ),
                    'add_new_item'  => __( 'Add New Project', 'widezone-core' ),
                    'edit_item'     => __( 'Edit Project', 'widezone-core' ),
                    'new_item'      => __( 'New Project', 'widezone-core' ),
                    'view_item'     => __( 'View Project', 'widezone-core' ),
                    'all_items'     => __( 'All Projects', 'widezone-core' ),
                ],
                'public'             => true,
                'show_in_rest'       => true,
                'has_archive'        => true,
                'menu_position'      => 21,
                'menu_icon'          => 'dashicons-chart-pie',
                'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
                'taxonomies'         => [ 'region', 'horizon' ],
            ]
        );
    }

    protected static function register_insight(): void {
        if ( post_type_exists( 'insight' ) ) {
            return;
        }

        register_post_type(
            'insight',
            [
                'labels' => [
                    'name'          => __( 'Insights', 'widezone-core' ),
                    'singular_name' => __( 'Insight', 'widezone-core' ),
                    'add_new_item'  => __( 'Add New Insight', 'widezone-core' ),
                    'edit_item'     => __( 'Edit Insight', 'widezone-core' ),
                    'new_item'      => __( 'New Insight', 'widezone-core' ),
                    'view_item'     => __( 'View Insight', 'widezone-core' ),
                    'all_items'     => __( 'All Insights', 'widezone-core' ),
                ],
                'public'             => true,
                'show_in_rest'       => true,
                'has_archive'        => true,
                'menu_position'      => 22,
                'menu_icon'          => 'dashicons-megaphone',
                'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments' ],
            ]
        );
    }

    protected static function register_job(): void {
        if ( post_type_exists( 'job' ) ) {
            return;
        }

        register_post_type(
            'job',
            [
                'labels' => [
                    'name'          => __( 'Jobs', 'widezone-core' ),
                    'singular_name' => __( 'Job', 'widezone-core' ),
                    'add_new_item'  => __( 'Add New Job', 'widezone-core' ),
                    'edit_item'     => __( 'Edit Job', 'widezone-core' ),
                    'new_item'      => __( 'New Job', 'widezone-core' ),
                    'view_item'     => __( 'View Job', 'widezone-core' ),
                    'all_items'     => __( 'All Jobs', 'widezone-core' ),
                ],
                'public'             => true,
                'show_in_rest'       => true,
                'has_archive'        => true,
                'menu_position'      => 23,
                'menu_icon'          => 'dashicons-groups',
                'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            ]
        );
    }

    protected static function register_office(): void {
        if ( post_type_exists( 'office' ) ) {
            return;
        }

        register_post_type(
            'office',
            [
                'labels' => [
                    'name'          => __( 'Offices', 'widezone-core' ),
                    'singular_name' => __( 'Office', 'widezone-core' ),
                    'add_new_item'  => __( 'Add New Office', 'widezone-core' ),
                    'edit_item'     => __( 'Edit Office', 'widezone-core' ),
                    'new_item'      => __( 'New Office', 'widezone-core' ),
                    'view_item'     => __( 'View Office', 'widezone-core' ),
                    'all_items'     => __( 'All Offices', 'widezone-core' ),
                ],
                'public'             => false,
                'show_ui'            => true,
                'show_in_rest'       => true,
                'has_archive'        => false,
                'menu_position'      => 24,
                'menu_icon'          => 'dashicons-building',
                'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            ]
        );
    }

    protected static function register_resource(): void {
        if ( post_type_exists( 'resource' ) ) {
            return;
        }

        register_post_type(
            'resource',
            [
                'labels' => [
                    'name'          => __( 'Resources', 'widezone-core' ),
                    'singular_name' => __( 'Resource', 'widezone-core' ),
                    'add_new_item'  => __( 'Add New Resource', 'widezone-core' ),
                    'edit_item'     => __( 'Edit Resource', 'widezone-core' ),
                    'new_item'      => __( 'New Resource', 'widezone-core' ),
                    'view_item'     => __( 'View Resource', 'widezone-core' ),
                    'all_items'     => __( 'All Resources', 'widezone-core' ),
                ],
                'public'             => true,
                'show_in_rest'       => true,
                'has_archive'        => true,
                'rewrite'            => [ 'slug' => 'resources' ],
                'menu_position'      => 25,
                'menu_icon'          => 'dashicons-lock',
                'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            ]
        );
    }

    protected static function register_application(): void {
        if ( post_type_exists( 'application' ) ) {
            return;
        }

        register_post_type(
            'application',
            [
                'labels' => [
                    'name'          => __( 'Applications', 'widezone-core' ),
                    'singular_name' => __( 'Application', 'widezone-core' ),
                ],
                'public'             => false,
                'show_ui'            => true,
                'show_in_menu'       => 'edit.php?post_type=job',
                'supports'           => [ 'title', 'editor', 'custom-fields' ],
                'capability_type'    => 'post',
                'map_meta_cap'       => true,
            ]
        );
    }
}
