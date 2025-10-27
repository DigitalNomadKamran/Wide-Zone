<?php
declare( strict_types=1 );

/**
 * Sitemap integration.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class Sitemaps {
    /**
     * Ensure custom post types appear in sitemaps.
     */
    public static function register(): void {
        if ( ! function_exists( 'wp_sitemaps_get_server' ) ) {
            return;
        }

        add_filter( 'wp_sitemaps_post_types', [ __CLASS__, 'include_post_types' ] );
    }

    /**
     * Add custom post types to sitemap list.
     */
    public static function include_post_types( array $post_types ): array {
        foreach ( [ 'project', 'job', 'resource' ] as $type ) {
            if ( post_type_exists( $type ) && ! isset( $post_types[ $type ] ) ) {
                $post_types[ $type ] = get_post_type_object( $type );
            }
        }

        return $post_types;
    }
}
