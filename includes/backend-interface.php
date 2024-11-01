<?php
/*
 * Plugin:      Spanish Quotes of the Day (Frase del Día)
 * Path:        /includes
 * File:        backend-interface.php
 * Since:       1.3.0
 */
 
/*
 * Class:       sqod_backend_interface
 * Version:     1.4.0
 * Since:       1.2.0
 * Description: This class shows and controls the Spanish Quotes interface for the back-end.
 */

// Back-End Interface Class 
class sqod_backend_interface {
	
	public $options;
	public $pageTitle;
	public $menuTitle;
	
	// Construction
	function __construct() {
		
		add_action( 'admin_menu',		array( $this, 'spanish_quotes_menu_init' ) );
		add_action( 'admin_init',		array( $this, 'spanish_quotes_settings_init' ) );
		add_action( 'current_screen',	array( $this, 'load_admin_interface' ), 10, 1 );

		$this->options 		= get_option ( 'cool-quotes-params' );
		$this->pageTitle	= _x( 'Spanish Quotes of the Day', 'settings page title', 'spanish-quote-of-the-day-frase-del-dia' );
		$this->menuTitle	= _x( 'Spanish Quotes', 		   'settings menu title', 'spanish-quote-of-the-day-frase-del-dia' );
		
	}

	// Checking page and loading Back-End environment
	public function load_admin_interface( $screen ) {
		
		if ( $screen->base == 'settings_page_spanish_quotes_settings' ) {
			add_action ( "load-$screen->base", array ( $this, 'backend_scripts_and_styles' ), 10, 0 );
		}
		
	}

	// Actions for enqueueing Scripts and Styles
	public function backend_scripts_and_styles () {
		
		add_action ( 'admin_enqueue_scripts', array ( $this, 'register_backend_scripts' ) );
		add_action ( 'admin_enqueue_scripts', array ( $this, 'register_backend_styles' ) );
		
	}

	// Script(s)
	public function register_backend_scripts () {
		wp_enqueue_script ( 'backend-spanish-quotes', __SQOD_URL__ . '/js/backend-interface.js', array('jquery-ui-tabs' ), __SQOD_VER__, TRUE );
	}

	// Style(s)
	public function register_backend_styles () {
		wp_enqueue_style ( 'backend-spanish-quotes', __SQOD_URL__ . '/css/backend-interface.css', '', __SQOD_VER__, 'all' );
	}

	// Register array setting	
	function spanish_quotes_settings_init() {
		register_setting( 'spanish_quotes_settings', 'cool-quotes-params' );
	}

	// for DEBUG mode or future callbacks
	function spnq_general_setting_section_callback() {
	}

	// cool-quotes-params
	//    Filter the_content (ON/OFF) 
	function spnq_apply_the_content_filter_callback () {

		$value = $this->options['use_the_content_filter'];

		echo '</p>
		<tr>';
		echo '<th scope="row">';
		echo __( 'WP filter <em>the_content</em>' , 'spanish-quote-of-the-day-frase-del-dia');
		echo '</th>';

		echo '<td>';
		echo '<fieldset>';
		echo '<legend class="screen-reader-text"><span>' . __( 'WP filter the content' , 'spanish-quote-of-the-day-frase-del-dia') . '</span></legend>';
		
		echo '<label for="cool-quotes-params[use_the_content_filter]" >';
		echo '<input type="hidden" name="cool-quotes-params[use_the_content_filter]" value="0" >';
		echo '<input name="cool-quotes-params[use_the_content_filter]" id="spnq_use_the_content_filter_id" type="checkbox" value="1" class="code" ' . checked( TRUE, $value, false ) . ' />';
		echo __('Check this field if you want to apply the WP filter <code>the_content</code> to the quote text before displaying it.', 'spanish-quote-of-the-day-frase-del-dia');
		echo '<p class="description">' . __( 'The WP filter <code>the_content</code> adds HTML paragraphs and applies styles to the raw string of quote text.', 'spanish-quote-of-the-day-frase-del-dia') .'</p>';
		
		echo '</label>';
		
		echo '</fieldset>';
		echo '</td>';
		echo '</tr>';

	}
	
