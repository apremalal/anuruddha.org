<?php get_header(); ?>
 <div class="container">
	<div class="row">
	  <div class="col-md-8 blog-main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1><?php the_title(); ?></h1>
		  	<?php the_content(); ?>

		<?php endwhile; else: ?>
			<p><?php _e('Sorry, this page does not exist.'); ?></p>
		<?php endif; ?>
      </div>
	  <?php get_sidebar(); ?>	
  </div>
</div>
<?php get_footer(); ?>
