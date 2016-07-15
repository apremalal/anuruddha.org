<?php
/*

Copyright 2015 MagicToolbox (email : support@magictoolbox.com)

*/

$error_message = false;

function WordPress_MagicThumb_activate () {

    if(!function_exists('file_put_contents')) {
        function file_put_contents($filename, $data) {
            $fp = fopen($filename, 'w+');
            if ($fp) {
                fwrite($fp, $data);
                fclose($fp);
            }
        }
    }


    //fix url's in css files
    $fileContents = file_get_contents(dirname(__FILE__) . '/core/magicthumb.css');
    $cssPath = preg_replace('/https?:\/\/[^\/]*/is', '', get_option("siteurl"));

    $cssPath .= '/wp-content/'.preg_replace('/^.*?\/(plugins\/.*?)$/is', '$1', str_replace("\\","/",dirname(__FILE__))).'/core';

    $pattern = '/url\(\s*(?:\'|")?(?!'.preg_quote($cssPath, '/').')\/?([^\)\s]+?)(?:\'|")?\s*\)/is';
    $replace = 'url(' . $cssPath . '/$1)';
    $fixedFileContents = preg_replace($pattern, $replace, $fileContents);
    if($fixedFileContents != $fileContents) {
        file_put_contents(dirname(__FILE__) . '/core/magicthumb.css', $fixedFileContents);
    }
    
    magictoolbox_WordPress_MagicThumb_init() ;

    WordPress_MagicThumb_send_stat('install');

}

function WordPress_MagicThumb_deactivate () {

    //delete_option("WordPressMagicThumbCoreSettings");
    WordPress_MagicThumb_send_stat('uninstall');
}

function WordPress_MagicThumb_send_stat($action = '') {

    //NOTE: don't send from working copy
    if('working' == 'v6.0.19' || 'working' == 'v2.0.70') {
        return;
    }

    $hostname = 'www.magictoolbox.com';

    $url = preg_replace('/^https?:\/\//is', '', get_option("siteurl"));
    $url = urlencode(urldecode($url));

    global $wp_version;
    $platformVersion = isset($wp_version) ? $wp_version : '';
    
    

    $path = "api/stat/?action={$action}&tool_name=magicthumb&license=trial&tool_version=v2.0.70&module_version=v6.0.19&platform_name=wordpress&platform_version={$platformVersion}&url={$url}";
    $handle = @fsockopen($hostname, 80, $errno, $errstr, 30);
    if($handle) {
        $headers  = "GET /{$path} HTTP/1.1\r\n";
        $headers .= "Host: {$hostname}\r\n";
        $headers .= "Connection: Close\r\n\r\n";
        fwrite($handle, $headers);
        fclose($handle);
    }

}

function showMessage_WordPress_MagicThumb($message, $errormsg = false) {
    if ($errormsg) {
        echo '<div id="message" class="error">';
    } else {
        echo '<div id="message" class="updated fade">';
    }
    echo "<p><strong>$message</strong></p></div>";
}    


function showAdminMessages_WordPress_MagicThumb(){
    global $error_message;
    if (current_user_can('manage_options')) {
       showMessage_WordPress_MagicThumb($error_message,true);
    }
}


function plugin_get_version_WordPress_MagicThumb() {
    $plugin_data = get_plugin_data(str_replace('/plugin.php','.php',__FILE__));
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}

function update_plugin_message_WordPress_MagicThumb() {
    $ver = json_decode(@file_get_contents('http://www.magictoolbox.com/api/platform/wordpress/version/'));
    if (empty($ver)) return false;
    $ver = str_replace('v','',$ver->version);
    $oldVer = plugin_get_version_WordPress_MagicThumb();
    if (version_compare($oldVer, $ver, '<')) {
        echo '<div id="message" class="updated fade">
                  <p>New version available! We recommend that you download the latest version of the plugin <a href="http://magictoolbox.com/magicthumb/modules/wordpress/">here</a>. </p>
              </div>';
    }
}

function MagicThumb_remove_update_nag($value) {
    if (isset($value->response)) {
        unset($value->response[ str_replace('/plugin','',plugin_basename(__FILE__)) ]);
    }
    return $value;
}

