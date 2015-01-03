<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
<footer>
        <div class="widewrapper footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 footer-widget">
                        <h3> <i class="fa fa-cog"></i>Statistics</h3>

                        <span>Even we sometimes loose track of how many articles we actually have here.  This one helps:</span>

                        <div class="stats">
                            <div class="line">
                                <span class="counter"><?php $count_posts = wp_count_posts();
														echo $count_posts->publish;?></span>
                                <span class="caption">Articles</span>
                            </div>
                            <div class="line">
                                <span class="counter"><?php comments_number( '% ', '% ', '% ' ); ?></span>
                                <span class="caption">Comments</span>
                            </div>
                            <div class="line">
                                <span class="counter"><?php echo count( get_users( array( 'role' => 'Administrator' ) ) ) ?></span>
                                <span class="caption">Author</span>
                            </div>                    
                        </div>
                    </div>

                    <div class="col-md-4 footer-widget">
                        <h3> <i class="fa fa-star"></i> Hall of Fame</h3>
                        <ul class="tales-list">
							<?php
								$archive_query = new WP_Query( array('meta_key' => 'post_views_count',
															  'orderby' => 'meta_value_num',
															   'posts_per_page' => 5));
								if ( $archive_query->have_posts() ) :while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
							  		<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></li>
							  <?php endwhile;else: ?>
									  <?php
								$archive_query = new WP_Query('showposts=5');
								while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
							  		<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></li>
							  	<?php endwhile; ?>
							 <?php endif; ?>
						</ul>
                    </div>

                    <div class="col-md-4 footer-widget">
                        <h3> <i class="fa fa-envelope"></i>Contact Me</h3>

                        <span>I'm happy to hear from my readers. Thoughts, feedback, critique - all welcome! Drop me a line:</span>
                        
                        <span class="email">
                            <a href="mailto:anuruddhapremalal@gmail.com">Anuruddha Premalal</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
