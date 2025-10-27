<?php
declare( strict_types=1 );

/**
 * Admin options and settings helpers.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class Options {
    public const BRAND_OPTION  = 'wz_core_brand_contact';
    public const PORTAL_OPTION = 'wz_core_portal_settings';

    /**
     * Hook into admin.
     */
    public static function init(): void {
        add_action( 'admin_menu', [ __CLASS__, 'register_menu' ] );
        add_action( 'admin_init', [ __CLASS__, 'register_settings' ] );
    }

    /**
     * Register admin menu.
     */
    public static function register_menu(): void {
        add_options_page(
            __( 'Wide Zone Settings', 'widezone-core' ),
            __( 'Wide Zone', 'widezone-core' ),
            'manage_options',
            'wz-core-settings',
            [ __CLASS__, 'render_page' ]
        );
    }

    /**
     * Register settings fields.
     */
    public static function register_settings(): void {
        register_setting( 'wz_core_brand', self::BRAND_OPTION, [ __CLASS__, 'sanitize_brand' ] );
        register_setting( 'wz_core_portal', self::PORTAL_OPTION, [ __CLASS__, 'sanitize_portal' ] );

        add_settings_section( 'wz_core_brand_section', __( 'Brand & Contact', 'widezone-core' ), '__return_false', 'wz-core-brand' );
        add_settings_section( 'wz_core_portal_section', __( 'Portals', 'widezone-core' ), '__return_false', 'wz-core-portal' );
    }

    /**
     * Render settings page.
     */
    public static function render_page(): void {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to access this page.', 'widezone-core' ) );
        }

        $brand  = get_option( self::BRAND_OPTION, [] );
        $portal = get_option( self::PORTAL_OPTION, [] );
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Wide Zone Configuration', 'widezone-core' ); ?></h1>
            <div class="wz-core-settings">
                <div class="wz-core-settings__column">
                    <form method="post" action="options.php">
                        <?php
                        settings_fields( 'wz_core_brand' );
                        do_settings_sections( 'wz-core-brand' );
                        ?>
                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row"><label for="wz-core-brand-email"><?php esc_html_e( 'Primary Email', 'widezone-core' ); ?></label></th>
                                <td><input type="email" id="wz-core-brand-email" name="<?php echo esc_attr( self::BRAND_OPTION ); ?>[email]" value="<?php echo esc_attr( $brand['email'] ?? '' ); ?>" class="regular-text" /></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wz-core-brand-phone"><?php esc_html_e( 'Primary Phone', 'widezone-core' ); ?></label></th>
                                <td><input type="text" id="wz-core-brand-phone" name="<?php echo esc_attr( self::BRAND_OPTION ); ?>[phone]" value="<?php echo esc_attr( $brand['phone'] ?? '' ); ?>" class="regular-text" /></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wz-core-brand-address"><?php esc_html_e( 'Headquarters Address', 'widezone-core' ); ?></label></th>
                                <td><textarea id="wz-core-brand-address" name="<?php echo esc_attr( self::BRAND_OPTION ); ?>[address]" class="large-text" rows="3"><?php echo esc_textarea( $brand['address'] ?? '' ); ?></textarea></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wz-core-brand-footer"><?php esc_html_e( 'Email Footer Text', 'widezone-core' ); ?></label></th>
                                <td><textarea id="wz-core-brand-footer" name="<?php echo esc_attr( self::BRAND_OPTION ); ?>[footer]" class="large-text" rows="2"><?php echo esc_textarea( $brand['footer'] ?? '' ); ?></textarea></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wz-core-brand-logo"><?php esc_html_e( 'Brand Logo URL', 'widezone-core' ); ?></label></th>
                                <td><input type="url" id="wz-core-brand-logo" name="<?php echo esc_attr( self::BRAND_OPTION ); ?>[logo]" value="<?php echo esc_attr( $brand['logo'] ?? '' ); ?>" class="regular-text" /></td>
                            </tr>
                        </table>
                        <?php submit_button( __( 'Save Brand Settings', 'widezone-core' ) ); ?>
                    </form>
                </div>
                <div class="wz-core-settings__column">
                    <form method="post" action="options.php">
                        <?php
                        settings_fields( 'wz_core_portal' );
                        do_settings_sections( 'wz-core-portal' );
                        ?>
                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Enable Investor Portal', 'widezone-core' ); ?></th>
                                <td><label><input type="checkbox" name="<?php echo esc_attr( self::PORTAL_OPTION ); ?>[enable_investor]" value="1" <?php checked( ! empty( $portal['enable_investor'] ) ); ?> /> <?php esc_html_e( 'Allow investor-only content access.', 'widezone-core' ); ?></label></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Enable Partner Portal', 'widezone-core' ); ?></th>
                                <td><label><input type="checkbox" name="<?php echo esc_attr( self::PORTAL_OPTION ); ?>[enable_partner]" value="1" <?php checked( ! empty( $portal['enable_partner'] ) ); ?> /> <?php esc_html_e( 'Allow partner-only content access.', 'widezone-core' ); ?></label></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wz-core-investor-login"><?php esc_html_e( 'Investor Login URL', 'widezone-core' ); ?></label></th>
                                <td><input type="url" id="wz-core-investor-login" name="<?php echo esc_attr( self::PORTAL_OPTION ); ?>[investor_login]" value="<?php echo esc_attr( $portal['investor_login'] ?? '' ); ?>" class="regular-text" /></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wz-core-partner-login"><?php esc_html_e( 'Partner Login URL', 'widezone-core' ); ?></label></th>
                                <td><input type="url" id="wz-core-partner-login" name="<?php echo esc_attr( self::PORTAL_OPTION ); ?>[partner_login]" value="<?php echo esc_attr( $portal['partner_login'] ?? '' ); ?>" class="regular-text" /></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="wz-core-hr-email"><?php esc_html_e( 'Default HR Email', 'widezone-core' ); ?></label></th>
                                <td><input type="email" id="wz-core-hr-email" name="<?php echo esc_attr( self::PORTAL_OPTION ); ?>[hr_email]" value="<?php echo esc_attr( $portal['hr_email'] ?? '' ); ?>" class="regular-text" /></td>
                            </tr>
                        </table>
                        <?php submit_button( __( 'Save Portal Settings', 'widezone-core' ) ); ?>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Sanitize brand option.
     */
    public static function sanitize_brand( $input ): array {
        $input = is_array( $input ) ? $input : [];
        return [
            'email'  => isset( $input['email'] ) ? sanitize_email( $input['email'] ) : '',
            'phone'  => isset( $input['phone'] ) ? sanitize_text_field( $input['phone'] ) : '',
            'address'=> isset( $input['address'] ) ? wp_kses_post( $input['address'] ) : '',
            'footer' => isset( $input['footer'] ) ? wp_kses_post( $input['footer'] ) : '',
            'logo'   => isset( $input['logo'] ) ? esc_url_raw( $input['logo'] ) : '',
        ];
    }

    /**
     * Sanitize portal options.
     */
    public static function sanitize_portal( $input ): array {
        $input = is_array( $input ) ? $input : [];
        return [
            'enable_investor' => ! empty( $input['enable_investor'] ) ? 1 : 0,
            'enable_partner'  => ! empty( $input['enable_partner'] ) ? 1 : 0,
            'investor_login'  => isset( $input['investor_login'] ) ? esc_url_raw( $input['investor_login'] ) : '',
            'partner_login'   => isset( $input['partner_login'] ) ? esc_url_raw( $input['partner_login'] ) : '',
            'hr_email'        => isset( $input['hr_email'] ) ? sanitize_email( $input['hr_email'] ) : '',
        ];
    }

    /**
     * Fetch brand option value.
     */
    public static function get_brand_option( string $key, $default = '' ) {
        $option = get_option( self::BRAND_OPTION, [] );

        return $option[ $key ] ?? $default;
    }

    /**
     * Fetch portal option value.
     */
    public static function get_portal_option( string $key, $default = '' ) {
        $option = get_option( self::PORTAL_OPTION, [] );

        return $option[ $key ] ?? $default;
    }

    /**
     * Provide default brand values list.
     */
    public static function get_values(): array {
        $defaults = [
            [ 'title' => __( 'Expansiveness', 'widezone-core' ), 'description' => __( 'We think beyond borders to build integrated ecosystems.', 'widezone-core' ) ],
            [ 'title' => __( 'Inclusivity', 'widezone-core' ), 'description' => __( 'We align stakeholders for collective progress.', 'widezone-core' ) ],
            [ 'title' => __( 'Innovation', 'widezone-core' ), 'description' => __( 'We invest in bold ideas and technologies.', 'widezone-core' ) ],
            [ 'title' => __( 'Integrity', 'widezone-core' ), 'description' => __( 'We operate with transparency and accountability.', 'widezone-core' ) ],
            [ 'title' => __( 'Agility', 'widezone-core' ), 'description' => __( 'We adapt quickly to emerging opportunities.', 'widezone-core' ) ],
            [ 'title' => __( 'Collaboration', 'widezone-core' ), 'description' => __( 'We partner to unlock new horizons.', 'widezone-core' ) ],
            [ 'title' => __( 'Impact', 'widezone-core' ), 'description' => __( 'We measure success by sustainable outcomes.', 'widezone-core' ) ],
        ];

        return apply_filters( 'wz_core_values_list', $defaults );
    }

    /**
     * Seed required terms on activation.
     */
    public static function seed_terms(): void {
        $regions = [ 'ksa' => 'KSA', 'gcc' => 'GCC', 'mena' => 'MENA' ];
        foreach ( $regions as $slug => $name ) {
            if ( ! term_exists( $name, 'region' ) ) {
                wp_insert_term( $name, 'region', [ 'slug' => $slug ] );
            }
        }

        if ( taxonomy_exists( 'audience' ) ) {
            foreach ( [ 'public', 'investor', 'partner' ] as $slug ) {
                if ( ! term_exists( $slug, 'audience' ) ) {
                    wp_insert_term( ucfirst( $slug ), 'audience', [ 'slug' => $slug ] );
                }
            }
        }
    }
}
