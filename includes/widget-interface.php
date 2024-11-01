<?php
/*
 * Plugin :     Spanish Quotes of the Day (Frase del Día)
 * Path:        /includes
 * File:        widget-interface.php
 * Since:       1.3.0
 */

/*
 * Class:		sqod_widget
 * Version:     1.3.0.1
 * Since:       1.0.0
 * Description: This class creates, controls the widget for the Spanish Quotes. Each time that this Widget is called, it fetches a random spanish
 *              quote from http://todopensamientos.com. The widget has got two work modes, synchronous and asynchronous -via javascript call- to 
 *              connect with todopensamientos and to fetch a quote. 
 */
 
// Widget Class 
class sqod_widget extends WP_Widget {

	public $version 		 = __SQOD_VER__;
	public $force_inline_css = FALSE;
	public $options;
	
	// Construction
	public function __construct( ) {

		// Getting the settings (an array)
		$this->options	= get_option( 'cool-quotes-params' );
		
		// Basic variables for translated versions of the Widget
		$title 			= _x( 'Spanish Quotes of the Day', 'widget box name', 'spanish-quote-of-the-day-frase-del-dia' );
		$description 	= _x( 'Add a random Quote of the Day in spanish to your website.', 'widget box description', 'spanish-quote-of-the-day-frase-del-dia' );
		$shortcode      = _x( 'spanish_quote', 'plugin shortcode to translate to your local language', 'spanish-quote-of-the-day-frase-del-dia' );
		
		// Constructing the widget
		parent::__construct( 'sqod_quotes', $title, array( 'description' => $description ) );
		
		// In front-end Wordpress load, we add the mininum styles for quotes
		if ( ! is_admin() ) 
			add_action ( 'wp_enqueue_scripts', array( $this, 'ini_interface' ), 10, 0 );
		if ( $async_mode = $this->options['async_mode_field'] ) {
			add_action ( 'wp_head', array( $this, 'output_async_mode_vars'), 99, 0 );
		}

		// the initial shortcode 'spanish_quote' is always available
		add_shortcode ( 'spanish_quote', array( $this, 'quotes_shortcode' ));
		// adding a shorcode translated to the local language
		if ( ( substr( WPLANG, 0, 2 ) != 'en' ) && ( $shortcode != 'spanish_quote' ) )
			add_shortcode ( $shortcode, array( $this, 'quotes_shortcode' ));

		// Fornating the output
		add_filter ( 'widget_quotes', array( 'sqod_widget', 'cook_quotes' ), 1, 3 );
		add_filter ( 'post_quotes',	  array( 'sqod_widget', 'cook_quotes' ), 1, 3 );
		
		/*
		 * Only for documentation purposes
		 *
		 * if you need to remove the basic filter for a complete restyling of quotes, you
		 * can use these next instrucctions. But, be careful.
		 */
		//	remove_filter ( 'widget_quotes', array( 'sqod_widget', 'cook_quotes' ), 1, 3 );
		//	remove_filter ( 'post_quotes',   array( 'sqod_widget', 'cook_quotes' ), 1, 3 );

	}

	// Output the array name of quote DIVs in case of asynchronous mode in <HEAD></HEAD>
	public function output_async_mode_vars () {
?>
<script type="text/javascript">/* <![CDATA[ */ var quoteSeed = new Array(); /* ]]> */</script>
<?php
	}

	// Enqueueing plugin CSS's
	public function ini_interface () {

		global $wp_version;

		// Enqueueing Standard CSS
		wp_register_style( "spanish-quotes", plugins_url( '../css/spanish-quotes.css' , __FILE__ ), array(), __SQOD_VER__, 'all' );
		wp_enqueue_style( "spanish-quotes" );
		
		// Prepare enqueueing of Custom CSS after Standard CSS
		if ( version_compare ( $wp_version, '3.3.0', '<' ) ) {
			$this->force_inline_css = TRUE;
			add_action ( 'wp_print_scripts',   array( $this, 'custom_css' ), 10, 0 );
		} else {
			add_action ( 'wp_enqueue_scripts', array( $this, 'custom_css' ), 99, 0 );
		}

	}

	// Enqueueing Plugin Scripts 
	// Enqueueing Custom CSS after standard plugin CSS
	public function custom_css() {

		// Scripts
		if ( $this->options['async_mode_field'] ) {
			wp_register_script ( 'quotes-asynchronous-script', __SQOD_URL__ . '/js/asynchronous-interface.js', array ( 'jquery' ), __SQOD_VER__, TRUE );
			$translation_array = array(
				'length'      => $this->options['quote_length_field'],
				'filterMode'  => $this->options['use_the_content_filter'],
				'atitle'      => __( 'Quotes of', 'spanish-quote-of-the-day-frase-del-dia' )
			);
			wp_localize_script( 'quotes-asynchronous-script', 'quoteVars', $translation_array );
			wp_enqueue_script  ( 'quotes-asynchronous-script' );
		}

		// Custom CSS
		$text = $this->options['custom_css_field'];
		
		if ( !empty( $text ) ) { 
			if ( $this->force_inline_css ) {
				echo "<style type='text/css'>" . "\n";
				echo '/* INI spanish quotes custom styles */' . "\n";
				echo $text . "\n";
				echo '/* END spanish quotes custom styles */' . "\n";
				echo '</style>' . "\n";
			} else {
				wp_add_inline_style( 'spanish-quotes', '/* INI spanish_quotes-custom-style */' );
				wp_add_inline_style( 'spanish-quotes', $text );
				wp_add_inline_style( 'spanish-quotes', '/* END spanish_quotes-custom-style */' );
			}
			
		}
		
	}
	
