<?php
/*
Plugin Name: Spanish Quotes of the Day (Frase del Día)
Plugin URI:  http://www.joanmiquelviade.com/plugin/spanish-quote-of-the-day/
Description: Spanish Quote of the Day automatically shows a random spanish quote inside your WordPress themes from the Todopensamientos quotes database. It's not necessary that you have your own database of quotes, Spanish Quote of the Day gives them to you. Simple put the Widget Spanish Quote of the Day in any of your theme sidebars; its operation is automatic.
Version:     1.4.0
Author:      Joan Miquel Viadé
Author URI:  http://www.joanmiquelviade.com
License:     GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages 
Text Domain: spanish-quote-of-the-day-frase-del-dia
Tags:        quotes, quote of the day, random quotes, spanish quotes, frase del dia, frases, frases célebres
*/
?>
<?php
// initialize version number
$sqod_ver = '1.4.0';
define ( '__SQOD_VER__', $sqod_ver );
define ( '__SQOD_URL__', untrailingslashit( plugin_dir_url(__FILE__) ),  TRUE );
define ( '__SQOD_ABS__', untrailingslashit( plugin_dir_path(__FILE__) ), TRUE );
require_once( __SQOD_ABS__ . '/includes/messages-interface.php' );
require_once( __SQOD_ABS__ . '/includes/backend-interface.php' );
require_once( __SQOD_ABS__ . '/includes/widget-interface.php' );

if ( is_admin() ) {
	new sqod_backend_interface;
}

// Register and load the widget
function quotes_load_widget() {
	register_widget( 'sqod_widget' );
}
add_action( 'widgets_init', 'quotes_load_widget', 10, 0 );

// Initial message on activation
register_activation_hook( __FILE__ , array( 'sqod_backend_interface', 'on_activation' ));
add_action ('admin_notices', 		 array( 'sqod_backend_interface', 'on_activation_msg'));

// Loading translations

function load_translations() {
	
//	$a = load_plugin_textdomain( 'spanish-quote-of-the-day-frase-del-dia', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	load_plugin_textdomain( 'spanish-quote-of-the-day-frase-del-dia' );

}
add_action('plugins_loaded', 'load_translations');
