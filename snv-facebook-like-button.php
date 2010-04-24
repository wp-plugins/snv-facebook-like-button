<?php
/*
Plugin Name: SNV Facebook Like Button
Author: Mitch Canter
Author URI: http://www.studionashvegas.com/
Contributors: Mitch Canter, Amber Weinberg 
Donate link:https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GEMDJD
Tags: wp, facebook, facebook like button 
Requires at least: 2.3
Plugin URI: http://www.studionashvegas.com/plugins/facebook-like-button-plugin/
Tested up to: 2.9.2
Stable tag: 1.0
Version: 1.0 

This plugin allows you to drop in a very simple widget that showcases the new Facebook "like" button powered by OpenGraph
*/

//plugin defaults
 add_option ( 'width', '450' );
 add_option ( 'color-scheme', 'light' );

function add_facebook_button($fb_like_button = '')
{

//set up the inital facebook insert code


        $width            = get_option('width');
        $color            = get_option('color-scheme'); 
        $manual            = get_option('manual'); 
	$the_perma	= rawurlencode(get_permalink());
	$fb_like_button	.= '<div class="facebook_like_button"><iframe src="http://www.facebook.com/plugins/like.php?href='.$the_perma.'&amp;layout=standard&amp;show-faces=true&amp;height=80&amp;width='.$width.'&amp;action=like&amp;font=arial&amp;colorscheme='.$color.'" scrolling="no" frameborder="0" allowTransparency="true" style="margin: 20px 0 -20px 0 !important; padding: 0px !important; border:none; overflow:hidden; width:'.$width.'px; height:80px;"></iframe></div>';
	if(get_option('manual') == "auto" ){ return $fb_like_button; }
	if(get_option('manual') == "manual" ){ echo $fb_like_button; }
}

if(get_option('manual') == "auto" ){ add_action('the_content', 'add_facebook_button'); }



// create custom plugin settings menu
add_action('admin_menu', 'flb_create_menu');

function flb_create_menu() {

	//create new top-level menu
	add_menu_page('Facebook Like Button', 'Facebook Like Button', 'administrator', __FILE__, 'flb_settings_page',plugins_url('/images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'flb-settings-group', 'width' );
	register_setting( 'flb-settings-group', 'color-scheme' );
	register_setting( 'flb-settings-group', 'manual' );
}




function flb_settings_page() {
?>
<div class="wrap">
<h2>Facebook Like Button Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'flb-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Width <em>(in px)</em>:</th>
        <td><input type="text" name="width" value="<?php echo get_option('width'); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Color Scheme <em>(light or dark)</em>:</th>
        <td><input type="text" name="color-scheme" value="<?php echo get_option('color-scheme'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Add code: <em>(use template tag add_facebook_button for manual insertion)</em>:</th>
        <td>
        
        <select name="manual" >
<option value="auto" <?php if (get_option('manual') =="auto"){ echo "selected";}?> >Automatically</option>
<option value="manual" <?php if (get_option('manual') == "manual"){ echo "selected";}?> >Manually</option>
</select></td>
        </tr>
        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } 


?>