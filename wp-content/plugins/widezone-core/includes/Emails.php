<?php
declare( strict_types=1 );

/**
 * Email helper class.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class Emails {
    /**
     * Send notifications when an application is submitted.
     */
    public static function send_application_notifications( int $post_id, array $data ): void {
        $hr_email = Options::get_portal_option( 'hr_email', get_option( 'admin_email' ) );
        if ( ! $hr_email ) {
            $hr_email = get_option( 'admin_email' );
        }

        $job_title = $data['job_id'] ? get_the_title( (int) $data['job_id'] ) : __( 'Job Opportunity', 'widezone-core' );

        $branding = [
            'logo'   => Options::get_brand_option( 'logo' ),
            'footer' => Options::get_brand_option( 'footer' ),
        ];

        $admin_subject = sprintf( __( 'New application: %s', 'widezone-core' ), $job_title );
        $admin_message = static::render_template( 'application-admin', $data + [ 'job_title' => $job_title, 'branding' => $branding ] );
        $user_subject  = __( 'Thank you for your application', 'widezone-core' );
        $user_message  = static::render_template( 'application-user', $data + [ 'job_title' => $job_title, 'branding' => $branding ] );

        $content_type_callback = static function (): string {
            return 'text/html';
        };

        add_filter( 'wp_mail_content_type', $content_type_callback );
        wp_mail( apply_filters( 'wz_core_hr_email', $hr_email, $data ), $admin_subject, $admin_message );
        if ( ! empty( $data['email'] ) && is_email( $data['email'] ) ) {
            wp_mail( $data['email'], $user_subject, $user_message );
        }
        remove_filter( 'wp_mail_content_type', $content_type_callback );
    }

    /**
     * Render an email template.
     */
    protected static function render_template( string $slug, array $data ): string {
        $template = WZ_CORE_PATH . 'templates/emails/' . $slug . '.php';
        if ( ! file_exists( $template ) ) {
            return '';
        }

        ob_start();
        $context = $data;
        include $template;

        return ob_get_clean();
    }
}