function  magictoolbox_WordPress_MagicThumb_init() {

    global $error_message;
    
    $tool_lower = 'magicthumb';
    switch ($tool_lower) {
	case 'magiczoom': 	$priority = '90'; break;
	case 'magiczoomplus': 	$priority = '100'; break;
	case 'magicthumb': 	$priority = '110'; break;
	case 'magicscroll': 	$priority = '120'; break;
	case 'magicslideshow':	$priority = '130'; break;
	case 'magic360': 	$priority = '140'; break;
	case 'magictouch': 	$priority = '150'; break;
	default :		$priority = '90'; break;
    }
    
    add_action("admin_menu", "magictoolbox_WordPress_MagicThumb_config_page_menu");
    add_action( 'admin_enqueue_scripts', 'WordPress_MagicThumbload_admin_scripts' );
    add_action("wp_head", "magictoolbox_WordPress_MagicThumb_styles",$priority); //load scripts and styles
    add_filter("the_content", "magictoolbox_WordPress_MagicThumb_create", 13); //filter content

    
    
    
    add_filter('site_transient_update_plugins', 'MagicThumb_remove_update_nag');
    add_filter( 'plugin_action_links', 'magictoolbox_WordPress_MagicThumb_links', 10, 2 );

    if (!file_exists(dirname(__FILE__) . '/core/magicthumb.js')) {
        $jsContents = file_get_contents('http://www.magictoolbox.com/static/magicthumb/trial/magicthumb.js');
        if (!empty($jsContents) && preg_match('/\/\*.*?\\\*/is',$jsContents)){
            if ( !is_writable(dirname(__FILE__) . '/core/')) {
                $error_message = 'The '.substr(dirname(__FILE__),strpos(dirname(__FILE__),'wp-content')).'/core/magicthumb.js file is missing. Please re-uplaod it.';
            }
            file_put_contents(dirname(__FILE__) . '/core/magicthumb.js', $jsContents);
            chmod(dirname(__FILE__) . '/core/magicthumb.js', 0777);
        } else {
            $error_message = 'The '.substr(dirname(__FILE__),strpos(dirname(__FILE__),'wp-content')).'/core/magicthumb.js file is missing. Please re-uplaod it.';
        }
    }
    if ($error_message) add_action('admin_notices', 'showAdminMessages_WordPress_MagicThumb');

    //add_filter("shopp_catalog", "magictoolbox_create", 1); //filter content for SHOPP plugin

    if(!isset($GLOBALS['magictoolbox']['WordPressMagicThumb'])) {
        require_once(dirname(__FILE__) . '/core/magicthumb.module.core.class.php');
        $coreClassName = "MagicThumbModuleCoreClass";
        $GLOBALS['magictoolbox']['WordPressMagicThumb'] = new $coreClassName;
        $coreClass = &$GLOBALS['magictoolbox']['WordPressMagicThumb'];
    }
    $coreClass = &$GLOBALS['magictoolbox']['WordPressMagicThumb'];
    /* get current settings from db */
    $settings = get_option("WordPressMagicThumbCoreSettings");
    if($settings !== false && is_array($settings) && isset($settings['default']) && !isset($_GET['reset_settings'])) {
        foreach (WordPressMagicThumb_getParamsProfiles() as $profile => $name) {
	    if (isset($settings[$profile])) {
		$coreClass->params->appendParams($settings[$profile],$profile);
	    }
	}
    } else { //set defaults
        $allParams = array();
	foreach (WordPressMagicThumb_getParamsProfiles() as $profile => $name) {
	    $coreClass->params->setParams($coreClass->params->getParams('default'),$profile);
	    $allParams[$profile] = $coreClass->params->getParams('default');
	}
	delete_option("WordPressMagicThumbCoreSettings");
        add_option("WordPressMagicThumbCoreSettings", $allParams);
    }
   
    
}

function WordPress_MagicThumbload_admin_scripts () {
 
    wp_enqueue_script( 'jquery' ,includes_url('/js/jquery/jquery.js'));
    wp_enqueue_script( 'jquery-ui-core', includes_url('/js/jquery/ui/core.js') );
    wp_enqueue_script( 'jquery-ui-tabs', includes_url('/js/jquery/ui/tabs.js') );
 
}



function WordPressMagicThumb_config_page() {
     magictoolbox_WordPress_MagicThumb_config_page('WordPressMagicThumb');
}

