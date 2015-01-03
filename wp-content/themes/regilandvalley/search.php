<?php
/**
 * The template for displaying Search Results pages
 */

get_header(); ?>

<div class="container">
	<div class="row">
	  <div class="col-md-8 blog-main">
		<?php if (have_posts()) : ?>
			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyfourteen' ), get_search_query() ); ?></h1>
			</header><!-- .page-header -->

		<?php while (have_posts()) : the_post(); ?>

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
				    	<h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
					</div>
				</header>
				<div class="body">
					<?php the_excerpt(); ?>
					<div class="row">
						<p class="links">&raquo; <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
						<hr/> 
						<ul class="tags">
							<?php the_tags('<li>', '', '</li> '); ?>
						</ul>
					</div>
				</div>
				
			</article>
			<?php endwhile; ?>
				<div class="navigation">
					<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
					<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
				</div>
		<?php else : ?>
			<h2 class="center">Not Found</h2>
			<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php endif; ?>
      </div>
	  <?php get_sidebar(); ?>	
  </div>
</div>
<?php get_footer(); ?>