	// cool-quotes-params 
	//    Custom CSS
	function spnq_custom_css_field_callback() {

		$text = $this->options['custom_css_field'];

		echo '<tr>';
		echo '<th scope="row">';
		echo '<label for="cool-quotes-params[custom_css_field]" >' . __('Custom CSS', 'spanish-quote-of-the-day-frase-del-dia') . '</label>';
		echo '</th>';
		
		echo '<td>';
		echo '<textarea id="spnq_custom_css_field_id" name="cool-quotes-params[custom_css_field]" value="' . $text . '" class="code" rows="6" cols="80" />' . $text . '</textarea>';
		echo '<p class="description">'. __('Enter your Custom CSS', 'spanish-quote-of-the-day-frase-del-dia') . '</p>';
		echo '</td>';
		echo '</tr>';

	}
	
	// cool-quotes-params 
	//    Quote Length
	function spnq_quote_length_field_callback() {
		
		$length = $this->options['quote_length_field'];
		if ( $length == '' ) $length = 275;
		
		echo '<tr>';
		echo '<th scope="row">';
		echo '<label for="cool-quotes-params[quote_length_field]" >' . __( 'Maximum Length', 'spanish-quote-of-the-day-frase-del-dia' ) . '</label>';
		echo '</th>';
		
		echo '<td>';
		echo '<input name="cool-quotes-params[quote_length_field]" id="spnq_quote_length_field_id" type="range" value="' . $length . '" class="range" min="50" max="2500" step="1" />';
		echo '<input id="spnq_quote_length_field_id_number" type="number" value="' . $length . '" class="number as-range-output" min="50" max="2500" step="1" />';
		echo '<p class="description">' . __( 'Choose the maximum length for the quotes in <strong>characters</strong>. Default value, <strong>275</strong>.', 'spanish-quote-of-the-day-frase-del-dia') . '</p>';
		echo '<p class="description">' . __( 'The minimum length is set to 50 characters, and the maximum length, 2500, is equivalent to a 5 paragraphs text. Usual values are between 250 and 600 characters.', 'spanish-quote-of-the-day-frase-del-dia') . '</p>';
		echo '</td>';
		echo '</tr>';
		
	}

	// cool-quotes-params 
	//    Asynchronous mode (ON/OFF)
	function spnq_async_mode_field_callback() {

		$value = $this->options['async_mode_field'];

		echo '<tr>';
		echo '<th scope="row">';
		echo __('Asyncronous Fetching', 'spanish-quote-of-the-day-frase-del-dia');
		echo '</th>';

		echo '<td>';
		echo '<fieldset>';
		echo '<legend class="screen-reader-text"><span>' . __('Asyncronous Mode', 'spanish-quote-of-the-day-frase-del-dia') . '</span></legend>';
		
		echo '<label for="cool-quotes-params[async_mode_field]" >';
		echo '<input type="hidden" name="cool-quotes-params[async_mode_field]" value="0" >';
		echo '<input name="cool-quotes-params[async_mode_field]" id="spnq_async_mode_field_id" type="checkbox" value="1" class="code" ' . checked( TRUE, $value, false ) . ' />';
		echo __('Check this field to activate the asynchronous fetching operation mode.', 'spanish-quote-of-the-day-frase-del-dia');

		echo '<p class="description" >' . __('The Asynchronous Fetching Operation Mode produces a better average page load performance however, this mode could be <strong>incompatible with some client side systems</strong> and, in addition, some times it\'s a much less stable. We advise you <strong>do not activate</strong> the asynchronous mode unless your website <strong>actually</strong> has a high level of hits per day (>40,000). By default, the asynchronous fetching operation mode is disabled.', 'spanish-quote-of-the-day-frase-del-dia') . '</p>';
		
		echo '</label>';
		
		echo '</fieldset>';
		echo '</td>';
		echo '</tr>';
		

	}
	
	// Adding the settings submenu page
 	function spanish_quotes_menu_init () {
		
		add_options_page(	$this->pageTitle, 
							$this->menuTitle,
							'manage_options', 
							'spanish_quotes_settings', 
						 	array( $this, 'spanish_quotes_render_settings_page' ) 
						);
		
	}

