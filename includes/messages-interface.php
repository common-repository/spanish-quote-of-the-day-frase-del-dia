<?php
/*
 * Plugin:      Spanish Quotes of the Day (Frase del Día)
 * Path:        /includes
 * File:        messages-interface.php
 * Since:       1.3.0
 */

/*
 * Class:		spn_quote_msg
 * Version:		1.3.0.1
 * Since:		1.2.0
 * Description: This class shows all messages for the Spanish Quotes plugin interface if the back-end. Plugin update or activation, alerts, errors, settings, etc.
 */

// Messages Class 
class spn_quote_msg {

	// Open block of messages
	static function msg_ini ( $args = array() ) {
		$id 			= ( ! isset ( $args['class'] ) ? 'id="message"' : '' );
		$args['class'] 	= ( ! isset ( $args['class'] ) ? 'updated notice notice-success is-dismissible' : $args['class'] );

		return '<div ' . $id . ' class="' . $args['class'] . '" >';
	}
	
	// Close block of messages
	static function msg_end ( $args = array() ) {
		return '<br /></div>';
	}

	// On activation plugin messages
	static function msg_activated ( $args = array() ) {
		return 
		sprintf (
			__( '<p><strong>%s</strong> %s <strong>%s</strong> %s.</p>', 'spanish-quote-of-the-day-frase-del-dia' ),
			__('Spanish Quote of the Day', 'spanish-quote-of-the-day-frase-del-dia' ),
			__('version', 'spanish-quote-of-the-day-frase-del-dia' ),
			__SQOD_VER__,
			__( 'was succesfully activated', 'spanish-quote-of-the-day-frase-del-dia' )
		);
	}

	// On updated plugin messages
	static function msg_updated ( $args = array() ) {
		return
		sprintf (
			 __( '<p><strong>%s</strong> %s <strong>%s</strong>.</p>', 'spanish-quote-of-the-day-frase-del-dia' ),
			 __('Spanish Quote of the Day', 'spanish-quote-of-the-day-frase-del-dia' ), 
			 __('was succesfully updated to the version', 'spanish-quote-of-the-day-frase-del-dia' ), 
			 __SQOD_VER__
		);
	}

	// Operating modes ( Widget, Shortcode, Function ) header section 
	static function msg_operating_modes ( $args = array() ) {
		return
		sprintf ( 
			'<h3>%s</h3>', 
			__( 'Operating Modes', 'spanish-quote-of-the-day-frase-del-dia' ) 
		);
	}

	// Operating modes ( Widget, Shortcode, Function ) header section 
	static function msg_operating_modes_intro ( $args = array() ) {
		return
		sprintf ( '<p>%s</p>', 
			sprintf( __( 'You can show a random <strong>%s</strong> in three diferent ways:', 'spanish-quote-of-the-day-frase-del-dia' ),  
				__( 'Spanish Quote of the Day', 'spanish-quote-of-the-day-frase-del-dia' ) 
			)
		)
		. '<ol class="spnq-normal-list"> ' 
		. '<li> ' . __( 'in the sidebars of your WP Theme using the <b>Widget</b> of the plugin', 'spanish-quote-of-the-day-frase-del-dia' ) . '</li>' 
		. '<li> ' . __( 'inside the content of any Post or Page using the <b>Shortcode</b>', 'spanish-quote-of-the-day-frase-del-dia' ) . '</li>' 
		. '<li> ' . __( 'in any place of your WP Themes templates via the wp function <code>do_shortcode()</code>', 'spanish-quote-of-the-day-frase-del-dia' ) . '</li>' 
		. '</ol> ';

	}

	// Widget Mode Explanation
	static function msg_widget ( $args = array() ) {
		$out  = sprintf( 
					'<h4>%s</h4>', 
					__('1.- Widget', 'spanish-quote-of-the-day-frase-del-dia' )
				);
		$out .= sprintf( 
					__( '<p>%s <a href="%s" target="_blank"><strong>%s</strong></a> %s <strong>%s</strong> %s.</p>', 'spanish-quote-of-the-day-frase-del-dia' ), 
					__('To show Spanish Quotes of the Day in the sidebars of your WP Theme, go to Appearance >', 'spanish-quote-of-the-day-frase-del-dia' ), 
					admin_url('widgets.php'), 
					__('Widgets', 'spanish-quote-of-the-day-frase-del-dia' ),
					__('and add the widget', 'spanish-quote-of-the-day-frase-del-dia' ),
					__('Spanish Quote of the Day', 'spanish-quote-of-the-day-frase-del-dia' ),
					__('where you prefer', 'spanish-quote-of-the-day-frase-del-dia' )
				);

		$out .= '<p>';
		$out .= __( 'A new <i>random</i> Spanish Quote will appear in the sidebar automatically and it will we different each time the page is showed.', 'spanish-quote-of-the-day-frase-del-dia' );
		$out .= '</p>';

		return $out;		
	}

