<?php
/*
Template Name: Landing page
*/
?>

<?php get_header(); ?>
  <div class="container marketing">
      <!-- START THE FEATURETTES -->
	    <div class="row featurette">
        <div class="col-md-5" style="padding-top:5%;padding-left:8%;">
           <div class="ih-item circle effect13 top_to_bottom"><a href="index.php?page_id=7">
              <div class="img"><img src="<?php echo get_template_directory_uri();?>/img/about-me.png" alt="img"></div>
              <div class="info">
                <h3>About Me</h3>
                <p>View full profile</p>
              </div></a>
           </div>
         <!-- <a href="<?php echo get_permalink(7); ?>"><img class="featurette-image img-responsive about-portrait-landing"  src="<?php echo get_template_directory_uri();?>/img/about-me.png" alt="Generic placeholder image"></a>--><br/> 
        </div>
        <div class="col-md-7" style="margin-top:60px;">
          <h2 class="featurette-heading">Welcome to Anuruddha's Home page! </h2><br/>
          <p class="lead"> Thank you for visiting my site. This is the place where I share my knowledge and experience with the world, hope you'll find something useful here.</p>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Mentoring google summer of code was exciting <span class="text-muted"> ~ mifosx ~</span></h2><br/><br/>
          <p class="lead">As a former GSOC student I was able to help many students with the getting onboard process for  GSOC 2014. This year we had around 20 proposal submissions and 6 of them got selected.</p>
		    <div class="clearfix"><a class="btn btn-primary" target="_blank" style="float:right" href="http://mifos.org/blog/meet-2014-google-summer-code-class-interns/">Read More</a></div>
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
          <h2 class="featurette-heading">GSCO 2013, <span class="text-muted">Contributing to mifosx project.</span></h2><br/>
          <p class="lead"> It was truley an amazig experience for me to become part of one of world's largest movement Mifos; fighting against poverty. I have succesfully completed two GSOC projects including Server side pagination and a caching layer for mifosx.</p>
		      <div class="clearfix"><a class="btn btn-primary" style="float:right" target="_blank" href="http://mifos.org/blog/meet-2013-google-summer-code-class-interns/">Read More</a></div>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette" style="margin-bottom:50px;">
        <div class="col-md-7">
          <h2 class="featurette-heading">Towards Context-Aware Just-in-Time Information: <span class="text-muted">Micro-Activity recognition of Everyday Objects.</span></h2><br/>
          <p class="lead">I did this research with my collegue Anuruddha Hettiarachchi. Through this research we discuss the end-to-end process of micro-activity recognition of augmented everyday-objects and presents a complete performance comparison of different classifiers. This paper is published in Eighth International Conference on Industrial and information Systems. </p>
        	<div class="clearfix"><a class="btn btn-primary" target="_blank" style="float:right" href="http://wiki.regilandvalley.com/index.php/Main_Page">Read More</a></div>
        </div>
        <div class="col-md-5">
		      <img class="featurette-image img-responsive" src="<?php echo get_template_directory_uri();?>/img/ubicomp_2014.png" alt="Generic placeholder image">
          <img class="featurette-image img-responsive" src="<?php echo get_template_directory_uri();?>/img/speaktome.jpg" alt="Generic placeholder image">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5" style="margin-top:3%;">
          <img class="featurette-image img-responsive" src="<?php echo get_template_directory_uri();?>/img/ieee-logo.png" alt="Generic placeholder image"><br/>
        </div>
        <div class="col-md-7" style="margin-bottom:5%;">
          <h2 class="featurette-heading" style="margin-top:0;">Detection of microfilariae <span class="text-muted">in peripheral blood smears using image analysis </span></h2><br/>
          <p class="lead">This paper presents an image-based technique for diagnosis of filariasis through the detection of microfilariae present in Giemsa or Hematoxylin and Eosin stained peripheral thick blood smears.</p>
          <div class="clearfix"><a class="btn btn-primary" style="float:right" target="_blank" href="https://www.linkedin.com/redir/redirect?url=http%3A%2F%2Fieeexplore%2Eieee%2Eorg%2Fxpl%2FarticleDetails%2Ejsp%3Ftp%3D%26arnumber%3D6731999%26url%3Dhttp%253A%252F%252Fieeexplore%2Eieee%2Eorg%252Fxpls%252Fabs_all%2Ejsp%253Farnumber%253D6731999&urlhash=gB4c&trk=prof-publication-title-link">Read More</a></div>
        </div>
      </div>

<?php get_footer(); ?>
