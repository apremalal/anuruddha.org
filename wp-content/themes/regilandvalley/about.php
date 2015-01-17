<?php
/*
Template Name: About template
*/
?>
<?php get_header(); ?>
 <div class="container">
    <div class="row">
      <div class="col-md-12" style="padding-top:36px;"> 
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			  	<?php the_content(); ?>
			<?php endwhile;endif;?>
      <div class="row">
         <div class="col-md-12 tales-superblock">
            <h2>Social</h2>
            <div class="social-icons clearfix">
               <a href="http://lk.linkedin.com/in/apremalal/" class="social-icon color-three" target="_blank"><div class="inner-circle" ></div><i class="fa fa-linkedin"></i></a>
               <a href="https://www.facebook.com/anuruddhapremalal" class="social-icon color-two" target="_blank"><div class="inner-circle" ></div><i class="fa fa-facebook"></i></a>
               <a href="https://twitter.com/anuruddhapre" class="social-icon color-one" target="_blank"><div class="inner-circle" ></div><i class="fa fa-twitter"></i></a>
            </div>
            <hr><br/>
			<a class="btn btn-primary btn-lg col-md-3 col-md-offset-4" href="mailto:anuruddhapremalal@gmail.com">Drop Me A Line</a>
         </div>
      </div>
      </div>
  </div>
</div>
<?php get_footer(); ?>
