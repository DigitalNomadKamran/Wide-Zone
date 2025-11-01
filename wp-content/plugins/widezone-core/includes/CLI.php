<?php
declare( strict_types=1 );

/**
 * WP-CLI commands.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

use WP_CLI;
use WP_Error;

class CLI {
    /**
     * Register commands.
     */
    public static function register_commands(): void {
        if ( ! class_exists( '\WP_CLI' ) ) {
            return;
        }

        WP_CLI::add_command( 'wzcore seed', [ __CLASS__, 'seed_content' ] );
        WP_CLI::add_command( 'wzcore create-users', [ __CLASS__, 'create_users' ] );
    }

    /**
     * Seed demo content.
     */
    public static function seed_content(): void {
        self::seed_terms();
        self::seed_industries();
        self::seed_projects();
        self::seed_jobs();
        self::seed_offices();
        WP_CLI::success( 'Wide Zone core data seeded.' );
    }

    /**
     * Create portal test users.
     */
    public static function create_users(): void {
        self::maybe_create_user( 'investor_user', 'investor@example.com', 'investor' );
        self::maybe_create_user( 'partner_user', 'partner@example.com', 'partner' );
        WP_CLI::success( 'Investor and partner users ensured.' );
    }

    protected static function maybe_create_user( string $login, string $email, string $role ): void {
        if ( get_user_by( 'login', $login ) ) {
            WP_CLI::log( sprintf( '%s already exists.', $login ) );
            return;
        }

        $user_id = wp_create_user( $login, wp_generate_password( 12 ), $email );
        if ( is_wp_error( $user_id ) ) {
            WP_CLI::warning( sprintf( 'Could not create %s: %s', $login, $user_id->get_error_message() ) );
            return;
        }

        $user = get_user_by( 'id', $user_id );
        if ( $user ) {
            $user->set_role( $role );
        }
        WP_CLI::log( sprintf( 'Created %s with role %s.', $login, $role ) );
    }

    protected static function seed_terms(): void {
        Options::seed_terms();

        foreach ( [ 'Short', 'Mid', 'Long' ] as $term ) {
            if ( ! term_exists( $term, 'horizon' ) ) {
                wp_insert_term( $term, 'horizon' );
            }
        }

        $industries = [
            'Food & Beverages',
            'Retail',
            'Information Technology',
            'Construction & Contracting',
            'Fashion',
            'International Trade',
        ];
        foreach ( $industries as $name ) {
            if ( ! get_page_by_title( $name, OBJECT, 'industry' ) ) {
                wp_insert_post(
                    [
                        'post_type'   => 'industry',
                        'post_status' => 'publish',
                        'post_title'  => $name,
                        'post_content'=> __( 'Industry overview coming soon.', 'widezone-core' ),
                    ]
                );
            }
        }
    }

    protected static function seed_industries(): void {
        // Industries are seeded in seed_terms().
    }

    protected static function seed_projects(): void {
        $projects = [
            [
                'title'   => __( 'Integrated Supply Chain Accelerator', 'widezone-core' ),
                'content' => __( 'A multi-sector program connecting food and retail innovation across MENA markets.', 'widezone-core' ),
                'region'  => 'mena',
                'horizon' => 'long',
            ],
            [
                'title'   => __( 'Digital Infrastructure Uplift', 'widezone-core' ),
                'content' => __( 'Expanding IT capabilities for regional trade hubs with agile deployment.', 'widezone-core' ),
                'region'  => 'gcc',
                'horizon' => 'mid',
            ],
        ];

        foreach ( $projects as $project ) {
            if ( ! get_page_by_title( $project['title'], OBJECT, 'project' ) ) {
                $post_id = wp_insert_post(
                    [
                        'post_type'   => 'project',
                        'post_status' => 'publish',
                        'post_title'  => $project['title'],
                        'post_content'=> $project['content'],
                    ]
                );

                if ( ! is_wp_error( $post_id ) ) {
                    if ( ! empty( $project['region'] ) ) {
                        wp_set_post_terms( $post_id, [ $project['region'] ], 'region' );
                    }
                    if ( ! empty( $project['horizon'] ) ) {
                        wp_set_post_terms( $post_id, [ $project['horizon'] ], 'horizon' );
                    }
                }
            }
        }
    }

    protected static function seed_jobs(): void {
        $jobs = [
            [
                'title'    => __( 'Investment Analyst', 'widezone-core' ),
                'department' => 'Investments',
                'location' => 'Riyadh, KSA',
                'type'     => 'full-time',
            ],
            [
                'title'    => __( 'Partner Success Manager', 'widezone-core' ),
                'department' => 'Partnerships',
                'location' => 'Dubai, UAE',
                'type'     => 'full-time',
            ],
        ];

        foreach ( $jobs as $job ) {
            if ( ! get_page_by_title( $job['title'], OBJECT, 'job' ) ) {
                $post_id = wp_insert_post(
                    [
                        'post_type'   => 'job',
                        'post_status' => 'publish',
                        'post_title'  => $job['title'],
                        'post_content'=> __( 'Join Wide Zone Co. to help build the future of integrated investments.', 'widezone-core' ),
                    ]
                );

                if ( ! is_wp_error( $post_id ) ) {
                    update_post_meta( $post_id, 'job_department', $job['department'] );
                    update_post_meta( $post_id, 'job_location', $job['location'] );
                    update_post_meta( $post_id, 'job_type', $job['type'] );
                }
            }
        }
    }

    protected static function seed_offices(): void {
        $offices = [
            [
                'title'   => __( 'Riyadh Headquarters', 'widezone-core' ),
                'city'    => 'Riyadh',
                'country' => 'Saudi Arabia',
            ],
            [
                'title'   => __( 'Dubai Office', 'widezone-core' ),
                'city'    => 'Dubai',
                'country' => 'United Arab Emirates',
            ],
        ];

        foreach ( $offices as $office ) {
            if ( ! get_page_by_title( $office['title'], OBJECT, 'office' ) ) {
                $post_id = wp_insert_post(
                    [
                        'post_type'   => 'office',
                        'post_status' => 'publish',
                        'post_title'  => $office['title'],
                        'post_content'=> __( 'Contact our team for tailored support.', 'widezone-core' ),
                    ]
                );

                if ( ! is_wp_error( $post_id ) ) {
                    update_post_meta( $post_id, 'office_city', $office['city'] );
                    update_post_meta( $post_id, 'office_country', $office['country'] );
                }
            }
        }
    }
}
