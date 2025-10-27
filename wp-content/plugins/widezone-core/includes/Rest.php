<?php
declare( strict_types=1 );

/**
 * REST API endpoints.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

class Rest {
    public const REST_NAMESPACE = 'widezone/v1';

    /**
     * Register routes.
     */
    public static function register_routes(): void {
        register_rest_route(
            self::REST_NAMESPACE,
            '/projects',
            [
                'methods'             => 'GET',
                'permission_callback' => '__return_true',
                'callback'            => [ __CLASS__, 'get_projects' ],
                'args'                => [
                    'industry' => [ 'sanitize_callback' => 'sanitize_text_field' ],
                    'region'   => [ 'sanitize_callback' => 'sanitize_text_field' ],
                    'horizon'  => [ 'sanitize_callback' => 'sanitize_text_field' ],
                    'per_page' => [ 'sanitize_callback' => 'absint', 'default' => 6 ],
                    'page'     => [ 'sanitize_callback' => 'absint', 'default' => 1 ],
                ],
            ]
        );

        register_rest_route(
            self::REST_NAMESPACE,
            '/jobs',
            [
                'methods'             => 'GET',
                'permission_callback' => '__return_true',
                'callback'            => [ __CLASS__, 'get_jobs' ],
                'args'                => [
                    'department' => [ 'sanitize_callback' => 'sanitize_text_field' ],
                    'location'   => [ 'sanitize_callback' => 'sanitize_text_field' ],
                    'type'       => [ 'sanitize_callback' => 'sanitize_text_field' ],
                ],
            ]
        );

        register_rest_route(
            self::REST_NAMESPACE,
            '/offices',
            [
                'methods'             => 'GET',
                'permission_callback' => '__return_true',
                'callback'            => [ __CLASS__, 'get_offices' ],
            ]
        );

        register_rest_route(
            self::REST_NAMESPACE,
            '/apply',
            [
                'methods'             => 'POST',
                'callback'            => [ __CLASS__, 'submit_application' ],
                'permission_callback' => [ __CLASS__, 'verify_nonce' ],
            ]
        );
    }

    /**
     * Verify nonce for POST requests.
     */
    public static function verify_nonce( WP_REST_Request $request ) {
        $nonce = $request->get_header( 'x-wp-nonce' );
        if ( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
            return true;
        }

        return new WP_Error( 'forbidden', __( 'Invalid security token.', 'widezone-core' ), [ 'status' => 403 ] );
    }

    /**
     * Retrieve projects.
     */
    public static function get_projects( WP_REST_Request $request ): WP_REST_Response {
        $args = [
            'post_type'      => 'project',
            'post_status'    => 'publish',
            'posts_per_page' => min( 20, max( 1, (int) $request->get_param( 'per_page' ) ) ),
            'paged'          => max( 1, (int) $request->get_param( 'page' ) ),
        ];

        $tax_query = [];
        foreach ( [ 'industry', 'region', 'horizon' ] as $tax ) {
            $value = $request->get_param( $tax );
            if ( $value ) {
                $tax_query[] = [
                    'taxonomy' => $tax,
                    'field'    => 'slug',
                    'terms'    => array_map( 'sanitize_title', explode( ',', (string) $value ) ),
                ];
            }
        }

        if ( ! empty( $tax_query ) ) {
            $args['tax_query'] = $tax_query;
        }

        $query = new \WP_Query( $args );
        $data  = [];
        while ( $query->have_posts() ) {
            $query->the_post();
            $data[] = [
                'id'       => get_the_ID(),
                'title'    => get_the_title(),
                'link'     => get_permalink(),
                'excerpt'  => wp_trim_words( get_the_excerpt(), 35 ),
                'region'   => wp_get_post_terms( get_the_ID(), 'region', [ 'fields' => 'names' ] ),
                'horizon'  => wp_get_post_terms( get_the_ID(), 'horizon', [ 'fields' => 'names' ] ),
                'industry' => wp_get_post_terms( get_the_ID(), 'industry', [ 'fields' => 'names' ] ),
                'featured_image' => get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ),
            ];
        }
        wp_reset_postdata();

        return new WP_REST_Response(
            [
                'data'       => $data,
                'pagination' => [
                    'total' => (int) $query->found_posts,
                    'pages' => (int) $query->max_num_pages,
                ],
            ]
        );
    }

    /**
     * Retrieve jobs list.
     */
    public static function get_jobs( WP_REST_Request $request ): WP_REST_Response {
        $meta_query = [];
        foreach ( [ 'department' => 'job_department', 'location' => 'job_location', 'type' => 'job_type' ] as $param => $meta_key ) {
            $value = $request->get_param( $param );
            if ( $value ) {
                $meta_query[] = [
                    'key'   => $meta_key,
                    'value' => sanitize_text_field( $value ),
                ];
            }
        }

        $args = [
            'post_type'      => 'job',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];
        if ( ! empty( $meta_query ) ) {
            $args['meta_query'] = $meta_query;
        }

        $query = new \WP_Query( $args );
        $data  = [];
        while ( $query->have_posts() ) {
            $query->the_post();
            $data[] = [
                'id'         => get_the_ID(),
                'title'      => get_the_title(),
                'link'       => get_permalink(),
                'department' => get_post_meta( get_the_ID(), 'job_department', true ),
                'location'   => get_post_meta( get_the_ID(), 'job_location', true ),
                'type'       => get_post_meta( get_the_ID(), 'job_type', true ),
                'apply_url'  => get_post_meta( get_the_ID(), 'job_apply_url', true ),
            ];
        }
        wp_reset_postdata();

        return new WP_REST_Response( [ 'data' => $data ] );
    }

    /**
     * Retrieve offices.
     */
    public static function get_offices(): WP_REST_Response {
        $query = new \WP_Query(
            [
                'post_type'      => 'office',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
            ]
        );

        $data = [];
        while ( $query->have_posts() ) {
            $query->the_post();
            $data[] = [
                'id'      => get_the_ID(),
                'title'   => get_the_title(),
                'city'    => get_post_meta( get_the_ID(), 'office_city', true ),
                'country' => get_post_meta( get_the_ID(), 'office_country', true ),
                'address' => get_post_meta( get_the_ID(), 'office_address', true ),
                'map_url' => get_post_meta( get_the_ID(), 'office_map_url', true ),
            ];
        }
        wp_reset_postdata();

        return new WP_REST_Response( [ 'data' => $data ] );
    }

    /**
     * Submit a job application.
     */
    public static function submit_application( WP_REST_Request $request ) {
        $ip_address = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
        $ip_key    = 'wz_core_apply_' . md5( $ip_address );
        if ( get_transient( $ip_key ) ) {
            return new WP_Error( 'rate_limited', __( 'Please wait before submitting again.', 'widezone-core' ), [ 'status' => 429 ] );
        }

        $job_id = absint( $request->get_param( 'job_id' ) );
        $name   = sanitize_text_field( (string) $request->get_param( 'name' ) );
        $email  = sanitize_email( (string) $request->get_param( 'email' ) );
        $message = wp_kses_post( (string) $request->get_param( 'message' ) );
        $cv_url = esc_url_raw( (string) $request->get_param( 'cv_url' ) );

        if ( empty( $name ) || empty( $email ) ) {
            return new WP_Error( 'invalid_application', __( 'Name and email are required.', 'widezone-core' ), [ 'status' => 400 ] );
        }

        $post_id = wp_insert_post(
            [
                'post_type'   => 'application',
                'post_status' => 'private',
                'post_title'  => sprintf( __( 'Application from %1$s', 'widezone-core' ), $name ),
                'post_content'=> $message,
                'meta_input'  => [
                    'job_id'  => $job_id,
                    'email'   => $email,
                    'cv_url'  => $cv_url,
                    'name'    => $name,
                ],
            ]
        );

        if ( is_wp_error( $post_id ) ) {
            return $post_id;
        }

        set_transient( $ip_key, 1, HOUR_IN_SECONDS );

        Emails::send_application_notifications(
            $post_id,
            [
                'job_id'  => $job_id,
                'name'    => $name,
                'email'   => $email,
                'message' => $message,
                'cv_url'  => $cv_url,
            ]
        );

        do_action( 'wz_core_application_received', $post_id );

        return new WP_REST_Response( [ 'success' => true ] );
    }
}
