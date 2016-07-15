<?php
/*

Copyright 2008 MagicToolbox (email : support@magictoolbox.com)
Plugin Name: Magic Thumb
Plugin URI: http://www.magictoolbox.com/magicthumb/
Description: Enlarge your small images to the full screen. Add text captions or HTML. You can even use it as an image slideshow! Activate plugin then <a href="https://www.magictoolbox.com/magicthumb/modules/wordpress/#installation">Get Started</a>.
Version: 6.0.19
Author: MagicToolbox
Author URI: http://www.magictoolbox.com/

*/

/*
    WARNING: DO NOT MODIFY THIS FILE!

    NOTE: If you want change Magic Thumb settings
            please go to plugin page
            and click 'Magic Thumb Configuration' link in top navigation sub-menu.
*/

if(!function_exists('magictoolbox_WordPress_MagicThumb_init')) {
    /* Include MagicToolbox plugins core funtions */
    require_once(dirname(__FILE__)."/magicthumb/plugin.php");
}

//MagicToolboxPluginInit_WordPress_MagicThumb ();
register_activation_hook( __FILE__, 'WordPress_MagicThumb_activate');

register_deactivation_hook( __FILE__, 'WordPress_MagicThumb_deactivate');

magictoolbox_WordPress_MagicThumb_init();
?>