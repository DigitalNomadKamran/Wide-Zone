<?php
declare( strict_types=1 );

/**
 * Access control utilities.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class Access {
    /**
     * Determine if a user can view a gated resource.
     */
    public static function can_view_resource( int $user_id, int $post_id ): bool {
        $terms = wp_get_object_terms( $post_id, 'audience', [ 'fields' => 'slugs' ] );
        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            return true;
        }

        $audience = $terms[0];
        $allowed  = true;

        if ( 'public' === $audience ) {
            $allowed = true;
        } elseif ( 'investor' === $audience && ! Options::get_portal_option( 'enable_investor' ) ) {
            $allowed = true;
        } elseif ( 'partner' === $audience && ! Options::get_portal_option( 'enable_partner' ) ) {
            $allowed = true;
        } elseif ( ! $user_id ) {
            $allowed = false;
        } else {
            $user = get_user_by( 'id', $user_id );
            if ( ! $user ) {
                $allowed = false;
            } elseif ( 'investor' === $audience ) {
                $allowed = user_can( $user, 'read_investor_docs' );
            } elseif ( 'partner' === $audience ) {
                $allowed = user_can( $user, 'read_partner_docs' );
            }
        }

        return (bool) apply_filters( 'wz_core_can_view_resource', $allowed, $user_id, $post_id, $audience );
    }

    /**
     * Gate resources based on audience taxonomy.
     */
    public static function maybe_gate_resource(): void {
        if ( ! is_singular( 'resource' ) ) {
            return;
        }

        $post_id = get_queried_object_id();
        $user_id = get_current_user_id();

        if ( $post_id && ! static::can_view_resource( $user_id, $post_id ) ) {
            $audience = wp_get_object_terms( $post_id, 'audience', [ 'fields' => 'slugs' ] );
            $audience = is_wp_error( $audience ) || empty( $audience ) ? 'public' : $audience[0];

            $redirect = wp_login_url( get_permalink( $post_id ) );
            if ( 'investor' === $audience ) {
                if ( ! Options::get_portal_option( 'enable_investor' ) ) {
                    return;
                }
                $custom = Options::get_portal_option( 'investor_login' );
                if ( $custom ) {
                    $redirect = add_query_arg( 'redirect_to', rawurlencode( get_permalink( $post_id ) ), $custom );
                }
            }
            if ( 'partner' === $audience ) {
                if ( ! Options::get_portal_option( 'enable_partner' ) ) {
                    return;
                }
                $custom = Options::get_portal_option( 'partner_login' );
                if ( $custom ) {
                    $redirect = add_query_arg( 'redirect_to', rawurlencode( get_permalink( $post_id ) ), $custom );
                }
            }

            wp_safe_redirect( $redirect );
            exit;
        }
    }

    /**
     * Handle post-login redirects for portal roles.
     */
    public static function handle_login_redirect( $redirect_to, $requested_redirect_to, $user ) {
        if ( ! $user || is_wp_error( $user ) ) {
            return $redirect_to;
        }

        $portal_redirect = $redirect_to;
        if ( in_array( 'investor', (array) $user->roles, true ) ) {
            $portal_redirect = Options::get_portal_option( 'investor_login', $redirect_to ) ?: $redirect_to;
        } elseif ( in_array( 'partner', (array) $user->roles, true ) ) {
            $portal_redirect = Options::get_portal_option( 'partner_login', $redirect_to ) ?: $redirect_to;
        }

        return $requested_redirect_to ?: $portal_redirect;
    }
}
