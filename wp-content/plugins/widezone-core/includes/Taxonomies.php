<?php
declare( strict_types=1 );

/**
 * Register taxonomies when missing.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class Taxonomies {
    /**
     * Register taxonomies.
     */
    public static function register(): void {
        static::register_region();
        static::register_horizon();
        static::register_audience();
    }

    protected static function register_region(): void {
        if ( taxonomy_exists( 'region' ) ) {
            return;
        }

        register_taxonomy(
            'region',
            [ 'project', 'office', 'resource' ],
            [
                'labels' => [
                    'name'          => __( 'Regions', 'widezone-core' ),
                    'singular_name' => __( 'Region', 'widezone-core' ),
                    'search_items'  => __( 'Search Regions', 'widezone-core' ),
                    'all_items'     => __( 'All Regions', 'widezone-core' ),
                    'edit_item'     => __( 'Edit Region', 'widezone-core' ),
                    'update_item'   => __( 'Update Region', 'widezone-core' ),
                    'add_new_item'  => __( 'Add New Region', 'widezone-core' ),
                    'new_item_name' => __( 'New Region Name', 'widezone-core' ),
                ],
                'hierarchical'      => true,
                'show_in_rest'      => true,
                'show_admin_column' => true,
                'rewrite'           => [ 'slug' => 'region' ],
            ]
        );
    }

    protected static function register_horizon(): void {
        if ( taxonomy_exists( 'horizon' ) ) {
            return;
        }

        register_taxonomy(
            'horizon',
            [ 'project' ],
            [
                'labels' => [
                    'name'          => __( 'Horizons', 'widezone-core' ),
                    'singular_name' => __( 'Horizon', 'widezone-core' ),
                    'search_items'  => __( 'Search Horizons', 'widezone-core' ),
                    'all_items'     => __( 'All Horizons', 'widezone-core' ),
                    'edit_item'     => __( 'Edit Horizon', 'widezone-core' ),
                    'update_item'   => __( 'Update Horizon', 'widezone-core' ),
                    'add_new_item'  => __( 'Add New Horizon', 'widezone-core' ),
                    'new_item_name' => __( 'New Horizon Name', 'widezone-core' ),
                ],
                'hierarchical'      => false,
                'show_in_rest'      => true,
                'show_admin_column' => true,
                'rewrite'           => [ 'slug' => 'horizon' ],
            ]
        );

        foreach ( [ 'Short', 'Mid', 'Long' ] as $term ) {
            if ( ! term_exists( $term, 'horizon' ) ) {
                wp_insert_term( $term, 'horizon' );
            }
        }
    }

    protected static function register_audience(): void {
        if ( taxonomy_exists( 'audience' ) ) {
            return;
        }

        register_taxonomy(
            'audience',
            [ 'resource' ],
            [
                'labels' => [
                    'name'          => __( 'Audiences', 'widezone-core' ),
                    'singular_name' => __( 'Audience', 'widezone-core' ),
                    'search_items'  => __( 'Search Audiences', 'widezone-core' ),
                    'all_items'     => __( 'All Audiences', 'widezone-core' ),
                    'edit_item'     => __( 'Edit Audience', 'widezone-core' ),
                    'add_new_item'  => __( 'Add New Audience', 'widezone-core' ),
                    'new_item_name' => __( 'New Audience Name', 'widezone-core' ),
                ],
                'hierarchical'      => false,
                'show_in_rest'      => true,
                'show_admin_column' => true,
            ]
        );

        $defaults = [ 'public', 'investor', 'partner' ];
        foreach ( $defaults as $term ) {
            if ( ! term_exists( $term, 'audience' ) ) {
                wp_insert_term( $term, 'audience' );
            }
        }
    }
}
