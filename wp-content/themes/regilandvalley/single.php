<?php get_header(); ?>
 <div class="container">
	<div class="row">
	  <div class="col-md-8 blog-main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!--Content -->
					<div class="row" style="margin-bottom: 0px;background-color:rgba(85, 167, 115, 0.1);padding:25px;margin-right: 0px;margin-left: 0px;">					  
				        <div class="author col-xs-6 col-md-4">
				            <i class="fa fa-user"></i>
				            <span class="data"><?php the_author(); ?> </span>
				        </div>
				        <div class="date col-xs-6 col-md-4">
				            <i class="fa fa-calendar"></i>
				            <span class="data"><?php the_date('Y-m-d', '', ''); ?></span>
				        </div>
				        <div class="comments col-xs-6 col-md-4">
				            <i class="fa fa-comments"></i>
				            <span class="data"><a href="#comments"><?php comments_number();?></a></span>
				        </div>                                
				    </div>	
			 		<article class="blog-post">
						<header class="col-md-12">
							<div class="row">
						    <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></h1>
							</div>
						</header>
						<div class="body">
							<?php the_content(); ?>
						</div>
					</article>
				<hr>
				<?php comments_template(); ?>

	    <?php endwhile; else: ?>
			<p><?php _e('Sorry, this page does not exist.'); ?></p>
		<?php endif; ?>
	 </div>
	  <?php get_sidebar(); ?>	
  </div>
</div>
<?php get_footer(); ?>