function magictoolbox_WordPress_MagicThumb_links( $links, $file ) {
    if ( $file == plugin_basename( dirname(__FILE__).'.php' ) ) {
        $settings_link = '<a href="admin.php?page=WordPressMagicThumb-config-page">'.__('Settings').'</a>';
        array_unshift( $links, $settings_link );
    }
    return $links;
}

function magictoolbox_WordPress_MagicThumb_config_page_menu() {
    if(function_exists("add_menu_page")) {
        //$page = add_submenu_page("admin.php", __("Magic Thumb Plugin Configuration"), __("Magic Thumb Configuration"), "manage_options", "WordPressMagicThumb-config-page", "WordPressMagicThumb_config_page");
        $page = add_menu_page( __("Magic Thumb"), __("Magic Thumb"), "manage_options", "WordPressMagicThumb-config-page", "WordPressMagicThumb_config_page", plugin_dir_url( __FILE__ )."/core/admin_graphics/icon.png");
    }
}

function  magictoolbox_WordPress_MagicThumb_config_page($id) {

    update_plugin_message_WordPress_MagicThumb();
    
    $settings = get_option("WordPressMagicThumbCoreSettings");
    $map = WordPressMagicThumb_getParamsMap();
    

    if(isset($_POST["submit"])) {
	$allSettings = array();
        /* save settings */
        foreach (WordPressMagicThumb_getParamsProfiles() as $profile => $name) {
	    $GLOBALS['magictoolbox'][$id]->params->setProfile($profile);
	    foreach($_POST as $name => $value) {
		if(preg_match('/magicthumbsettings_'.ucwords($profile).'_(.*)/is',$name,$matches)) {
		    $GLOBALS['magictoolbox'][$id]->params->setValue($matches[1],$value);
	      }
	    }
	    $allSettings[$profile] = $GLOBALS['magictoolbox'][$id]->params->getParams($profile);
	}
	update_option($id . "CoreSettings", $allSettings);
	$settings = $allSettings;
    }

    
    
    
    
    ?>
	<style>
        <?php /*.<?php echo $toolAbr; ?>params { margin:20px 0; width:90%; border:1px solid #dfdfdf; }*/ ?>
        #magicthumb-config-form  .params { margin:0; width:100%;}
        #magicthumb-config-form .params th { border-bottom:1px solid #dfdfdf; font-weight:bold; background:#fff; text-align:left; padding:15px 20px; vertical-align: top; }
        #magicthumb-config-form .params td { vertical-align:top; border-bottom:1px solid #dfdfdf; padding:10px 5px; background:#fff; width:100%; }
        #magicthumb-config-form .params tr.back th, #magicthumb-config-form .params tr.back td { background:#f9f9f9; }
        #magicthumb-config-form .params tr.last th, #magicthumb-config-form .params tr.last td { border:none; }
        .afterText {font-size:10px;font-style:normal;font-weight:normal;}
        .help-block {font-size: 11px; display:block}
        .settingsTitle {font-size: 1.5em;font-weight: normal;margin: 1.7em 0 1em 0;}
        .ui-tabs-nav {margin-bottom: -6px;}
        .ui-tabs-nav li {display: inline-block;}
        .ui-tabs-nav a:focus {box-shadow:none !important;}

        input[type="checkbox"],input[type="radio"] {margin:5px;vertical-align:middle !important;}
        td img {vertical-align:middle !important; margin-right:10px;}
        td span {vertical-align:middle !important; margin-right:10px;}
		#footer , #wpfooter {position:relative;}
    </style>
    
    <script type="text/javascript">
	 jQuery( document ).ready(function() {
	      jQuery(function() {
		  jQuery( "#tabs" ).tabs({
			activate: function(event, ui){
			    jQuery('.nav-tab').removeClass('nav-tab-active');
			    jQuery(ui.newTab).children().addClass('nav-tab-active');
			}
		  });
	      });
	  });
    </script>

    
    <div class="icon32" id="icon-options-general"><br></div>
    <h2>Magic Thumb Settings</h2><br/>
    <p style="font-size:15px;">Learn about all the <a href="http://www.magictoolbox.com/magicthumb/integration/" target="_blank">Magic Thumb&trade; settings and examples too!</a>&nbsp;|&nbsp;<a href="http://www.magictoolbox.com/contact/">Get support</a></p>
    <form action="" method="post" id="magicthumb-config-form">
    
    
    
    
    
    
    
     <div id="tabs">
    
	      <h2 class="nav-tab-wrapper">
		<ul>
		<?php /*<li><a data-toggle="tab" class="nav-tab nav-tab-active" href="#tab-general">General</a></li>*/ ?>
		<?php foreach (WordPressMagicThumb_getParamsProfiles() as $block_id => $block_name) { 
		    if (!isset($tactive)) {
			$tactive = 'nav-tab-active';
		    } else {
			$tactive = '';
		    }
		?>
		    <li><a data-toggle="tab" class="nav-tab <?php echo $tactive; ?>" href="#tab-<?php echo $block_id; ?>"><?php echo $block_name; ?></a></li>
		<?php } ?>
		</ul>
	      </h2>
	      
	      
	      <?php foreach (WordPressMagicThumb_getParamsProfiles() as $block_id => $block_name) { 
	      ?>
		  <div id="tab-<?php echo $block_id; ?>">
		  
			<?php echo WordPressMagicThumb_get_options_groups($settings, $block_id, $map, $id); ?>
		  </div>
	      <?php } ?>
	  </div>
	  
            <p><input type="submit" name="submit" class="button-primary" value="Save settings" />&nbsp;<a href="admin.php?page=WordPressMagicThumb-config-page&reset_settings=true">Reset to defaults</a></p>
        </form>

   
    </div>

    <div style="font-size:12px;margin:5px auto;text-align:center;">Learn more about the <a href="http://www.magictoolbox.com/magicthumb_integration/" target="_blank">customisation options</a></div>
    
    
    
    <?php
    
}
    
    function WordPressMagicThumb_get_options_groups ($settings, $profile = 'default', $map, $id) {
    
	
	$html = '';
	$toolAbr = '';
	$abr = explode(" ", strtolower("Magic Thumb"));
	
	foreach ($abr as $word) $toolAbr .= $word{0};
    
	$corePath = preg_replace('/https?:\/\/[^\/]*/is', '', get_option("siteurl"));
	$corePath .= '/wp-content/'.preg_replace('/^.*?\/(plugins\/.*?)$/is', '$1', str_replace("\\","/",dirname(__FILE__))).'/core';
	
	if (!isset($settings[$profile])) return false;
	$settings = $settings[$profile]; 

                $groups = array();
                $imgArray = array('zoom & expand','zoom&expand','yes','zoom','expand','swap images only','original','expanded','no','left','top left','top','top right', 'right', 'bottom right', 'bottom', 'bottom left'); //array for the images ordering

                $result = '';
                
                foreach($settings as $name => $s) { 
                
		    if (!isset($map[$profile][$s['group']]) || !in_array($s['id'], $map[$profile][$s['group']])) continue; 
                
		    if ($profile == 'product') {
			if ($s['id'] == 'page-status' && !isset($s['value'])) {
			    $s['default'] = 'Yes';
			}
		    }
		    
		    if (!isset($s['value'])) $s['value'] = $s['default'];

		    if ($profile == 'product') {
			if ($s['id'] == 'page-status' && !isset($s['value'])) {
			    $s['default'] = 'Yes';
			}
		    }
                    if (strtolower($s['id']) == 'direction') continue;
		    if (strtolower($s['id']) == 'enabled-effect' || strtolower($s['id']) == 'class' || strtolower($s['id']) == 'nextgen-gallery'  ) {
			$s['group'] = 'top';
                    }
                    
                    
                    if (!isset($groups[$s['group']])) {
                        $groups[$s['group']] = array();
                    }

                    //$s['value'] = $GLOBALS['magictoolbox'][$id]->params->getValue($name);

                    if (strpos($s["label"],'(')) {
                        $before = substr($s["label"],0,strpos($s["label"],'('));
                        $after = ' '.str_replace(')','',substr($s["label"],strpos($s["label"],'(')+1));
                    } else {
                        $before = $s["label"];
                        $after = '';
                    }
                    if (strpos($after,'%')) $after = ' %';
                    if (strpos($after,'in pixels')) $after = ' pixels';
                    if (strpos($after,'milliseconds')) $after = ' milliseconds';
                    
                    if (isset($s["description"]) && trim($s["description"]) != '') {
			$description = $s["description"];
		    } else {
			$description = '';
		    }

                    $html  .= '<tr>';
                    $html  .= '<th width="30%">';
                    $html  .= '<label for="magicthumbsettings'.'_'.ucwords($profile).'_'. $name.'">'.$before.'</label>';

                    if(($s['type'] != 'array') && isset($s['values'])) $html .= '<br/> <span class="afterText">' . implode(', ',$s['values']).'</span>';

                    $html .= '</th>';
                    $html .= '<td width="70%">';

                    switch($s["type"]) {
                        case "array": 
                                $rButtons = array();
                                foreach($s["values"] as $p) {
                                    $rButtons[strtolower($p)] = '<label><input type="radio" value="'.$p.'"'. ($s["value"]==$p?"checked=\"checked\"":"").' name="magicthumbsettings'.'_'.ucwords($profile).'_'.$name.'" id="magicthumbsettings'.'_'.ucwords($profile).'_'. $name.$p.'">';
                                    $pName = ucwords($p);
                                    if(strtolower($p) == "yes")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/yes.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    elseif(strtolower($p) == "no")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/no.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    elseif(strtolower($p) == "left")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/left.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    elseif(strtolower($p) == "right")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/right.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    elseif(strtolower($p) == "top")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/top.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    elseif(strtolower($p) == "bottom")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/bottom.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    elseif(strtolower($p) == "bottom left")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/bottom-left.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    elseif(strtolower($p) == "bottom right")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/bottom-right.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    elseif(strtolower($p) == "top left")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/top-left.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    elseif(strtolower($p) == "top right")
                                        $rButtons[strtolower($p)] .= '<img src="'.$corePath.'/admin_graphics/top-right.gif" alt="'.$pName.'" title="'.$pName.'" /></label>';
                                    else {
                                        if (strtolower($p) == 'load,hover') $p = 'Load & hover';
                                        if (strtolower($p) == 'load,click') $p = 'Load & click';
                                        $rButtons[strtolower($p)] .= '<span>'.ucwords($p).'</span></label>';
                                    }
                                }
                                foreach ($imgArray as $img){
                                    if (isset($rButtons[$img])) {
                                        $html .= $rButtons[$img];
                                        unset($rButtons[$img]);
                                    }
                                }
                                $html .= implode('',$rButtons);
                            break;
                        case "num": 
                        case "text": 
                        default:
                            if (strtolower($name) == 'message') { $width = 'style="width:95%;"';} else {$width = '';}
                            $html .= '<input '.$width.' type="text" name="magicthumbsettings'.'_'.ucwords($profile).'_'.$name.'" id="magicthumbsettings'.'_'.ucwords($profile).'_'. $name.'" value="'.$s["value"].'" />';
                            break;
                    }
                    $html .= '<span class="afterText">'.$after.'</span>';
                    if (!empty($description)) $html .= '<span class="help-block">'.$description.'</span>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $groups[$s['group']][] = $html;
                    $html = '';
                }
            
            if (isset($groups['top'])) { //move 'top' group to the top
		$top = $groups['top'];
		unset($groups['top']);
		array_unshift($groups, $top);
            }

            if (isset($groups['Miscellaneous'])) {
		$misc = $groups['Miscellaneous'];
		unset($groups['Miscellaneous']);
		$groups['Miscellaneous'] = $misc; //move Miscellaneous to bottom
	    }

            foreach ($groups as $name => $group) {
                $i = 0;
		if ($name == '0') {
		    $name = '';
		    $group = preg_replace('/(^.*)(Class\sName)(.*?<span>)(All)(<\/span>.*?<span>)(MagicThumb)(<\/span>.*)/is','$1Apply effect to all image links$3Yes$5No$7',$group);
		    
		}
                $group[count($group)-1] = str_replace('<tr','<tr class="last"',$group[count($group)-1]); //set "last" class
                $result .= '<h3 class="settingsTitle">'.$name.'</h3>
                            <div class="'.$toolAbr.'params">
                            <table class="params" cellspacing="0">';
                if (is_array($group)) {
		    foreach ($group as $g) {
			if (++$i%2==0) { //set stripes
			    if (strpos($g,'class="last"')) {
				$g = str_replace('class="last"','class="back last"',$g);
			    } else {
				$g = str_replace('<tr','<tr class="back"',$g);
			    }
			}
			$result .= $g;
		    }
                }
                $result .= '</table> </div>';
            }
            
      return $result;
}