	// Widget Back-End 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = _x( 'Spanish Quote of the Day', 'wigdet default title', 'spanish-quote-of-the-day-frase-del-dia' );
		}
		// the Widget admin form
		echo '<p>';
		echo '<label for="' . $this->get_field_id( 'title' ) .'">'. __( 'Title' ) . '</label>';
		echo '<input class="widefat" id="'. $this->get_field_id( 'title' ) .'" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</p>';
	}
		
	// Updating Widget
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
		
	}
	
	
	/******************************************************************************************************************************
	 *
	 * Fecthing the random Quote 
	 *
	 */

	// The oEmbed call 
	public function fetch_quotes() {

		static $loop = 0;

		// In asysnchronous mode we send the javascript code with as a response
		if ( $this->options['async_mode_field'] ) {
			
			// Seed() generates a unique random indentifier for each quote block to the jQuery recognition in a multiuse / multicall environments
			$seed = rand(100, 999);
			
// Dump the jQuery vars for identifying DIVs id attribute
?>
<script type="text/javascript">quoteSeed[<?php echo ++$loop; ?>] = <?php echo $seed; ?>;</script>
<?php

			// Sending just the <DIV></DIV> with a random numbered id
			return '<div id="quote-' . $seed . '" class="spn-quote-seed" >';

		// In synchronous mode we send the Oembed Response	
		} else {
 
			global $post;

			// Maximun length for quotes
			$length   = ( ( $this->options['quote_length_field'] ) ? 275 : $this->options['quote_length_field'] );

			// Fetching the Spanish Quote in raw
			// This call doesn't use the RESPONSE API
			$response = json_decode( trim( wp_remote_retrieve_body( wp_remote_post('http://todopensamientos.com/oembed/?&length=' . $length ))));

/*
 *          The object $response format
 *			
 *			json Array {
 *				'version' 		=> "1.0",
 *				'type'			=> "rich",
 *				'html'			=> quote's contents,
 *				'url'			=> exact URL of quote's page, 
 *				'provider_name' => "TodoPensamientos",
 *				'provider_url'	=> URL's provider,
 *				'author_name'	=> AuthorName,
 *				'author_url'	=> exact URL of author's archive page,
 *			} 
 */
 
 			// Filtering raw results for special needs...
			return apply_filters ( 'raw_quotes', $response, $post, $this->options );
			
		}
		
	}

	// Shortcode Interface
	public function quotes_shortcode () {
		
		global $post;
		
		// Fetching the random Spanish Quote
		$response = $this->fetch_quotes();
		
		// Filtering the results for output through Shortcode
		return apply_filters ( 'post_quotes', $response, $post, $this->options );
		
	}
	
	// Shortcode Interface ( Widget Front-End )
	public function widget( $args, $instance ) {
		
		global $post;
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		
		// Fetching the random Spanish Quote
		$response = $this->fetch_quotes();
		
		// Filtering the results for output through Widget
		echo apply_filters ( 'widget_quotes', $response , $post, $this->options );
		
		echo $args['after_widget'];
		
	}


	/******************************************************************************************************************************
	 *
	 * The basic quote formating filter
	 *
	 */
	static function cook_quotes ( $response, $post, $options ) {

		$separator = sprintf ( '<span class="quote-author-link-separator">%s</span>', ' &ndash;&#x2006;' ); 
		
		// asynchronous mode cooking: no content, only HTML tags
		if ( $options['async_mode_field'] ) {

			// Adding a <DIV> with a random numbered id for the jQuery recognition in a multiuse / multicall environment
		$out 	 = $response;
			
			$out 	.= '<span class="quote-text"></span>';
			$out    .= '<span class="author-tag">';
			
			$out 	.= $separator;
			$out 	.= '<span class="quote-author-link"></span>';
			$out    .= '</span>';
			
		// synchronous mode cooking: HTML Tags and content
		} else {
			
			$quote_text = ( ( (boolean) $options['use_the_content_filter'] ) ? apply_filters ( 'the_content', $response->html ) : $response->html );
			
		$out 	 = '<div id="cool-quote">';
			$out 	.= '<span class="quote-text">' . $quote_text . '</span>';
			$out    .= '<span class="author-tag">';
			
			$out 	.= $separator;
			$out 	.= '<span class="quote-author-link"><a href="' . $response->author_url . '" title="' . __( 'Quotes of', 'spanish-quote-of-the-day-frase-del-dia' ) . ' ' . $response->author_name . ' | ' . $response->provider_name . '" target="_blank" ><span class="author-name">' . $response->author_name . '</span></a></span>';

			$out    .= '</span>';

		}

		$out 	.= '<span class="quote-credits"><a href="http://todopensamientos.com" target="_blank" title="' . _x( 'Quotes', 'HTML title attribute', 'spanish-quote-of-the-day-frase-del-dia' ) . ' | TodoPensamientos">' . _x( 'Quotes', 'todopensamientos anchor text', 'spanish-quote-of-the-day-frase-del-dia' ) . '</a></span>';
		$out 	.= '</div>';

		return $out;
	
	}
	
}