<?php
/*
Plugin Name: SNV Facebook Like Button
Plugin URI: http://www.studionashvegas.com/plugins/facebook-like-button-plugin/
Description: Drops in a Facebook "like" button below your content on your site!  Allows for a width to be set (to match your blog's width) 

and the color scheme to be set (light or dark).
Author: Mitch Canter
Contributors: Mitch Canter
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GEMDJDM63MXZJ
Tags: wp, facebook, facebook like button, 
Requires at least: 2.3
Tested up to: 2.9.2
Version: 0.2a
Stable tag: trunk
Author URI: http://www.studionashvegas.com
*/

//plugin defaults
 add_option ( 'width', '450' );
 add_option ( 'color-scheme', 'light' );

function add_facebook_button($fb_like_button = '')
{
//set up the inital facebook insert code


        $width            = get_option('width');
        $color            = get_option('color-scheme'); 
	$the_perma	= rawurlencode(get_permalink());
	$fb_like_button	.= '<div class="facebook_like_button"><iframe src="http://www.facebook.com/plugins/like.php?href='.$the_perma.'&amp;layout=standard&amp;show-faces=true&amp;height=80&amp;width='.$width.'&amp;action=like&amp;font=arial&amp;colorscheme='.$color.'" scrolling="no" frameborder="0" allowTransparency="true" style="margin: 20px 0 -20px 0 !important; padding: 0px !important; border:none; overflow:hidden; width:'.$width.'px; height:80px;"></iframe></div>';
	return $fb_like_button;
}

add_action('the_content', 'add_facebook_button');

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
        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } 


?>