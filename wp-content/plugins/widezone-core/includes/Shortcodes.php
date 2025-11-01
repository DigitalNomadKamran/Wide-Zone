<?php
declare( strict_types=1 );

/**
 * Shortcodes implementation.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class Shortcodes {
    /**
     * Register shortcodes.
     */
    public static function register(): void {
        add_shortcode( 'wz_portal', [ __CLASS__, 'portal' ] );
        add_shortcode( 'wz_jobs', [ __CLASS__, 'jobs' ] );
        add_shortcode( 'wz_offices', [ __CLASS__, 'offices' ] );
        add_shortcode( 'wz_filters', [ __CLASS__, 'filters' ] );
    }

    /**
     * Render portal resources.
     */
    public static function portal( array $atts = [] ): string {
        $atts = shortcode_atts(
            [
                'audience' => 'public',
            ],
            $atts,
            'wz_portal'
        );

        $audience = sanitize_key( $atts['audience'] );

        $query_args = [
            'post_type'      => 'resource',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => [],
            'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
        ];

        if ( in_array( $audience, [ 'investor', 'partner', 'public' ], true ) ) {
            $query_args['tax_query'][] = [
                'taxonomy' => 'audience',
                'field'    => 'slug',
                'terms'    => [ $audience ],
            ];
        }

        $query = new \WP_Query( $query_args );
        if ( ! $query->have_posts() ) {
            return '<div class="wz-portal__empty">' . esc_html__( 'No resources found.', 'widezone-core' ) . '</div>';
        }

        ob_start();
        echo '<div class="wz-portal" data-audience="' . esc_attr( $audience ) . '">';
        $rendered = false;
        while ( $query->have_posts() ) {
            $query->the_post();
            $allowed = Access::can_view_resource( get_current_user_id(), get_the_ID() );
            if ( ! $allowed ) {
                continue;
            }
            $rendered = true;
            echo '<article class="wz-portal__item">';
            echo '<h3 class="wz-portal__title"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
            echo '<div class="wz-portal__excerpt">' . wp_kses_post( wp_trim_words( get_the_excerpt(), 30 ) ) . '</div>';
            echo '</article>';
        }
        if ( ! $rendered ) {
            echo '<p class="wz-portal__notice">' . esc_html__( 'Please sign in to access gated resources.', 'widezone-core' ) . '</p>';
        }
        echo '</div>';
        wp_reset_postdata();

        return ob_get_clean();
    }

    /**
     * Render jobs list.
     */
    public static function jobs(): string {
        $query = new \WP_Query(
            [
                'post_type'      => 'job',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
            ]
        );

        if ( ! $query->have_posts() ) {
            return '<div class="wz-jobs__empty">' . esc_html__( 'No open roles available.', 'widezone-core' ) . '</div>';
        }

        ob_start();
        echo '<div class="wz-jobs">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $department = get_post_meta( get_the_ID(), 'job_department', true );
            $location   = get_post_meta( get_the_ID(), 'job_location', true );
            $type       = get_post_meta( get_the_ID(), 'job_type', true );
            $apply_url  = get_post_meta( get_the_ID(), 'job_apply_url', true );

            echo '<article class="wz-job">';
            echo '<h3 class="wz-job__title"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
            echo '<ul class="wz-job__meta">';
            if ( $department ) {
                echo '<li><strong>' . esc_html__( 'Department:', 'widezone-core' ) . '</strong> ' . esc_html( $department ) . '</li>';
            }
            if ( $location ) {
                echo '<li><strong>' . esc_html__( 'Location:', 'widezone-core' ) . '</strong> ' . esc_html( $location ) . '</li>';
            }
            if ( $type ) {
                echo '<li><strong>' . esc_html__( 'Type:', 'widezone-core' ) . '</strong> ' . esc_html( ucfirst( $type ) ) . '</li>';
            }
            echo '</ul>';

            if ( $apply_url ) {
                echo '<p><a class="wz-job__apply" href="' . esc_url( $apply_url ) . '">' . esc_html__( 'Apply Now', 'widezone-core' ) . '</a></p>';
            } else {
                echo '<p>' . esc_html__( 'Submit your application via the form below.', 'widezone-core' ) . '</p>';
            }
            echo '</article>';
        }
        echo '</div>';
        wp_reset_postdata();

        return ob_get_clean();
    }

    /**
     * Render offices list.
     */
    public static function offices(): string {
        $query = new \WP_Query(
            [
                'post_type'      => 'office',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
            ]
        );

        if ( ! $query->have_posts() ) {
            return '<div class="wz-offices__empty">' . esc_html__( 'No offices available.', 'widezone-core' ) . '</div>';
        }

        ob_start();
        echo '<div class="wz-offices">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $city     = get_post_meta( get_the_ID(), 'office_city', true );
            $country  = get_post_meta( get_the_ID(), 'office_country', true );
            $address  = get_post_meta( get_the_ID(), 'office_address', true );
            $map_url  = get_post_meta( get_the_ID(), 'office_map_url', true );

            echo '<article class="wz-office">';
            echo '<h3 class="wz-office__title">' . esc_html( get_the_title() ) . '</h3>';
            echo '<p class="wz-office__location">' . esc_html( trim( implode( ', ', array_filter( [ $city, $country ] ) ) ) ) . '</p>';
            if ( $address ) {
                echo '<div class="wz-office__address">' . wpautop( wp_kses_post( $address ) ) . '</div>';
            }
            if ( $map_url ) {
                echo '<p><a class="wz-office__map" href="' . esc_url( $map_url ) . '" target="_blank" rel="noopener">' . esc_html__( 'View Map', 'widezone-core' ) . '</a></p>';
            }
            echo '</article>';
        }
        echo '</div>';
        wp_reset_postdata();

        return ob_get_clean();
    }

    /**
     * Render filters UI.
     */
    public static function filters( array $atts = [] ): string {
        $atts = shortcode_atts(
            [
                'type' => 'projects',
            ],
            $atts,
            'wz_filters'
        );

        if ( 'projects' !== $atts['type'] ) {
            return '';
        }

        $terms = [
            'industry' => get_terms( [ 'taxonomy' => 'industry', 'hide_empty' => true ] ),
            'region'   => get_terms( [ 'taxonomy' => 'region', 'hide_empty' => true ] ),
            'horizon'  => get_terms( [ 'taxonomy' => 'horizon', 'hide_empty' => true ] ),
        ];

        $current = [
            'industry' => sanitize_text_field( wp_unslash( $_GET['wz_industry'] ?? '' ) ),
            'region'   => sanitize_text_field( wp_unslash( $_GET['wz_region'] ?? '' ) ),
            'horizon'  => sanitize_text_field( wp_unslash( $_GET['wz_horizon'] ?? '' ) ),
        ];

        $base = get_post_type_archive_link( 'project' );
        if ( ! $base ) {
            $base = home_url( '/portfolio/' );
        }

        ob_start();
        echo '<div class="wz-filters" role="navigation" aria-label="' . esc_attr__( 'Project filters', 'widezone-core' ) . '">';
        foreach ( $terms as $taxonomy => $items ) {
            if ( empty( $items ) || is_wp_error( $items ) ) {
                continue;
            }
            echo '<div class="wz-filters__group" data-taxonomy="' . esc_attr( $taxonomy ) . '">';
            echo '<span class="wz-filters__label">' . esc_html( ucwords( $taxonomy ) ) . '</span>';
            echo '<div class="wz-filters__items">';
            echo self::filter_link( $base, $taxonomy, '', __( 'All', 'widezone-core' ), empty( $current[ $taxonomy ] ) );
            foreach ( $items as $term ) {
                $is_active = $current[ $taxonomy ] === $term->slug;
                echo self::filter_link( $base, $taxonomy, $term->slug, $term->name, $is_active );
            }
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';

        return ob_get_clean();
    }

    protected static function filter_link( string $base, string $taxonomy, string $slug, string $label, bool $active ): string {
        $query_key = 'wz_' . $taxonomy;

        if ( '' === $slug ) {
            $url = remove_query_arg( $query_key, $base );
        } else {
            $url = add_query_arg( $query_key, $slug, $base );
        }
        $class = 'wz-filter__link' . ( $active ? ' is-active' : '' );

        return '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
    }
}
