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
jQuery(document).ready(function($){$.each(quoteSeed,function(index,seed){if(seed!=undefined){$.ajax({url:'http://todopensamientos.com/oembed/?&length='+quoteVars.length,dataType:"jsonp",cache:false,async:true,type:"GET",crossDomain:true,headers:{'X-Requested-With':'XMLHttpRequest'},contentType:"application/json;charset=utf-8",xhrFields:{withCredentials:true},error:function(result){alert("ERROR: "+JSON.stringify(result));return false;},complete:function(result){},success:function(result){var quote=JSON.parse(result);if(quoteVars.filterMode==0){ $('#quote-'+seed).find('.quote-text').html(quote.html);}else{var f='';$.each(quote.html.match(/[^\r\n]+/g),function(i,v){f+=((v)?'<p>'+v+'</p>':'');});$('#quote-'+seed).find('.quote-text').html(f);}$('#quote-'+seed).find('.quote-author-link').html('<a href="'+quote.author_url+'" target="_blank" title="'+quoteVars.atitle+' '+quote.author_name+' | Todopensamientos"><span class="author-name">'+quote.author_name+'</span></a>');} });}});});