<?php
declare( strict_types=1 );

/**
 * Roles management.
 *
 * @package WZ\Core
 */

namespace WZ\Core;

class Roles {
    /**
     * Register custom roles on activation.
     */
    public static function register_roles(): void {
        static::add_role( 'investor', \__( 'Investor', 'widezone-core' ), [
            'read'               => true,
            'read_investor_docs' => true,
        ] );

        static::add_role( 'partner', \__( 'Partner', 'widezone-core' ), [
            'read'              => true,
            'read_partner_docs' => true,
        ] );

        static::add_role( 'recruiter', \__( 'Recruiter', 'widezone-core' ), [
            'read' => true,
        ] );

        static::ensure_admin_caps();
    }

    /**
     * Adds a role if missing.
     */
    protected static function add_role( string $role, string $label, array $caps ): void {
        if ( null === \get_role( $role ) ) {
            \add_role( $role, $label, $caps );
        } else {
            $role_object = \get_role( $role );
            if ( $role_object ) {
                foreach ( $caps as $cap => $grant ) {
                    $role_object->add_cap( $cap, (bool) $grant );
                }
            }
        }
    }

    /**
     * Ensure administrators have portal caps.
     */
    protected static function ensure_admin_caps(): void {
        $admin = \get_role( 'administrator' );
        if ( ! $admin ) {
            return;
        }

        $admin->add_cap( 'read_investor_docs', true );
        $admin->add_cap( 'read_partner_docs', true );
    }
}
