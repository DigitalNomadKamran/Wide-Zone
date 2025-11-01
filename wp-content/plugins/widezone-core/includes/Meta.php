<?php
declare( strict_types=1 );

/**
 * Register custom metadata.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class Meta {
    /**
     * Registers post meta fields.
     */
    public static function register(): void {
        static::register_industry_meta();
        static::register_project_meta();
        static::register_job_meta();
        static::register_office_meta();
    }

    protected static function register_industry_meta(): void {
        register_post_meta(
            'industry',
            'industry_icon_svg',
            [
                'type'              => 'string',
                'single'            => true,
                'show_in_rest'      => true,
                'sanitize_callback' => [ __CLASS__, 'sanitize_svg' ],
                'auth_callback'     => [ __CLASS__, 'meta_auth_callback' ],
            ]
        );
    }

    protected static function register_project_meta(): void {
        register_post_meta(
            'project',
            'project_industry',
            [
                'type'              => 'integer',
                'single'            => true,
                'show_in_rest'      => true,
                'sanitize_callback' => 'absint',
                'auth_callback'     => [ __CLASS__, 'meta_auth_callback' ],
            ]
        );

        register_post_meta(
            'project',
            'project_metrics',
            [
                'type'              => 'string',
                'single'            => true,
                'show_in_rest'      => true,
                'sanitize_callback' => [ __CLASS__, 'sanitize_json' ],
                'auth_callback'     => [ __CLASS__, 'meta_auth_callback' ],
            ]
        );
    }

    protected static function register_job_meta(): void {
        $meta_fields = [
            'job_department' => [ __CLASS__, 'sanitize_text' ],
            'job_location'   => [ __CLASS__, 'sanitize_text' ],
        ];

        foreach ( $meta_fields as $key => $callback ) {
            register_post_meta(
                'job',
                $key,
                [
                    'type'              => 'string',
                    'single'            => true,
                    'show_in_rest'      => true,
                    'sanitize_callback' => $callback,
                    'auth_callback'     => [ __CLASS__, 'meta_auth_callback' ],
                ]
            );
        }

        register_post_meta(
            'job',
            'job_type',
            [
                'type'              => 'string',
                'single'            => true,
                'show_in_rest'      => true,
                'sanitize_callback' => [ __CLASS__, 'sanitize_job_type' ],
                'auth_callback'     => [ __CLASS__, 'meta_auth_callback' ],
            ]
        );

        register_post_meta(
            'job',
            'job_apply_url',
            [
                'type'              => 'string',
                'single'            => true,
                'show_in_rest'      => true,
                'sanitize_callback' => 'esc_url_raw',
                'auth_callback'     => [ __CLASS__, 'meta_auth_callback' ],
            ]
        );
    }

    protected static function register_office_meta(): void {
        $fields = [
            'office_city'    => [ __CLASS__, 'sanitize_text' ],
            'office_country' => [ __CLASS__, 'sanitize_text' ],
            'office_address' => [ __CLASS__, 'sanitize_textarea' ],
        ];

        foreach ( $fields as $key => $callback ) {
            register_post_meta(
                'office',
                $key,
                [
                    'type'              => 'string',
                    'single'            => true,
                    'show_in_rest'      => true,
                    'sanitize_callback' => $callback,
                    'auth_callback'     => [ __CLASS__, 'meta_auth_callback' ],
                ]
            );
        }

        register_post_meta(
            'office',
            'office_map_url',
            [
                'type'              => 'string',
                'single'            => true,
                'show_in_rest'      => true,
                'sanitize_callback' => 'esc_url_raw',
                'auth_callback'     => [ __CLASS__, 'meta_auth_callback' ],
            ]
        );
    }

    /**
     * Capability check for meta editing.
     */
    public static function meta_auth_callback( $allowed, $meta_key, $post_id, $user_id, $cap ): bool {
        if ( user_can( $user_id, 'edit_post', $post_id ) ) {
            return true;
        }

        return false;
    }

    /**
     * Sanitize text fields.
     */
    public static function sanitize_text( $value ): string {
        return sanitize_text_field( (string) $value );
    }

    /**
     * Sanitize textareas.
     */
    public static function sanitize_textarea( $value ): string {
        return wp_kses_post( (string) $value );
    }

    /**
     * Sanitize svg string.
     */
    public static function sanitize_svg( $value ): string {
        $value = trim( (string) $value );
        $allowed_tags = [
            'svg'  => [ 'xmlns' => true, 'viewBox' => true, 'fill' => true, 'stroke' => true, 'width' => true, 'height' => true, 'role' => true, 'aria-hidden' => true ],
            'path' => [ 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true ],
            'g'    => [ 'fill' => true, 'stroke' => true, 'transform' => true ],
        ];

        return wp_kses( $value, $allowed_tags );
    }

    /**
     * Sanitize job type.
     */
    public static function sanitize_job_type( $value ): string {
        $allowed = [ 'full-time', 'part-time', 'contract' ];
        $value   = sanitize_key( (string) $value );

        return in_array( $value, $allowed, true ) ? $value : 'full-time';
    }

    /**
     * Sanitize JSON string.
     */
    public static function sanitize_json( $value ): string {
        if ( empty( $value ) ) {
            return '';
        }

        if ( is_array( $value ) || is_object( $value ) ) {
            $value = wp_json_encode( $value );
        }

        $decoded = json_decode( (string) $value, true );
        if ( JSON_ERROR_NONE !== json_last_error() ) {
            return '';
        }

        return wp_json_encode( $decoded );
    }
}