	static function msg_mode_widget_image ( $args = array() ) {
		$out  = '<div class="images-widget-mode two">';
		$out .= '<img src="' . __SQOD_URL__ . '/images/mode-widget.jpg" />';
		$out .= '<img src="' . __SQOD_URL__ . '/images/mode-widget-example.jpg" />';
		$out .= '</div>';
		return $out;
	}

	// Shortcode Mode Explanation
	static function msg_shortcode ( $args = array() ) {
		$out  = sprintf( 
					'<h4>%s</h4>', 
					__('2.- Shortcode', 'spanish-quote-of-the-day-frase-del-dia' )
				);
		$out .= '<p>';
		$out .= sprintf(
					'%s.', 
					__('To show a random Spanish Quotes inside your Posts, Pages or Custom Post Types simply add the shortcode <code>[spanish_quote]</code> in any place of the post content using the visual editor', 'spanish-quote-of-the-day-frase-del-dia' )
				);
		$out .= '</p>';

		$out .= '<p>';
		$out .= sprintf(
					'%s.', 
					__('Each time you display your Post, a different Spanish Quote will appear on the screen', 'spanish-quote-of-the-day-frase-del-dia' )
				);
		$out .= '</p>';

		$out .= '<p>';
		if ( WPLANG != 'en_US' ) {
			$out .= sprintf( 
						__( ' %s <strong>%s</strong> %s <code>[%s]</code>. %s.', 'spanish-quote-of-the-day-frase-del-dia' ), 
						__('Remember that, in the translated versions of Wordpress, you have also got a translated version of the shortcode, that in your local language', 'spanish-quote-of-the-day-frase-del-dia' ),
						WPLANG,
						__('is', 'spanish-quote-of-the-day-frase-del-dia' ),
						_x('spanish_quote', 'Translation of the shortcode name to local language', 'spanish-quote-of-the-day-frase-del-dia' ),
						__('Both of them are available', 'spanish-quote-of-the-day-frase-del-dia' )
					);
		}
		
		$out .= sprintf (
					' <a href="http://codex.wordpress.org/Shortcode" title="%s" target="_blank">%s</a>.', 
					__('See the complete documentation of Shorcodes in Wordpress.org', 'spanish-quote-of-the-day-frase-del-dia' ),
					__('Wordpress Shortcodes', 'spanish-quote-of-the-day-frase-del-dia' )
				);
		$out .= '</p>';

		return $out;
	}

	static function msg_shortcode_image ( $args = array() ) {
		$out  = '<div class="images-widget-mode two">';
		$out .= '<img src="' . __SQOD_URL__ . '/images/mode-shortcode.jpg" />';
		$out .= '<img src="' . __SQOD_URL__ . '/images/mode-shortcode-example.jpg" />';
		$out .= '</div>';
		return $out;
	}


	// Function Mode Explanation
	static function msg_calling_plugin_via_function ( $args = array() ) {
		$out  = sprintf ( 
					'<h4>%s</h4>', 
					__('3.- Calling to the plugin via function', 'spanish-quote-of-the-day-frase-del-dia' )
				);
		$out .= sprintf ( 
					__( '<p>%s <strong>%s</strong> %s <a href="http://codex.wordpress.org/Function_Reference/do_shortcode" title="%s" _target="_blank">%s</a> %s</p>', 'spanish-quote-of-the-day-frase-del-dia' ),
					__('Finally, if you are one of those who believe that <em>Code is Poetry</em>, remeber that you can add', 'spanish-quote-of-the-day-frase-del-dia' ),
					__('Spanish Quote of the Day', 'spanish-quote-of-the-day-frase-del-dia' ),
					__('in everyplace of your website with the function', 'spanish-quote-of-the-day-frase-del-dia' ),
					__('See the complete documentation of do_shortcode() in Wordpress.org', 'spanish-quote-of-the-day-frase-del-dia' ),
					__('do_shortcode()', 'spanish-quote-of-the-day-frase-del-dia' ), 
					__('that you can insert in any of your theme templates (simple.php, index.php, etc.) using this next code:', 'spanish-quote-of-the-day-frase-del-dia' )
				);
		$out .= '<pre style="background-color:#fAFAFA;padding:2em;">';
		$out .= sprintf ( '%s', '<span style="color:#f00; font-weight:bold">&lt;?php</span> <span style="color:#00F">echo</span> do_shortcode(<span style="color:#C00">\'[spanish_quote]\'</span>); <span style="color:#f00; font-weight:bold">?&gt;</span>' );
		$out .= '</pre>';
		$out .= '<p>';
		$out .= sprintf(
					'%s.', 
					__('By the way, for showing the quotes, instead of using <code>do_shortcode()</code> perhaps you are tempted to call directly the internal plugin function that fetches and shows the random Spanish Quotes... You can do it but you shouldn\'t because a) in future versions of the plugin, the internal plugin function could change its name, ubication or parameters while that the shorcode will be always kept invariant and b) you can\'t activate the asynchronous operation mode of the plugin in a ease way... You decide', 'spanish-quote-of-the-day-frase-del-dia' )
				);
		$out .= '</p>';

		return $out;
	}

