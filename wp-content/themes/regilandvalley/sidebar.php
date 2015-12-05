<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<script type="text/javascript">
    function validateEmail() {
        var email = document.getElementById('wso2-email').value;
        var re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var isValid = re.test(email);
        
        if (!isValid) {
            document.getElementById('wso2-email').value = "";
            document.getElementById('wso2-email').placeholder = "Enter a correct e-mail";
            return false;
        }  else {
             document.getElementById('wso2cloud').submit();
             return true;
        }
    }
    function clearEmailText(){
        document.getElementById('wso2-email').value = "";
    }   
</script>

<aside class="col-md-4 blog-aside">
    <div class="aside-widget">
        <div class="body">
            <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>" class="navbar-form">
			  <h3><i class="fa fa-search"></i><label for="subscribe-field">Search</label></h3>
              <div class="form-group">
				<input type="text" class="form-control" style="height:38px;" placeholder="Search" value="" name="s" id="s" >
                <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
			  </div>
			  
            <hr>
              <!--subscription widget -->
            <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
                </div><!-- #primary-sidebar -->
            <?php endif; ?>

			</form>            
		</div>
	</div>
				
     <div class="aside-widget">
        <header>
            <h3>About Me</h3>
        </header>
        <div class="body">
            <div class="row">
             <div class="col-md-6">
              <div class="ih-item circle-sm effect13 top_to_bottom"><a href="http://www.anuruddha.org/anuruddha_premalal">
                  <div class="img"><img src="<?php echo get_template_directory_uri();?>/img/about-mev2.JPG" alt="img"></div>
                  <div class="info">
                    <h3>About Me</h3>
                    <p>View full profile</p>
                  </div></a>
                </div>
             </div>   
             <div class="col-md-6" style="padding-left:0;">
                I'm Anuruddha!<br/>I'm a technology enthusiast
                <a href="//plus.google.com/u/0/117146363453945095163?prsrc=3" rel="publisher" target="_top" style="display:inline-block;">
                 Follow me on  <img src="//ssl.gstatic.com/images/icons/gplus-32.png" alt="Google+" style="border:0;width:32px;height:32px;margin-left:8px;"/>
                </a>
                <a href="<?php echo get_permalink(7); ?>" style="color: #AF7817;">View my full profile</a>   
             </div>
                          
            </div>	
    		    
             
    		<!-- Place this code where you want the badge to render. -->
    		    
        </div>
    </div>

    <!-- cloud signup widget-->
    <div class="aside-widget">
        <div class="body">            
            <form method="post" onsubmit="return validateEmail();" target="_blank" id="wso2cloud" style="margin-right:5%;padding:30px;border-radius:5px;background-image:url('<?php echo get_template_directory_uri();?>/img/wso2-cloud.png'); background-size:contain;" action="https://cloudmgt.cloud.wso2.com/cloudmgt/site/pages/signup.jag?source=widget">
              <h3 style="text-align: center;margin-top:0">Try WSO2 Cloud</h3>
              <div class="form-group">
                <input type="text" name="email" id="wso2-email" class="form-control" style="height:40px;" placeholder="E-mail" onfocus="clearEmailText();" autocomplete="off">
              </div>
              <input type="submit" class="btn btn-default" style="margin-left:25%;width:45%;background-color:#f47b20;color:#ffffff;" value="Sign up"></input>
              <p style="text-align:center;margin-bottom:3px;margin-top:5px;">Already have an account?</p>
              <a type="button" class="btn btn-default" style="margin-left:25%;width:45%;background-color:#005679;color:#ffffff;" target="_blank" href="https://cloudmgt.cloud.wso2.com/cloudmgt/site/pages/index.jag">Sign in</a>
            </form>         
        </div>
    </div>
				
	<div class="aside-widget">
		<header>
            <h3>Tweets</h3>
        </header>
		<div class="body clearfix" style="margin-right:5%;">
			<a class="twitter-timeline" href="https://twitter.com/anuruddhapre" data-widget-id="551270803937828864">Tweets by @anuruddhapre</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
		</div>
	</div>


    <div class="aside-widget">
        <header>
            <h3>Archives By Month</h3>
        </header>
        <div class="body">
            <ul class="tales-list">
				<?php wp_get_archives('type=monthly'); ?>
            </ul>
        </div>
    </div>

	<div class="aside-widget">
        <header>
            <h3>categories</h3>
        </header>
        <div class="body clearfix">
            <ul class="tales-list">
				<?php 
					$args = array('orderby' => 'name','order' => 'ASC');
					$categories = get_categories( $args );
					$html = '';
					foreach ( $categories as $category ) {
						$category_link = get_category_link( $category->term_id );			
						$html.= "<li><a href='{$category_link}'>{$category->name}</a></li>";
					}
					echo $html;
				?>                         
            </ul>
        </div>
    </div>

    <div class="aside-widget">
        <header>
            <h3>Tags</h3>
        </header>
        <div class="body clearfix">
            <ul class="tags">
				<?php 
					$args = array('number'=> 100);
					$tags = get_tags();
					$html = '';
					foreach ( $tags as $tag ) {
						$tag_link = get_tag_link( $tag->term_id );			
						$html.= "<li><a href='{$tag_link}'>{$tag->name}</a></li>";
					}
					echo $html;
				?>                         
            </ul>
        </div>
    </div>

	<div class="aside-widget">
		 <header>
            <h3>Social</h3>
        </header>
		 <div class="social-icons-sm clearfix">
		   <a href="https://www.facebook.com/anuruddhapremalal" class="social-icon-sm color-three" target="_blank"><div class="inner-circle-sm" ></div><i class="fa fa-facebook"></i></a>
		   <a href="https://twitter.com/anuruddhapre" class="social-icon-sm color-two" target="_blank"><div class="inner-circle-sm" ></div><i class="fa fa-twitter"></i></a>
		   <a href="https://plus.google.com/u/0/+AnuruddhaPremalal/posts" class="social-icon-sm color-one" target="_blank"><div class="inner-circle-sm" ></div><i class="fa fa-google-plus"></i></a>
		</div>	
	</div>

</aside>