function  magictoolbox_WordPress_MagicThumb_styles() {
    if(!defined('MAGICTOOLBOX_MAGICTHUMB_HEADERS_LOADED')) {
        $plugin = $GLOBALS['magictoolbox']['WordPressMagicThumb'];
		if (function_exists('plugins_url')) {
			$core_url = plugins_url();
		} else {
			$core_url = get_option("siteurl").'/wp-content/plugins';
		}


        $path = preg_replace('/^.*?\/plugins\/(.*?)$/is', '$1', str_replace("\\","/",dirname(__FILE__)));
        
        $headers = $plugin->getHeadersTemplate($core_url."/{$path}/core");

        echo $headers;
        define('MAGICTOOLBOX_MAGICTHUMB_HEADERS_LOADED', true);
    }
}



function  magictoolbox_WordPress_MagicThumb_create($content) {


    $plugin = $GLOBALS['magictoolbox']['WordPressMagicThumb'];
    
    
    /*set watermark options for all profiles START */
    $defaultParams = $plugin->params->getParams('default');
    $wm = array();
    $profiles = $plugin->params->getProfiles();
    foreach ($defaultParams as $id => $values) {
	if (($values['group']) == 'Watermark') {
	    $wm[$id] = $values;
	}
    }
    foreach ($profiles as $profile) {
	$plugin->params->appendParams($wm,$profile);
    }
    /*set watermark options for all profiles END */
    
    
    /*$pattern = "<img([^>]*)(?:>)(?:[^<]*<\/img>)?";
    $pattern = "(?:<a([^>]*)>.*?){$pattern}(.*?)(?:<\/a>)";*/
    $pattern = "(?:<a([^>]*)>)[^<]*<img([^>]*)(?:>)(?:[^<]*<\/img>)?(.*?)[^<]*?<\/a>";


    $oldContent = $content;
    
        $content = preg_replace_callback("/{$pattern}/is","magictoolbox_WordPress_MagicThumb_callback",$content);
        if ($content == $oldContent) return $content;
        
        

      

    /*$content = str_replace('{MAGICTOOLBOX_'.strtoupper('magicthumb').'_MAIN_IMAGE_SELECTOR}',$GLOBALS['MAGICTOOLBOX_'.strtoupper('magicthumb').'_MAIN_IMAGE_SELECTOR'],$content);  //add main image selector to other
    $content = str_replace('{MAGICTOOLBOX_'.strtoupper('magicthumb').'_SELECTORS}','',$content); //if no selectors - remove constant
     onlyForModend  */


    if (!$plugin->params->checkValue('template','original') && $plugin->type == 'standard' && isset($GLOBALS['magictoolbox']['MagicThumb']['main'])) {
        // template helper class
        require_once(dirname(__FILE__) . '/core/magictoolbox.templatehelper.class.php');
        MagicToolboxTemplateHelperClass::setPath(dirname(__FILE__).'/core/templates');
        MagicToolboxTemplateHelperClass::setOptions($plugin->params);
        if (!WordPress_MagicThumb_page_check('WordPress')) { //do not render thumbs on category pages
            $thumbs = WordPress_MagicThumb_get_prepared_selectors();
        } else {
            $thumbs = array();
        }
        
        if (isset($GLOBALS['MAGICTOOLBOX_'.strtoupper('MagicThumb').'_SELECTORS']) && is_array($GLOBALS['MAGICTOOLBOX_'.strtoupper('MagicThumb').'_SELECTORS'])) {
	    $thumbs = array_merge($thumbs,$GLOBALS['MAGICTOOLBOX_'.strtoupper('MagicThumb').'_SELECTORS']);
        }
        
        if (!isset($GLOBALS['magictoolbox']['prods_info']['product_id']) && isset($post_id)) {
	    $GLOBALS['magictoolbox']['prods_info']['product_id'] = $post_id;
	} else if (!isset($GLOBALS['magictoolbox']['prods_info']['product_id']) && !isset($post_id)) {
	    $GLOBALS['magictoolbox']['prods_info']['product_id'] = '';
	}
        $html = MagicToolboxTemplateHelperClass::render(array(
            'main' => $GLOBALS['magictoolbox']['MagicThumb']['main'],
            'thumbs' => (count($thumbs) >= 1) ? $thumbs : array(),
            'pid' => $GLOBALS['magictoolbox']['prods_info']['product_id'],
        ));

        $content = str_replace('MAGICTOOLBOX_PLACEHOLDER', $html, $content);
    } else if ($plugin->params->checkValue('template','original') || $plugin->type != 'standard') {
        $html = $GLOBALS['magictoolbox']['MagicThumb']['main'];
        $content = str_replace('MAGICTOOLBOX_PLACEHOLDER', $html, $content);
    }


    return $content;
}
function  magictoolbox_WordPress_MagicThumb_callback($matches) {
    $plugin = $GLOBALS['magictoolbox']['WordPressMagicThumb'];

    
    if (!preg_match('/(jpg|png|jpeg|gif)/is',$matches[1])) return $matches[0];
    
    if($plugin->params->checkValue('class', 'all')) { //apply to all images
    
	$tool_class = strtolower($plugin->params->getValue('class'));
	
     
        if(preg_match("/class\s*=\s*[\'\"]\s*(?:[^\"\'\s]*\s)*" . preg_quote('MagicThumb', '/') . "(?:\s[^\"\'\s]*)*\s*[\'\"]/iUs",$matches[0])) { //already with class.. wrap it !
            $result =  $matches[0];
        } else { //need to add tool class
	    if (!preg_match('/<a[^<]*?class=/is',$matches[0])) { //a tag have no class
		$result = str_replace('<a','<a class="MagicThumb"',$matches[0]);
	    } else {
		$result = preg_replace('/(.*?)class=[\'\"](.*?)[\'\"](.*)/is','$1class="MagicThumb $2"$3',$matches[0]); //add tool class
	    }
        }
    } else {
	if (preg_match("/class\s*=\s*[\'\"]\s*(?:[^\"\'\s]*\s)*Magic[A-Za-z]+?(?:\s[^\"\'\s]*)*\s*[\'\"]/iUs",$matches[0])) {
	    $result = $matches[0];
	} else {
	    return $matches[0];
	}
    }
    $result = "<div class=\"MagicToolboxContainer\">{$result}</div>";





    return $result;

}

    
    
    

