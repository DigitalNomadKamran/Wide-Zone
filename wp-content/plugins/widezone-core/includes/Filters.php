<?php
declare( strict_types=1 );

/**
 * Query filters and helpers.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class Filters {
    /**
     * Register general filters.
     */
    public static function register_filters(): void {
        add_filter( 'query_vars', [ __CLASS__, 'add_query_vars' ] );
        add_action( 'pre_get_posts', [ __CLASS__, 'apply_project_filters' ] );
    }

    /**
     * Register query variables used for filters.
     */
    public static function register_post_filters(): void {
        add_filter( 'request', [ __CLASS__, 'inject_pretty_filters' ] );
    }

    /**
     * Register rewrite tags.
     */
    public static function register_rewrite_tags(): void {
        add_rewrite_tag( '%wz_region%', '([^/]+)' );
        add_rewrite_tag( '%wz_horizon%', '([^/]+)' );
        add_rewrite_tag( '%wz_industry%', '([^/]+)' );
    }

    /**
     * Register rewrite rules for pretty portfolio filters.
     */
    public static function add_rewrite_rules(): void {
        add_rewrite_rule(
            '^portfolio(?:/region/([^/]+))?(?:/horizon/([^/]+))?(?:/industry/([^/]+))?/?$',
            'index.php?post_type=project&wz_region=$matches[1]&wz_horizon=$matches[2]&wz_industry=$matches[3]',
            'top'
        );
    }

    /**
     * Add custom query vars.
     */
    public static function add_query_vars( array $vars ): array {
        $vars[] = 'wz_region';
        $vars[] = 'wz_horizon';
        $vars[] = 'wz_industry';

        return $vars;
    }

    /**
     * Map pretty filter vars to query vars.
     */
    public static function inject_pretty_filters( array $query ): array {
        if ( isset( $query['post_type'] ) && 'project' === $query['post_type'] ) {
            foreach ( [ 'wz_region', 'wz_horizon', 'wz_industry' ] as $key ) {
                $rewrite_key = sprintf( '%%%s%%', $key );
                if ( empty( $query[ $key ] ) && isset( $query[ $rewrite_key ] ) ) {
                    $query[ $key ] = $query[ $rewrite_key ];
                }
            }
        }

        return $query;
    }

    /**
     * Apply taxonomy filters on the project archive.
     */
    public static function apply_project_filters( $query ): void {
        if ( ! ( $query->is_main_query() && ! is_admin() ) ) {
            return;
        }

        if ( $query->is_post_type_archive( 'project' ) ) {
            $tax_query = [];

            $region = $query->get( 'wz_region' );
            $horizon = $query->get( 'wz_horizon' );
            $industry = $query->get( 'wz_industry' );

            if ( $region ) {
                $tax_query[] = [
                    'taxonomy' => 'region',
                    'field'    => 'slug',
                    'terms'    => array_map( 'sanitize_title', explode( ',', (string) $region ) ),
                ];
            }

            if ( $horizon ) {
                $tax_query[] = [
                    'taxonomy' => 'horizon',
                    'field'    => 'slug',
                    'terms'    => array_map( 'sanitize_title', explode( ',', (string) $horizon ) ),
                ];
            }

            if ( $industry ) {
                $tax_query[] = [
                    'taxonomy' => 'industry',
                    'field'    => 'slug',
                    'terms'    => array_map( 'sanitize_title', explode( ',', (string) $industry ) ),
                ];
            }

            if ( ! empty( $tax_query ) ) {
                $tax_query = apply_filters( 'wz_core_facet_args', $tax_query, $query );
                $query->set( 'tax_query', $tax_query );
            }
        }
    }

    /**
     * Output minimal Open Graph tags when SEO plugins are absent.
     */
    public static function output_open_graph(): void {
        if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || did_action( 'aioseo_loaded' ) ) {
            return;
        }

        if ( is_admin() ) {
            return;
        }

        $title       = wp_get_document_title();
        $description = get_bloginfo( 'description', 'display' );
        $url         = home_url( add_query_arg( [] ) );
        $image       = get_site_icon_url();

        echo '
<meta property="og:title" content="' . esc_attr( $title ) . '" />';
        echo '
<meta property="og:description" content="' . esc_attr( $description ) . '" />';
        echo '
<meta property="og:url" content="' . esc_url( $url ) . '" />';
        if ( $image ) {
            echo '
<meta property="og:image" content="' . esc_url( $image ) . '" />';
        }
    }

    /**
     * Allow resource gating to trigger login redirect without 404s.
     */
    public static function handle_resource_redirect( $preempt, $wp_query ) {
        if ( ! is_user_logged_in() && ! empty( $wp_query->query_vars['post_type'] ) && 'resource' === $wp_query->query_vars['post_type'] ) {
            $wp_query->is_404 = false;
        }

        return $preempt;
    }
}
