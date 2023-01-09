<?php

/** 
 * Crucial Core: yourtheme_meta
 * 
 * Description: Use rwmb_meta() function IF METABOX.io PLUGIN HAS LOADED, 
 * specifically, if your plugin that loads MetaBox.io (and thus MetaBox.io) has loaded.
 * Also handles valuer retrieval for terms.
 * 
 * Required: PHP 7 or later
 * 
 * Instructions:
 * 1. Replace the 'yourtheme' in with your theme slug (cosmetic)
 * 2. You need to load MetaBox.io via your plugin AND put the plugin's
 *    load_plugin_textdomain function inside a 'your_theme_load_plugin_textdomain' function.
 *    Example:
 *    // Load textdomain (translations)
 *    function your_theme_load_plugin_textdomain() {
 * 		  load_plugin_textdomain( 'your-plugin-handle', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
 * 	  }
 *    add_action( 'plugins_loaded', 'your_theme_load_plugin_textdomain' );
 * 3. Replace 'your_theme_load_plugin_textdomain' as needed (both here and in your plugin)(cosmetic)
 * 4. Now you can retrieve MB.io values instantly & safely, whether they're for posts or terms, like so:
 * 	  // for posts, pages etc. (i.e. not terms)
 *    $my_var = yourtheme_meta( 'some_mb_field_id', 'fallback_string_ie_black', 'normal' ); // you can also omit the last param
 *    // for terms
 *    $my_var = yourtheme_meta( 'some_mb_field_id', 'fallback string is bananas', 'term' );
 *
 * @since 1.0.0
 * 
 * @see rwmb_meta()
 * @global function. rwmb_meta()
 * @global $theme_plugin_loaded
 *
 * @param string. $rwmb_meta_field. Meta Box field ID.
 * @param string. $fallback_value_string. Any string.
 * @param string. $normal_or_term. Check for which type of value-retrieving function to use (posts or terms).
 * 
 * @return string or undefined
 */
if ( ! function_exists( 'yourtheme_meta' ) ) :

	function yourtheme_meta( $rwmb_meta_field, $fallback_value_string = '', $normal_or_term = '' ) {
		
		/**
		 * Check if MetaBox.io has loaded (via your plugin that holds it)
		 * 
		 * The 'your_theme_load_plugin_textdomain' below should match
		 * the function name of the function which loads text domain
		 * of your plugin.
		 */
		$theme_plugin_loaded = false;
		if ( function_exists( 'your_theme_load_plugin_textdomain' ) ) {
			$theme_plugin_loaded = true;
		}

		/**
		 * Handles the value for terms
		 */
		function yourtheme_mbterm( $field_id ) {
			$current_cat = get_queried_object();
			$current_cat_id = $current_cat->term_id;
			$value = rwmb_meta( $field_id, array( 'object_type' => 'term' ), $current_cat_id );
			return $value;
		}

		/**
		 * If safe to operate (see $theme_plugin_loaded above)
		 */ 
		if ( $theme_plugin_loaded ) {

			/**
			 * Handle retrieval accordingly
			 * whether it's normal or term
			 */
			if ( $normal_or_term == 'term' ) {
				$val = yourtheme_mbterm( $rwmb_meta_field ) ?? $fallback_value_string;
			} else {
				$val = rwmb_meta( $rwmb_meta_field ) ?? $fallback_value_string;
			}

			/**
			 * Optional: Decide whether you need this or not
			 * Falls back to $fallback_value_string
			 * if retrieval above returns an empty string
			 */
			if ( strlen( $val ) < 1 ) :
				$val = $fallback_value_string;
			endif;

		} else {

			/**
			 * Plugin is not loaded = not safe to work with MetaBox,
			 * falls back to $fallback_value_string.
			 */

			$val = $fallback_value_string;

		}

		return $val;
	}

endif;