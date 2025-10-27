<?php
declare( strict_types=1 );

/**
 * Main plugin bootstrap.
 *
 * @package WZ\Core
 */

namespace WZ\Core;

use WP_CLI;

class Plugin {
    /**
     * Bootstraps the plugin.
     */
    public static function init(): void {
        static::instance();
    }

    /**
     * Singleton instance.
     *
     * @var Plugin|null
     */
    protected static ?Plugin $instance = null;

    /**
     * Instance accessor.
     */
    public static function instance(): Plugin {
        if ( null === static::$instance ) {
            static::$instance = new Plugin();
        }

        return static::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        $this->hooks();
    }

    /**
     * Registers hooks.
     */
    protected function hooks(): void {
        register_activation_hook( WZ_CORE_PATH . 'widezone-core.php', [ $this, 'activate' ] );
        register_deactivation_hook( WZ_CORE_PATH . 'widezone-core.php', [ $this, 'deactivate' ] );

        add_action( 'init', [ Taxonomies::class, 'register' ], 5 );
        add_action( 'init', [ PostTypes::class, 'register' ], 6 );
        add_action( 'init', [ Meta::class, 'register' ], 9 );
        add_action( 'init', [ Shortcodes::class, 'register' ] );
        add_action( 'init', [ Blocks::class, 'register' ] );
        add_action( 'init', [ Filters::class, 'register_rewrite_tags' ], 1 );
        add_action( 'init', [ Filters::class, 'add_rewrite_rules' ], 12 );

        add_action( 'plugins_loaded', [ Options::class, 'init' ] );
        add_action( 'template_redirect', [ Access::class, 'maybe_gate_resource' ] );
        add_action( 'rest_api_init', [ Rest::class, 'register_routes' ] );
        add_action( 'wp_sitemaps_init', [ Sitemaps::class, 'register' ] );
        add_action( 'init', [ Filters::class, 'register_filters' ] );
        add_action( 'init', [ Filters::class, 'register_post_filters' ], 20 );
        add_action( 'wp_head', [ Filters::class, 'output_open_graph' ] );

        add_filter( 'login_redirect', [ Access::class, 'handle_login_redirect' ], 10, 3 );
        add_filter( 'pre_handle_404', [ Filters::class, 'handle_resource_redirect' ], 10, 2 );
        add_action( 'init', [ Blocks::class, 'register_assets' ] );

        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            add_action( 'cli_init', [ CLI::class, 'register_commands' ] );
        }
    }

    /**
     * Plugin activation callback.
     */
    public function activate(): void {
        Roles::register_roles();
        Taxonomies::register();
        PostTypes::register();
        Meta::register();
        Options::seed_terms();
        flush_rewrite_rules();
    }

    /**
     * Plugin deactivation callback.
     */
    public function deactivate(): void {
        flush_rewrite_rules();
    }
}
