<?php
/*
Template Name: Landing page
*/
?>

<?php get_header(); ?>
  <div class="container marketing">
      <!-- START THE FEATURETTES -->
	    <div class="row featurette">
        <div class="col-md-5">
          <a href="<?php echo get_permalink(7); ?>"><img class="featurette-image img-responsive about-portrait-landing"  src="<?php echo get_template_directory_uri();?>/img/about-me.png" alt="Generic placeholder image"></a><br/>
        </div>
        <div class="col-md-7" style="margin-top:60px;">
          <h2 class="featurette-heading">Welcome to Anuruddha's Home page! </h2><br/>
          <p class="lead"> Thank you for visiting my site. This is the place where I share my knowledge and experience with the world, hope you'll find something useful here.</p>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">I'm a summer of code mentor <span class="text-muted"> for mifosx.</span></h2><br/><br/>
          <p class="lead">I am mentoring Rishabh who is a 3rd year undergraduate student from Sri Mata Vaishno Devi University India. He is working on the system wide notification project. Now we are in the community bonding period. </p>
		<div class="clearfix"><a class="btn btn-primary" target="_blank" style="float:right" href="https://mifosforge.jira.com/wiki/pages/viewpage.action?pageId=70189172">Read More</a></div>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" src="<?php echo get_template_directory_uri();?>/img/gsoc-2014.png" alt="Generic placeholder image">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
          <img class="featurette-image img-responsive" src="<?php echo get_template_directory_uri();?>/img/gsoc-2013.jpg" alt="Generic placeholder image"><br/>
		  <img class="featurette-image img-responsive" src="<?php echo get_template_directory_uri();?>/img/mifos-banner.png" alt="Generic placeholder image">
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">I was a GSOC student, <span class="text-muted">Contributing to mifosx project.</span></h2><br/>
          <p class="lead"> It was truley an amazig experience for me to become part of one of world's largest movement Mifos; fighting against poverty. I have succesfully completed two GSOC projects including Server side pagination and a caching layer for mifosx.</p>
		 <div class="clearfix"><a class="btn btn-primary" style="float:right" target="_blank" href="https://mifosforge.jira.com/wiki/display/projects/GSOC+2013+-+Distributed+Caching+support">Read More</a></div>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette" style="margin-bottom:50px;">
        <div class="col-md-7">
          <h2 class="featurette-heading">Towards Smart objects: <span class="text-muted">Micro activity recognition using accelerometer data.</span></h2><br/>
          <p class="lead">I did this research with my collegue Anuruddha Hettiarachchi. Through this research we discuss the end-to-end process of micro-activity recognition of augmented everyday-objects and presents a complete performance comparison of different classifiers. We are waiting for the acceptance of paper by ubicomp 2014. </p>
        	<div class="clearfix"><a class="btn btn-primary" target="_blank" style="float:right" href="http://wiki.regilandvalley.com/index.php/Main_Page">Read More</a></div>
        </div>
        <div class="col-md-5">
		  <img class="featurette-image img-responsive" src="<?php echo get_template_directory_uri();?>/img/ubicomp_2014.png" alt="Generic placeholder image">
          <img class="featurette-image img-responsive" src="<?php echo get_template_directory_uri();?>/img/speaktome.jpg" alt="Generic placeholder image">
        </div>
      </div>

<?php get_footer(); ?>
