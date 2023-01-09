# metabox-io-safeload
MetaBox.io safe value load.

<h3>Instructions:</h3>
<ol>
	<li>Replace the 'yourtheme' in with your theme slug (cosmetic)</li>
	<li>You need to load MetaBox.io via your plugin AND put the plugin's load_plugin_textdomain function inside a 'your_theme_load_plugin_textdomain' function. Example:
<pre>
/**
 * Load textdomain (translations)
 */
function your_theme_load_plugin_textdomain() {
	load_plugin_textdomain( 'your-plugin-handle', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'your_theme_load_plugin_textdomain' );
</pre>
	</li>
	<li>Replace 'your_theme_load_plugin_textdomain' as needed (both here and in your plugin)(cosmetic)</li>
	<li>Now you can retrieve MB.io values instantly & safely, whether they're for posts or terms, like so:
		<ul>
			<li>For posts, pages etc. (i.e. not terms)
<pre>
$my_var = yourtheme_meta( 'some_mb_field_id', 'fallback_string_ie_black', 'normal' ); // you can also omit the last param
</pre>
			</li>
			<li>For terms
<pre>
$my_var = yourtheme_meta( 'some_mb_field_id', 'fallback string is bananas', 'term' );
</pre>
			</li>
		</ul>
	</li>
</ol>