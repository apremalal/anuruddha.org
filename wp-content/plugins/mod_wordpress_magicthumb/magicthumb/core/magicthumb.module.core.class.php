<?php

if(!defined('MagicThumbModuleCoreClassLoaded')) {

    define('MagicThumbModuleCoreClassLoaded', true);

    require_once(dirname(__FILE__).'/magictoolbox.params.class.php');

    /**
     * MagicThumbModuleCoreClass
     *
     */
    class MagicThumbModuleCoreClass {

        /**
         * MagicToolboxParamsClass class
         *
         * @var   MagicToolboxParamsClass
         *
         */
        var $params;

        /**
         * Tool type
         *
         * @var   string
         *
         */
        var $type = 'standard';

        /**
         * Id
         *
         * @var   string
         *
         */
        var $id = '';

        /**
         * Show message flag
         *
         * @var   boolean
         *
         */
        var $showMessageEnable = true;

        /**
         * Constructor
         *
         * @return void
         */
        function MagicThumbModuleCoreClass() {
            $this->params = new MagicToolboxParamsClass();
            $this->loadDefaults();
            $this->params->setMapping(array(
                'keep-thumbnail' => array('Yes' => 'true', 'No' => 'false'),
                'click-to-initialize' => array('Yes' => 'true', 'No' => 'false'),
                'show-loading' => array('Yes' => 'true', 'No' => 'false'),
                'slideshow-loop' => array('Yes' => 'true', 'No' => 'false'),
                'keyboard' => array('Yes' => 'true', 'No' => 'false'),
                'keyboard-ctrl' => array('Yes' => 'true', 'No' => 'false'),
                'restore-speed' => create_function('&$params', 'return $params->checkValue("restore-speed","-1")?$params->getValue("expand-speed"):$params->getValue("restore-speed");')
            ));
        }

        /**
         * Method to get headers string
         *
         * @param string $jsPath  Path to JS file
         * @param string $cssPath Path to CSS file
         *
         * @return string
         */
        function getHeadersTemplate($jsPath = '', $cssPath = null) {
            //to prevent multiple displaying of headers
            if(!defined('MAGICTHUMB_MODULE_HEADERS')) {
                define('MAGICTHUMB_MODULE_HEADERS', true);
            } else {
                return '';
            }
            if($cssPath == null) {
                $cssPath = $jsPath;
            }
            $headers = array();
            $headers[] = '<!-- Magic Thumb WordPress module version v6.0.19 [v1.5.14:v2.0.70] -->';
            $headers[] = '<link type="text/css" href="'.$cssPath.'/magicthumb.css" rel="stylesheet" media="screen" />';
            $headers[] = '<link type="text/css" href="'.$cssPath.'/magicthumb.module.css" rel="stylesheet" media="screen" />';
            $headers[] = '<script type="text/javascript" src="'.$jsPath.'/magicthumb.js"></script>';
            $headers[] = $this->getOptionsTemplate();
            return "\r\n".implode("\r\n", $headers)."\r\n";
        }

        /**
         * Method to get options string
         *
         * @return string
         */
        function getOptionsTemplate() {
            $addition = '';
            $captionSource = $this->params->getParam('caption-source');
            if($captionSource && isset($captionSource['core']) && $captionSource['core']) {
                $addition .= "\n\t\t'caption-source':'".$this->params->getValue('caption-source')."',";
            } else {
                $addition .= "\n\t\t'caption-source':'span',";
            }
            return "<script type=\"text/javascript\">\n\tMagicThumb.options = {{$addition}\n\t\t".$this->params->serialize(true, ",\n\t\t")."\n\t}\n</script>";
        }

        /**
         * Method to get main image HTML
         *
         * @param array $params Params
         *
         * @return string
         */
        function getMainTemplate($params) {
            $img = '';
            $thumb = '';
            $id = '';
            $alt = '';
            $title = '';
            $description = '';
            $width = '';
            $height = '';
            $link = '';
            $group = '';

            extract($params);

            if(empty($img)) {
                return false;
            }
            if(empty($thumb)) {
                $thumb = $img;
            }
            if(empty($id)) {
                $id = md5($img);
            }

            $this->id = $id;

            if(empty($alt)) {
                if(empty($title)) {
                    $title = '';
                    $alt = '';
                } else {
                    $alt = htmlspecialchars(htmlspecialchars_decode($title, ENT_QUOTES));
                }
            } else {
                if(empty($title)) {
                    $title = '';
                }
                $alt = htmlspecialchars(htmlspecialchars_decode($alt, ENT_QUOTES));
            }
            if(empty($description)) {
                $description = '';
            }

            if($this->params->checkValue('show-caption', 'Yes')) {
                $captionSource = $this->params->getValue('caption-source');
                $captionSource = strtolower(trim($captionSource));
                if($captionSource == 'all' || $captionSource == 'both') {
                    $captionSource = $this->params->getValues('caption-source');
                } else {
                    $captionSource = explode(',', $captionSource);
                }
                $fullTitle = array();
                foreach($captionSource as $caption) {
                    $caption = trim($caption);
                    $caption = lcfirst(implode(explode(' ', ucwords($caption))));
                    if($caption == 'all' || $caption == 'both' || !isset($$caption) || empty($$caption)) {
                        continue;
                    }
                    if($caption == 'title') {
                        $fullTitle[] = '<b>'.$$caption.'</b>';
                    } else {
                        $fullTitle[] = $$caption;
                    }
                }
                $title = implode('<br/>', $fullTitle);
                $title = trim(preg_replace('/\s+/is', ' ', $title));
                if(!empty($title)) {
                    $title = preg_replace('/<(\/?)a([^>]*)>/is', '[$1a$2]', $title);
                    $title = '<span>'.$title.'</span>';
                }
            } else {
                $title = '';
            }

            if(empty($width)) {
                $width = '';
            } else {
                $width = " width=\"{$width}\"";
            }
            if(empty($height)) {
                $height = '';
            } else {
                $height = " height=\"{$height}\"";
            }

            if($this->params->checkValue('show-message', 'Yes') && $this->showMessageEnable) {
                $message = '<div class="MagicToolboxMessage">'.$this->params->getValue('message').'</div>';
            } else {
                $message = '';
            }

            $rel = $this->params->serialize();

            if(!empty($link)) {
                $rel .= 'link:'.$link.';';
            }

            if(!empty($group)) {
                $rel .= 'group:'.$group.';';
            }

            if(!empty($rel)) {
                $rel = 'rel="'.$rel.'"';
            }

            return "<a class=\"MagicThumb\" id=\"MagicThumbImage{$id}\" href=\"{$img}\" {$rel}><img itemprop=\"image\"{$width}{$height} src=\"{$thumb}\" alt=\"{$alt}\" />{$title}</a>{$message}";
        }

        /**
         * Method to get selectors HTML
         *
         * @param array $params Params
         *
         * @return string
         */
        function getSelectorTemplate($params) {
            $img = '';
            $medium = '';
            $thumb = '';
            $id = '';
            $alt = '';
            $title = '';
            $width = '';
            $height = '';

            if($this->params->checkValue('use-selectors', 'No')) {
                unset($params['id']);
                $this->showMessageEnable = false;
                $template = $this->getMainTemplate($params);
                $this->showMessageEnable = true;
            } else {

                extract($params);

                if(empty($img)) {
                    return false;
                }
                if(empty($medium)) {
                    $medium = $img;
                }
                if(empty($thumb)) {
                    $thumb = $img;
                }
                if(empty($id)) {
                    $id = $this->id;
                }


                if(empty($title)) {
                    $title = '';
                } else {
                    $title = htmlspecialchars(htmlspecialchars_decode($title, ENT_QUOTES));
                }
                if(empty($alt)) {
                    $alt = $title;
                } else {
                    $alt = htmlspecialchars(htmlspecialchars_decode($alt, ENT_QUOTES));
                }

                if($this->params->checkValue('show-caption', 'Yes') && !empty($title)) {
                    $title = trim(preg_replace('#\s+#is', ' ', $title));
                    $title = preg_replace('#<(/?)a([^>]*+)>#is', '[$1a$2]', $title);
                    $title = " title=\"{$title}\"";
                } else {
                    $title = '';
                }

                if(empty($width)) {
                    $width = '';
                } else {
                    $width = " width=\"{$width}\"";
                }
                if(empty($height)) {
                    $height = '';
                } else {
                    $height = " height=\"{$height}\"";
                }

                $template = "<a{$title} href=\"{$img}\" rel=\"thumb-id: MagicThumbImage{$id};caption-source: a:title;\" rev=\"$medium\"><img{$width}{$height} src=\"{$thumb}\" alt=\"{$alt}\" /></a>";
            }

            return $template;
        }

        /**
         * Method to load defaults options
         *
         * @return void
         */
        function loadDefaults() {
            $params = array(
				"image-size"=>array("id"=>"image-size","group"=>"Positioning and Geometry","order"=>"210","default"=>"fit-screen","label"=>"Size of the enlarged image","type"=>"array","subType"=>"select","values"=>array("original","fit-screen"),"scope"=>"tool"),
				"expand-position"=>array("id"=>"expand-position","advanced"=>"1","group"=>"Positioning and Geometry","order"=>"220","default"=>"center","label"=>"Position of enlarged window","type"=>"text","description"=>"The value can be 'center' or coordinates (e.g. 'top:0, left:0' or 'bottom:100, left:100')","scope"=>"tool"),
				"expand-align"=>array("id"=>"expand-align","group"=>"Positioning and Geometry","order"=>"230","default"=>"screen","label"=>"Align expanded image relative to screen or small image","type"=>"array","subType"=>"select","values"=>array("screen","image"),"scope"=>"tool"),
				"expand-effect"=>array("id"=>"expand-effect","group"=>"Effects","order"=>"10","default"=>"linear","label"=>"Effect while enlarging image","type"=>"array","subType"=>"select","values"=>array("linear","cubic","back","elastic","bounce"),"scope"=>"tool"),
				"restore-effect"=>array("id"=>"restore-effect","group"=>"Effects","order"=>"20","default"=>"linear","label"=>"Effect while restoring enlarged image to small state","type"=>"array","subType"=>"select","values"=>array("linear","cubic","back","elastic","bounce"),"scope"=>"tool"),
				"expand-speed"=>array("id"=>"expand-speed","group"=>"Effects","order"=>"30","default"=>"500","label"=>"Duration when enlarging image (milliseconds)","description"=>"0-10000, e.g. 2000 = 2 seconds","type"=>"num","scope"=>"tool"),
				"restore-speed"=>array("id"=>"restore-speed","group"=>"Effects","order"=>"40","default"=>"-1","label"=>"Duration when restoring enlarged image (milliseconds)","description"=>"0-10000, e.g. 2000 = 2 seconds. Use same value as enlarging duration = -1","type"=>"num","scope"=>"tool"),
				"expand-trigger"=>array("id"=>"expand-trigger","group"=>"Effects","order"=>"50","default"=>"click","label"=>"How to trigger enlarge effect","type"=>"array","subType"=>"select","values"=>array("click","mouseover"),"scope"=>"tool"),
				"expand-trigger-delay"=>array("id"=>"expand-trigger-delay","advanced"=>"1","group"=>"Effects","order"=>"60","default"=>"500","label"=>"Delay before mouseover triggers expand effect (milliseconds)","description"=>"0 or larger  e.g. 0 = instant; 400 = 0.4 seconds","type"=>"num","scope"=>"tool"),
				"restore-trigger"=>array("id"=>"restore-trigger","advanced"=>"1","group"=>"Effects","order"=>"70","default"=>"auto","label"=>"How to restore enlarged image to small state","type"=>"array","subType"=>"select","values"=>array("auto","click","mouseout"),"scope"=>"tool"),
				"keep-thumbnail"=>array("id"=>"keep-thumbnail","advanced"=>"1","group"=>"Effects","order"=>"80","default"=>"Yes","label"=>"Show/hide image on web page when enlarged","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),
				"swap-image"=>array("id"=>"swap-image","group"=>"Multiple images","order"=>"210","default"=>"click","label"=>"Method to switch between multiple images","type"=>"array","subType"=>"radio","values"=>array("click","mouseover"),"scope"=>"tool"),
				"swap-image-delay"=>array("id"=>"swap-image-delay","advanced"=>"1","group"=>"Multiple images","order"=>"220","default"=>"100","label"=>"Delay before switching thumbnails (milliseconds)","description"=>"0 or larger e.g. 0 = instant; 100 = 0.1 seconds","type"=>"num","scope"=>"tool"),
				"click-to-initialize"=>array("id"=>"click-to-initialize","group"=>"Initialization","order"=>"10","default"=>"No","label"=>"Click to download large image","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),
				"show-loading"=>array("id"=>"show-loading","group"=>"Initialization","order"=>"20","default"=>"Yes","label"=>"Loading message appears when zoom tool begins","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),
				"loading-msg"=>array("id"=>"loading-msg","advanced"=>"1","group"=>"Initialization","order"=>"30","default"=>"Loading","label"=>"Text to appear as Loading message","type"=>"text","scope"=>"tool"),
				"loading-opacity"=>array("id"=>"loading-opacity","advanced"=>"1","group"=>"Initialization","order"=>"40","default"=>"75","label"=>"Loading message opacity (0-100)","description"=>"0 = transparent, 100 = solid color","type"=>"num","scope"=>"tool"),
				"show-caption"=>array("id"=>"show-caption","group"=>"Title and Caption","order"=>"20","default"=>"Yes","label"=>"Show caption","type"=>"array","subType"=>"radio","values"=>array("Yes","No")),
				"caption-source"=>array("id"=>"caption-source","group"=>"Title and Caption","order"=>"30","default"=>"Title","label"=>"Caption source","description"=>"allowed values: Title, Short description, Description, All","type"=>"array","subType"=>"select","values"=>array("Title","Description","Both")),
				"caption-width"=>array("id"=>"caption-width","advanced"=>"1","group"=>"Title and Caption","order"=>"40","default"=>"300","label"=>"Max width of bottom caption","description"=>"pixels: 0 or larger","type"=>"num","scope"=>"tool"),
				"caption-height"=>array("id"=>"caption-height","advanced"=>"1","group"=>"Title and Caption","order"=>"50","default"=>"300","label"=>"Max height of bottom caption","description"=>"pixels: 0 or larger","type"=>"num","scope"=>"tool"),
				"caption-position"=>array("id"=>"caption-position","group"=>"Title and Caption","order"=>"60","default"=>"bottom","label"=>"Position caption appears","type"=>"array","subType"=>"select","values"=>array("bottom","right","left"),"scope"=>"tool"),
				"caption-speed"=>array("id"=>"caption-speed","advanced"=>"1","group"=>"Title and Caption","order"=>"70","default"=>"250","label"=>"Duration caption appears (milliseconds)","description"=>"e.g. 0 = instant; 250 = 0.25 seconds","type"=>"num","scope"=>"tool"),
				"class"=>array("id"=>"class","group"=>"Miscellaneous","order"=>"20","default"=>"MagicThumb","label"=>"Class Name","type"=>"array","subType"=>"select","values"=>array("all","MagicThumb")),
				"show-message"=>array("id"=>"show-message","group"=>"Miscellaneous","order"=>"500","default"=>"Yes","label"=>"Show message under image?","type"=>"array","subType"=>"radio","values"=>array("Yes","No")),
				"message"=>array("id"=>"message","group"=>"Miscellaneous","order"=>"510","default"=>"Click to enlarge","label"=>"Enter message to appear under images","type"=>"text"),
				"background-opacity"=>array("id"=>"background-opacity","group"=>"Background","order"=>"10","default"=>"0","label"=>"Background opacity (0-100)","description"=>"0 = transparent, 100 = solid color","type"=>"num","scope"=>"tool"),
				"background-color"=>array("id"=>"background-color","group"=>"Background","order"=>"20","default"=>"#000000","label"=>"Background color (#RGB)","description"=>"#000000 = black","type"=>"text","scope"=>"tool"),
				"background-speed"=>array("id"=>"background-speed","advanced"=>"1","group"=>"Background","order"=>"30","default"=>"200","label"=>"Duration of fade (milliseconds)","description"=>"e.g. 0 = instant; 200 = 0.2 seconds","type"=>"num","scope"=>"tool"),
				"buttons"=>array("id"=>"buttons","group"=>"Buttons","order"=>"10","default"=>"show","label"=>"Display navigation buttons","type"=>"array","subType"=>"select","values"=>array("show","hide","autohide"),"scope"=>"tool"),
				"buttons-display"=>array("id"=>"buttons-display","group"=>"Buttons","order"=>"20","default"=>"previous, next, close","label"=>"Navigation button text","type"=>"text","description"=>"Show all three buttons or just one or two. E.g. 'previous, next' or 'close, next'","scope"=>"tool"),
				"buttons-position"=>array("id"=>"buttons-position","advanced"=>"1","group"=>"Buttons","order"=>"30","default"=>"auto","label"=>"Position of navigation buttons","type"=>"array","subType"=>"select","values"=>array("auto","top left","top right","bottom left","bottom right"),"scope"=>"tool"),
				"slideshow-effect"=>array("id"=>"slideshow-effect","group"=>"Expand mode","order"=>"10","default"=>"dissolve","label"=>"Effect when switching images","type"=>"array","subType"=>"select","values"=>array("dissolve","fade","expand"),"scope"=>"tool"),
				"slideshow-loop"=>array("id"=>"slideshow-loop","advanced"=>"1","group"=>"Expand mode","order"=>"20","default"=>"Yes","label"=>"Restart slideshow after last image","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),
				"slideshow-speed"=>array("id"=>"slideshow-speed","advanced"=>"1","group"=>"Expand mode","order"=>"30","default"=>"800","label"=>"Duration when changing images (milliseconds)","description"=>"0 or larger e.g. 0 = instant; 800 = 0.8 seconds","type"=>"num","scope"=>"tool"),
				"z-index"=>array("id"=>"z-index","advanced"=>"1","group"=>"Expand mode","order"=>"40","default"=>"10001","label"=>"The z-index for the enlarged image","type"=>"num","scope"=>"tool"),
				"keyboard"=>array("id"=>"keyboard","advanced"=>"1","group"=>"Expand mode","order"=>"50","default"=>"Yes","label"=>"Use keyboard arrows to move between images","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),
				"keyboard-ctrl"=>array("id"=>"keyboard-ctrl","advanced"=>"1","group"=>"Expand mode","order"=>"60","default"=>"No","label"=>"Use CTRL key with keyboard arrows","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool")
			);
            $this->params->appendParams($params);
        }
    }

}

?>
