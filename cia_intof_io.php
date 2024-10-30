<?php
/**
 * Plugin Name: Interactive Offers Co-Registration Plugin
 * Version: 1.0
 * Description: Interactive Offers Co-Registration Plugin
 * Author: InteractiveOffers, LLC
 * Author URI: http://www.interactiveoffers.com/
 * License: GPL2
 */
function cia_intof(){
    ob_start();
    ?>
    <iframe id="iframeOffers" src="http://intof.io/frame/<?php echo get_option('intof-publisher-id'); ?>?email=username@domain.com&phone=&firstName=&lastName=&tag=<?php echo get_option('intof-site-tag'); ?>" width="100%" height="400" style="border:0px;"></iframe>
    <script language="javascript">
      window.onload=setTimeout(function(){
       window.$_GET = new URLSearchParams(location.search);
      var emailGrab = $_GET.get('email');
     document.getElementById('iframeOffers').src = 'https://intof.io/frame/<?php echo get_option('intof-publisher-id'); ?>?email='+emailGrab+'&tag=<?php echo  get_option('intof-site-tag'); ?>&showtitle=1&success=<?php echo get_option('optional-success-url'); ?>';
      },100);
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('cia_intof','cia_intof');



add_action( 'admin_menu', 'cia_intof_menu' );
function cia_intof_menu() {
	add_options_page( 
		'Interactive Offers Co-Registration settings',
		'Interactive Offers Co-Registration settings',
		'manage_options',
		'cia_intof_settings.php',
		'cia_intof_settings'
	);
	add_action( 'admin_init', 'Intof_settings' );
}

function Intof_settings() {
	//register our settings
        register_setting( 'Intof-settings-group', 'intof-publisher-id' );
	register_setting( 'Intof-settings-group', 'intof-site-tag' );
	register_setting( 'Intof-settings-group', 'optional-success-url' );
}
function  cia_intof_settings() {
?>
<div class="wrap">
<h1>Interactive Offers Co-Registration settings</h1>

<form method="post" action="options.php"  enctype="multipart/form-data">
    <?php settings_fields( 'Intof-settings-group' ); ?>
    <?php do_settings_sections( 'Intof-settings-group' ); ?>
    <table class="form-table"  style="width:60%">
        <tr valign="top">
            <th scope="row">PUBLISHER ID</th>
            <td><input type="text" name="intof-publisher-id" value="<?php echo esc_attr( get_option('intof-publisher-id') ); ?>" style="width:300px"/></td>
        </tr>
        <tr valign="top">
            <th scope="row">SITE TAG</th>
            <td><input type="text" name="intof-site-tag" value="<?php echo esc_attr( get_option('intof-site-tag') ); ?>" style="width:300px"/></td>
        </tr>
        <tr valign="top">
            <th scope="row">OPTIONAL SUCCESS URL</th>
            <td><input type="text" name="optional-success-url" value="<?php echo esc_attr( get_option('optional-success-url') ); ?>" style="width:300px"/></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
<br>

For integration you can use <strong>[cia_intof]</strong> shortcode.
</div>
<?php }