	// Settings Page Message
	static function msg_settings_page ( $args = array() ) {
		$out  = sprintf(
					'<h3>%s</h3>',
					__('Settings Page', 'spanish-quote-of-the-day-frase-del-dia' )
				);
		$out .= sprintf(
					__( '<p>%s <a href="%s" target="_blank"><strong>%s</strong></a>. %s.</p>', 'spanish-quote-of-the-day-frase-del-dia' ), 
					__('To modify the plugin\'s settings, go to Settings >', 'spanish-quote-of-the-day-frase-del-dia' ),
					admin_url( 'options-general.php?page=spanish_quotes_settings'),
					__('Spanish Quotes' , 'spanish-quote-of-the-day-frase-del-dia' ),
					sprintf ( __( 'You also find the basic <a href="%s">Instructions</a> of the various <strong>operating modes</strong>', 'spanish-quote-of-the-day-frase-del-dia' ), admin_url( 'options-general.php?page=spanish_quotes_settings#tab-instructions') )
				);
		return $out;		
	}
	
	// Documentation message
	static function msg_documentation ( $args = array() ) {
		$out  = sprintf ( 
					'<h3>%s</h3>', 
					__('Documentation', 'spanish-quote-of-the-day-frase-del-dia' ) 
				);
		$out .= sprintf (
					'<p>%1$s <a href="http://www.joanmiquelviade.com/plugin/spanish-quote-of-the-day/" title="%2$s" target="_blank">%2$s</a> %3$s <a href="http://wordpress.org/plugins/spanish-quote-of-the-day-frase-del-dia/" title="%4$s" target="_blank">%4$s</a>.</p>', 
					__( 'For further information, please, see complete documentacion in the ', 'spanish-quote-of-the-day-frase-del-dia' ),
					__( 'Author\'s plugin page', 'spanish-quote-of-the-day-frase-del-dia' ), 
					__( 'or an abridget version in the', 'spanish-quote-of-the-day-frase-del-dia' ),
					__( 'WordPress plugin page', 'spanish-quote-of-the-day-frase-del-dia' ) 
				);
		return $out;		
	}

	// What is new header section 
	static function msg_what_is_new ( $args = array() ) {
		return sprintf ( '<h3>%s %s</h3>', __('What\'s new in version', 'spanish-quote-of-the-day-frase-del-dia' ), __SQOD_VER__ );
	}


	/*************************************************************************************************************
	 *
	 * SECTION: What's new in version X messages
	 *
	 */

	// v 1.4.0 - New Settings Page
	static function msg_new_settings_help_page ( $args = array() ) {
		
		$out  = sprintf ( '<h4>%s</h4>',  __('New Help in Setting Page', 'spanish-quote-of-the-day-frase-del-dia' ));
		$out .= sprintf ( __( '<p>In this version, the help of <strong><a href="%s">Settings Page</a></strong> has been completely rebuilt, including help images that show how to operate easyly with the plugin in all operation modes.', 'spanish-quote-of-the-day-frase-del-dia' ), admin_url( 'options-general.php?page=spanish_quotes_settings') );
		return $out;
		
	}

	// v 1.4.0 - Improving Server Side Performance
	static function msg_server_site_performance ( $args = array() ) {
		
		$out  = sprintf ( '<h4>%s</h4>',  __('Server Site Performance', 'spanish-quote-of-the-day-frase-del-dia' ));
		$out .= '<p>';
		$out .= sprintf ( __( 'The server side of the plugin (the plugin fetches random Spanish Quotes from <strong><a href="%s" target="_blank">Todopensamientos.com</a></strong>) has been completely rebuilt, improving the response times in more than %s.', 'spanish-quote-of-the-day-frase-del-dia' ), 
			'http://todopensamientos.com', '50%' );
		$out .= '</p>';
		return $out;
		
	}

