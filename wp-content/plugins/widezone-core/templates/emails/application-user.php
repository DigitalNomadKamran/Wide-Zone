<?php
/**
 * Applicant confirmation email template.
 *
 * @var array $context
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
exit;
}

$branding = $context['branding'] ?? [];
$job_title = $context['job_title'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?php esc_html_e( 'Application Received', 'widezone-core' ); ?></title>
<style>
body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background: #f4f4f7; color: #002b5b; margin: 0; padding: 2rem; }
.container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 48px -28px rgba(0, 43, 91, 0.3); }
.header { padding: 1.5rem 2rem; background: linear-gradient(135deg, #002b5b, #00c2c7); color: #ffffff; }
.content { padding: 2rem; }
.footer { padding: 1.5rem 2rem; background: #f4f4f7; color: #4a4a4a; font-size: 0.85rem; }
a { color: #00c2c7; }
</style>
</head>
<body>
<div class="container">
<div class="header">
<h1><?php esc_html_e( 'Thank you for connecting with Wide Zone Co.', 'widezone-core' ); ?></h1>
</div>
<div class="content">
<p><?php printf( esc_html__( 'Hi %s,', 'widezone-core' ), esc_html( $context['name'] ?? '' ) ); ?></p>
<p><?php esc_html_e( 'We have received your application and our recruitment team will review it shortly.', 'widezone-core' ); ?></p>
<ul>
<li><strong><?php esc_html_e( 'Role', 'widezone-core' ); ?>:</strong> <?php echo esc_html( $job_title ); ?></li>
<?php if ( ! empty( $context['cv_url'] ) ) : ?>
<li><strong><?php esc_html_e( 'Submitted Asset', 'widezone-core' ); ?>:</strong> <a href="<?php echo esc_url( $context['cv_url'] ); ?>"><?php esc_html_e( 'Download link', 'widezone-core' ); ?></a></li>
<?php endif; ?>
</ul>
<p><?php esc_html_e( 'Should your profile align with current opportunities, a recruiter will reach out to coordinate next steps.', 'widezone-core' ); ?></p>
<p><?php esc_html_e( 'With appreciation,', 'widezone-core' ); ?><br /><?php esc_html_e( 'Wide Zone People & Culture', 'widezone-core' ); ?></p>
</div>
<div class="footer">
<p><?php echo esc_html( $branding['footer'] ?? __( 'Boundless Thinking. Unified Impact.', 'widezone-core' ) ); ?></p>
</div>
</div>
</body>
</html>
