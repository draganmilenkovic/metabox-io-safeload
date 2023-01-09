<?php

/** 
 * Crucial Core: yourtheme_meta
 * 
 * Description: Safely use rwmb_meta() if your plugin that loads MetaBox.io
 * (and thus MetaBox.io() has loaded. Also handles valuer retrieval for terms.
 * Offers fallback value input if MetaBox is not loaded or valuer retrieval fails.
 * 
 * Required: PHP 7 or later
 * 
 * Instructions (READ THEM):
 * https://github.com/draganmilenkovic/metabox-io-safeload
 *
 * @since 1.0.0
 * 
 * @see rwmb_meta()
 * @see get_queried_object()
 *
 * @param string. $rwmb_meta_field. Meta Box field ID.
 * @param string. $fallback_value_string. Any string, if MetaBox.io is not loaded
 * or if it fails retrieving the specified field's value.
 * @param string. $normal_or_term. Check which type of value-retrieving function to
 * use (posts or terms). Default = '', which retrieves for posts. 'term' flags it
 * to retrieve for terms.
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
			$current_term = get_queried_object();
			$current_term_id = $current_term->term_id;
			$value = rwmb_meta( $field_id, array( 'object_type' => 'term' ), $current_term_id );
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