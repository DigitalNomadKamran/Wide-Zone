<?php
/**
 * Plugin Name: Wide Zone Core
 * Description: Core functionality plugin for Wide Zone Co. block theme.
 * Version: 1.0.0
 * Author: Wide Zone Co.
 * Text Domain: widezone-core
 */

declare( strict_types=1 );

namespace WZ\Core;

if ( ! defined( 'ABSPATH' ) ) {
exit;
}

define( 'WZ_CORE_VERSION', '1.0.0' );
define( 'WZ_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'WZ_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once WZ_CORE_PATH . 'includes/Plugin.php';
require_once WZ_CORE_PATH . 'includes/Roles.php';
require_once WZ_CORE_PATH . 'includes/PostTypes.php';
require_once WZ_CORE_PATH . 'includes/Taxonomies.php';
require_once WZ_CORE_PATH . 'includes/Meta.php';
require_once WZ_CORE_PATH . 'includes/Filters.php';
require_once WZ_CORE_PATH . 'includes/Shortcodes.php';
require_once WZ_CORE_PATH . 'includes/Blocks.php';
require_once WZ_CORE_PATH . 'includes/Options.php';
require_once WZ_CORE_PATH . 'includes/Access.php';
require_once WZ_CORE_PATH . 'includes/Rest.php';
require_once WZ_CORE_PATH . 'includes/Emails.php';
require_once WZ_CORE_PATH . 'includes/Sitemaps.php';
require_once WZ_CORE_PATH . 'includes/CLI.php';

Plugin::init();
