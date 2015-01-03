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
   <aside class="col-md-4 blog-aside">
                    <div class="aside-widget">
                        <div class="body">
                            <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>" class="navbar-form">
    						  <div class="form-group">
    							<input type="text" class="form-control" style="height:40px;" placeholder="Search" value="" name="s" id="s" >
    						  </div>
    						  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
    						</form>
						</div>
					</div>
					
                     <div class="aside-widget" style="margin-bottom: 50px;">
                        <header>
                            <h3>About Me</h3>
                        </header>
                        <div class="body">						  
							<span class="about-sidebar"><img class="about-portrait img-responsive" alt="" src="<?php echo get_template_directory_uri();?>/img/about-me.png" width="115" height="120"/>
							 I'm Anuruddha!<br/>I'm an entrepreneur, a software engineer <br/> <br/>
							<!-- Place this code where you want the badge to render. -->
							<a href="//plus.google.com/u/0/117146363453945095163?prsrc=3"
							   rel="publisher" target="_top" style="display:inline-block;">
							Follow me on 
							<img src="//ssl.gstatic.com/images/icons/gplus-32.png" alt="Google+" style="border:0;width:32px;height:32px;margin-left:8px;"/>
							</a><br/><br/>
  							 <a href="<?php echo get_permalink(7); ?>" style="color: #AF7817;">View my full profile</a>
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
                
                    <!--<div class="aside-widget">
                        <header>
                            <h3>Recent Posts</h3>
                        </header>
                        <div class="body">
                            <ul class="tales-list">
							  <?php
								$archive_query = new WP_Query('showposts=5');
								while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
							  <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></li>
							  <?php endwhile; ?>
                            </ul>
                        </div>
                    </div> -->
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
		<div class="aside-widget">
			<header>
                            <h3>Tweets</h3>
                        </header>
			<div class="body clearfix">
				<a class="twitter-timeline" href="https://twitter.com/anuruddhapre" data-widget-id="551270803937828864">Tweets by @anuruddhapre</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
		</div>

         </aside>
