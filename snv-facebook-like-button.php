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
Stable tag: trunk
Version: 1.6

This plugin allows you to drop in a very simple widget that showcases the new Facebook "like" button powered by OpenGraph
*/

//plugin defaults
 add_option ( 'width', '450' );
 add_option ( 'height', '70' );
 add_option ( 'font', 'arial' );
 add_option ( 'verb', 'like' );
 add_option ( 'padding-vert', '0' );
 add_option ( 'padding-horz', '0' );
 add_option ( 'color-scheme', 'light' );

function add_facebook_button($fb_like_button = '')
{

//set up the inital facebook insert code


        $width            = get_option('width');
        $verb            = get_option('verb');
        $font            = get_option('font');
        $paddingvert            = get_option('padding-vert');
        $paddinghorz          = get_option('padding-horz');
        $height           = get_option('height');
        $color            = get_option('color-scheme'); 
        $manual            = get_option('manual'); 
	$the_perma	= rawurlencode(get_permalink());
	$fb_like_button	.= '<div class="facebook_like_button"><iframe src="http://www.facebook.com/plugins/like.php?href='.$the_perma.'&amp;layout=standard&amp;show-faces=true&amp;width='.$width.'&amp;action='.$verb.'&amp;font='.$font.'&amp;colorscheme='.$color.'" scrolling="no" frameborder="0" allowTransparency="true" style="padding: '.$paddingvert.'px '.$paddinghorz.'px; border:none; overflow:hidden; width:'.$width.'px; height:'.$height.'px;"></iframe></div>';
	if(get_option('manual') == "auto" ){ return $fb_like_button; }
	if(get_option('manual') == "manual" ){ echo $fb_like_button; }
}

if(get_option('manual') == "auto" ){ add_action('the_content', 'add_facebook_button'); }



// create custom plugin settings menu
add_action('admin_menu', 'flb_create_menu');

function flb_create_menu() {

	//create new top-level menu
	add_menu_page('Facebook Like Button', 'Facebook Like Button', 'administrator', __FILE__, 'flb_settings_page',plugins_url('/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'flb-settings-group', 'width' );
	register_setting( 'flb-settings-group', 'height' );
	register_setting( 'flb-settings-group', 'verb' );
	register_setting( 'flb-settings-group', 'font' );
	register_setting( 'flb-settings-group', 'padding-vert' );
	register_setting( 'flb-settings-group', 'padding-horz' );
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
        <th scope="row">Height <em>(in px)</em>:</th>
        <td><input type="text" name="height" value="<?php echo get_option('height'); ?>" /></td>
        </tr>      
</table>
<p><em><small>The default, recommended height for 1 line of photos is 70px.</small></em></p>
      
    <table class="form-table">  
        <tr valign="top">
        <th scope="row">Vertical Padding <em>(in px)</em>:</th>
        <td><input type="text" name="padding-vert" value="<?php echo get_option('padding-vert'); ?>" /></td>
        </tr>   

        <tr valign="top">
        <th scope="row">Horizontal Padding <em>(in px)</em>:</th>
        <td><input type="text" name="padding-horz" value="<?php echo get_option('padding-horz'); ?>" /></td>
        </tr>   

        <tr valign="top">
        <th scope="row">Color Scheme:</th>
        <td>
        
        <select name="color-scheme" >
<option value="light" <?php if (get_option('color-scheme') == "light"){ echo "selected";}?> >Light</option>
<option value="dark" <?php if (get_option('color-scheme') == "dark"){ echo "selected";}?> >Dark</option>
</select></td>
        </tr>

<tr valign="top">
        <th scope="row">Font:</th>
        <td>
        
        <select name="font" >
<option value="arial" <?php if (get_option('font') == "arial"){ echo "selected";}?> >Arial</option>
<option value="lucida+grande" <?php if (get_option('font') == "lucida+grande"){ echo "selected";}?> >Lucida Grande</option>
<option value="segoe+ui" <?php if (get_option('font') == "segoe+ui"){ echo "selected";}?> >Segoe UI</option>
<option value="tahoma" <?php if (get_option('font') == "tahoma"){ echo "selected";}?> >Tahoma</option>
<option value="trebuchet+ms" <?php if (get_option('font') == "trebuchet+ms"){ echo "selected";}?> >Trebuchet MS</option>
<option value="verdana" <?php if (get_option('font') == "verdana"){ echo "selected";}?> >Verdana</option>
</select></td>
        </tr>

        <tr valign="top">
        <th scope="row">Verb to use:</th>
        <td>
        
        <select name="verb" >
<option value="like" <?php if (get_option('verb') == "like"){ echo "selected";}?> >Like</option>
<option value="recommend" <?php if (get_option('verb') == "recommend"){ echo "selected";}?> >Recommend</option>
</select></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Add code:</th>
        <td>
        
        <select name="manual" >
<option value="auto" <?php if (get_option('manual') =="auto"){ echo "selected";}?> >Automatically</option>
<option value="manual" <?php if (get_option('manual') == "manual"){ echo "selected";}?> >Manually</option>
</select></td>
        </tr>
       
    </table>
    
<p><br /><em><small>If you decide to use manual insertion, please use <strong>&lt;?php if(function_exists('add_facebook_button')) {   add_facebook_button(); }?&gt;</strong> to make sure your theme works even if you deactivate the plugin.</small></em>
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } 


?>