function WordPress_MagicThumb_get_post_attachments()  {
    $args = array(
            'post_type' => 'attachment',
            'numberposts' => '-1',
            'post_status' => null,
            'post_parent' => $post_id
        );

    $attachments = get_posts($args);
    return $attachments;
}


    
    
    



function WordPressMagicThumb_params_map_check ($profile = 'default', $group, $parameter) {
    $map = WordPressMagicThumb_getParamsMap();
    if (isset($map[$profile][$group][$parameter])) return true;
    return false;
}
function WordPressMagicThumb_getParamsMap () {
    $map = array(
		'default' => array(
			'Positioning and Geometry' => array(
				'image-size',
				'expand-position',
				'expand-align',
			),
			'Effects' => array(
				'expand-effect',
				'restore-effect',
				'expand-speed',
				'restore-speed',
				'expand-trigger',
				'expand-trigger-delay',
				'restore-trigger',
				'keep-thumbnail',
			),
			'Multiple images' => array(
				'swap-image',
				'swap-image-delay',
			),
			'Initialization' => array(
				'click-to-initialize',
				'show-loading',
				'loading-msg',
				'loading-opacity',
			),
			'Title and Caption' => array(
				'show-caption',
				'caption-source',
				'caption-width',
				'caption-height',
				'caption-position',
				'caption-speed',
			),
			'Miscellaneous' => array(
				'class',
				'show-message',
				'message',
			),
			'Background' => array(
				'background-opacity',
				'background-color',
				'background-speed',
			),
			'Buttons' => array(
				'buttons',
				'buttons-display',
				'buttons-position',
			),
			'Expand mode' => array(
				'slideshow-effect',
				'slideshow-loop',
				'slideshow-speed',
				'z-index',
				'keyboard',
				'keyboard-ctrl',
			),
		),
	);
    return $map;
}

function WordPressMagicThumb_getParamsProfiles () {

    $blocks = array(
		'default' => 'General',
	);
    
    return $blocks;
}
?>
