/*
 * Plugin:      Spanish Quotes of the Day (Frase del Día)
 * Path:        /js
 * File:        asyncronous-interface.js
 * Since:       1.3.0
 */

/* 
 * Module:      Asynchronous Quote Fetching
 * Version:     1.3.0
 * Since:       1.2.0
 * Description: This module fetches the quotes in asyncronous mode via an AJAX call after page displaying
 */
jQuery( document ).ready(function( $ ) {
	// ini tabs module
	$( "#spnq-form" ).tabs();
	$( "#spnq_quote_length_field_id" ).on ( 'change input', function (e) {
		$( e.target ).next().val( $(e.target).val() );
	});
	$( "#spnq_quote_length_field_id_number" ).on ( 'change input', function (e) {
		$( e.target ).prev().val( $(e.target).val() );
	});
});
