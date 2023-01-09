# MetaBox.io safe value load.

<h3>About</h3>
Safely use MetaBox.io's rwmb_meta() function if your plugin that loads MetaBox.io (and thus MetaBox.io) has loaded.
Also handles value retrieval for terms.
This is important to pass theme submission requirements (for e.g. themeforest) if you plan on integrating MetaBox.io in your plugin/theme because it should be in "plugin territory" and this code lets you use a simple function that checks if it's safe to use MetaBox.io or not. It's also super useful for quickly getting values for terms, eliminating the extra steps by simply adding the 'term' parameter to the function. Finally, you can you can also pass the fallback value which should be used if MetaBox.io wasn't loaded or if it was loaded but failed in retrieving a value from the specified field. 

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