	// Rendering the page
	function  spanish_quotes_render_settings_page () {

		echo '<div class="wrap">';
		echo '<h2>' . $this->pageTitle . '</h2>';
		
        echo '<form id="spnq-form" id="spnq-form" action="options.php" method="POST">';
		
		    echo '<ul>';
				echo '<li><h3><a href="#tab-global" class="nav-tab">' . __( 'Global Options', 'spanish-quote-of-the-day-frase-del-dia' ) . '</a></h3></li>';
				echo '<li><h3><a href="#tab-style"  class="nav-tab">' . __( 'Style Options', 'spanish-quote-of-the-day-frase-del-dia' ) . '</a></h3></li>';
				echo '<li><h3><a href="#tab-instructions" class="nav-tab">' . __( 'Help', 'spanish-quote-of-the-day-frase-del-dia' ) . '</a></h3></li>';
		    echo '</ul>';
			
			echo '<div id="tab-global" >';
				echo '<table class="form-table">';
				echo '<tbody>';
				$this->spnq_quote_length_field_callback();
				$this->spnq_async_mode_field_callback();
				echo '</tbody>';
				echo '</table>';
			echo '</div>';
			
			echo '<div id="tab-style" >';
				echo '<table class="form-table">';
				echo '<tbody>';
				$this->spnq_apply_the_content_filter_callback();
				$this->spnq_custom_css_field_callback();
				echo '</tbody>';
				echo '</table>';

				spn_quote_msg::show_msg ( 'show-css-examples' );
				spn_quote_msg::show_msg ( 'show-css-examples-images' );

			echo '</div>';
			
			echo '<div id="tab-instructions" >';

					spn_quote_msg::show_msg ( 'ini', array( 'class' => 'spnq-instructions' ) );
					spn_quote_msg::show_msg ( 'operating-modes' );
					spn_quote_msg::show_msg ( 'operating-modes-intro' );

					spn_quote_msg::show_msg ( 'widget' );
					spn_quote_msg::show_msg ( 'mode-widget-image' );

					spn_quote_msg::show_msg ( 'shortcode' );
					spn_quote_msg::show_msg ( 'shortcode-image' );

					spn_quote_msg::show_msg ( 'calling-plugin-via-function' );
					spn_quote_msg::show_msg ( 'documentation' );
					spn_quote_msg::show_msg ( 'end' );
			
			echo '</div>';
			
	        settings_fields( 'spanish_quotes_settings' );
	        submit_button();
			
        echo '</form><!-- "form" -->';
		echo '</div><!-- ".wrap" -->';
		
	}

	// Only show basic documentation on activation
	static function on_activation() {
		add_option ('cool-quotes', 'installed' );
	}

	// To create the activation message
	static function on_activation_msg () {
		
		$a = get_option ('cool-quotes');
		if ( $a ) {
			
			spn_quote_msg::show_msg ( 'ini' );
			spn_quote_msg::show_msg ( 'activated' );
			spn_quote_msg::show_msg ( 'settings-page' );
			spn_quote_msg::show_msg ( 'documentation' );
			spn_quote_msg::show_msg ( 'end' );
			
			delete_option ('cool-quotes');
			update_option ('cool-quotes-ver', __SQOD_VER__ );
			
		} else {
			
			$a = get_option ('cool-quotes-ver');
			 if ( ( $a == '' ) || version_compare ( __SQOD_VER__, $a, '>' ) ) {
	
				spn_quote_msg::show_msg ( 'ini' );
				spn_quote_msg::show_msg ( 'updated' );
				spn_quote_msg::show_msg ( 'what-is-new' );
					spn_quote_msg::show_msg ( 'new-settings-help-page' );
//					spn_quote_msg::show_msg ( 'css-parameter' );
					spn_quote_msg::show_msg ( 'server-site-performance' );
					
				spn_quote_msg::show_msg ( 'settings-page' );
				spn_quote_msg::show_msg ( 'documentation' );
				spn_quote_msg::show_msg ( 'end' );
				
				update_option ('cool-quotes-ver', __SQOD_VER__ );
				
				// Call module Updating variables in case of
				sqod_backend_interface::check_upgrade_settings ( __SQOD_VER__, $a  );
				
			}
		
		}
		
	}
	
	// Updating or changing global variables in case of version X.Y.Z
	static function check_upgrade_settings ( $version, $old ) {
		
		if ( get_option ( 'cool-quotes-params' ) === FALSE ) {
			$length = get_option ( 'spnq_quote_length_field' );
			$asynch = get_option ( 'spnq_async_mode_field'   );
			$css    = get_option ( 'spnq_custom_css_field'   );
			$out = array ( 
						'quote_length_field' => $length,
						'async_mode_field'   => $asynch,
						'custom_css_field'   => $css,
						'use_the_content_filter' => 0
				   );
			add_option ( 'cool-quotes-params', $out );
		}
		
	}

}