	// v 1.3.0 - New Settings Page
	static function msg_new_sttings_page ( $args = array() ) {
		
		$out  = sprintf ( '<h4>%s</h4>',  __('New Setting Page', 'spanish-quote-of-the-day-frase-del-dia' ));
		$out .= sprintf ( __( '<p>In this version, the <strong><a href="%s">Settings Page</a></strong> has been completely rebuilt, adding an interface with tabs for a better parameters organization and for an easier updating of the future <strong>Spanish Quote of the Day</strong> versions.</p>', 'spanish-quote-of-the-day-frase-del-dia' ), admin_url( 'options-general.php?page=spanish_quotes_settings') );
		return $out;
		
	}

	// v 1.3.0 - New Settings Page
	static function msg_css_parameter ( $args = array() ) {
		
		$out  = sprintf ( '<h4>%s</h4>',  __('New Custom CSS parameter', 'spanish-quote-of-the-day-frase-del-dia' ));
		$out .= __( '<p>The new parameter <strong>Custom CSS</strong> allows you to add easily your own CCS rules for the quotes output without any additional code.</p>', 'spanish-quote-of-the-day-frase-del-dia' );
		return $out;
		
	}

	// v 1.2.2 - Maximum Quote Control, general
	static function msg_maximum_length ( $args = array() ) {
		$out  = sprintf ( '<h4>%s</h4>',  __( 'Maximum length control', 'spanish-quote-of-the-day-frase-del-dia' ));
		$out .= sprintf ( '<p>%s <a href="http://todopensamientos.com" target="_blank" title="%s"><strong>%s</strong></a>.<br />%s</p>',
		 
						  __('Until now, the maximun length for the quotes was permanently set to <strong>275</strong> characters but now, if you want, you can receive longer or shorter quotes from' , 'spanish-quote-of-the-day-frase-del-dia' ), 
						  __( 'Theme classified notable quotes in spanish | TodoPensamientos', 'spanish-quote-of-the-day-frase-del-dia' ),
						  'Todopensamientos.com',
						  __('Please, go to <strong>Settings Page</strong> to choose the <strong>maximum length</strong> of the quotes.', 'spanish-quote-of-the-day-frase-del-dia' )
						  );
		return $out;
	}

	// v 1.4.0 - CSS Examples
	static function msg_show_css_examples ( $args = array() ) {

		$out   = sprintf ( '<h3>%s</h3>',  __( 'CSS Examples Gallery', 'spanish-quote-of-the-day-frase-del-dia' ) );
		$out  .= '<p>';
		$out  .= __( 'Here you are some example that how you can improve the shape and style of the random Spanish Quote inside your WP Themes.', 'spanish-quote-of-the-day-frase-del-dia' );
		$out  .= '</p>';
		$out  .= '<p>';
		$out  .= sprintf( __( 'You can also check out the <a href="%s" target="_blank">Examples page of the plugin\'s author</a> to see the plugin in real-time in a variety of ways. Don\'t be afraid of changing the basic CSS.', 'spanish-quote-of-the-day-frase-del-dia' ), 'http://www.joanmiquelviade.com/plugin/spanish-quote-of-the-day/examples-gallery/' );
		$out  .= '</p>';
		return $out;

	}

	// v 1.4.0 - CSS Examples
	static function msg_show_css_examples_images ( $args = array() ) {
		$out  = '<div class="images-widget-mode two">';
		$out .= '<img src="' . __SQOD_URL__ . '/images/Plugin-Spanish-Quote-of-the-Day-Widget-Footer-2.jpg" />';
		$out .= '<img src="' . __SQOD_URL__ . '/images/Plugin-Spanish-Quote-of-the-Day-Shortcode-Use-01.jpg" />';
		$out .= '<img src="' . __SQOD_URL__ . '/images/Plugin-Spanish-Quote-of-the-Day-Sidebar-Use-1.jpg" />';
		$out .= '<img src="' . __SQOD_URL__ . '/images/Examples-01.jpg" />';
		$out .= '</div>';
		return $out;
	}


	// Messages dispatcher function
	static function show_msg ( $message, $args = array(), $echo = TRUE ) {

		$name = 'msg_' . str_replace ( '-', '_', $message );
		$out  = spn_quote_msg::$name ( $args );
		if ( $echo )
			echo $out;
		else
		    return $out;
	
	}

}