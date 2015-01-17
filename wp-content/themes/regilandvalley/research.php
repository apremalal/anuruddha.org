<?php
/*
Template Name: projects template
*/
?>

<?php get_header(); ?>
 <div class="container">
    <div class="row">
      <div class="col-md-12" style="">
  			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  			  	<?php the_content(); ?>
  			<?php endwhile;endif;?>
        
        <!-- Project One -->
        <div class="row" style="margin-top:60px;margin-bottom:60px;">
            <div class="grid">
                <figure class="effect-milo">
                    <img src="<?php echo get_template_directory_uri();?>/img/micro-research.jpg" alt="img03"/>
                    <figcaption>
                      <h2><span>OZCHI 2014</span></h2>
                      <p>Augmented-everyday-objects &nbsp;classification micro-activity recognition</p>
                      <a href="#">View more</a>
                    </figcaption>     
                </figure>
              <!--  <a href="#">
                    <img class="img-responsive" src="http://placehold.it/700x300" alt="">
                </a> -->
            </div>
            <div class="col-md-6 research" style="margin-top:1%;margin-left:5%;">
                <h3>Micro-Activity recognition of Everyday Objects</h3>
                <p class="lead">Transferring computation tasks from user-worn devices
                                to everyday objects allows the users to focus on
                                their regular non-computing tasks.
                                Identifying
                                micro-activities (short-repetitive-activities that compose
                                the macro-level behaviour) enables the understanding of
                                subtle behavioural changes and providing just-in-time
                                information without explicit user input.</p>
                <a class="btn btn-primary" href="#">View Project <span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Project Two -->
        <div class="row" style="margin-top:60px;margin-bottom:60px;">
            <div class="grid">
                <figure class="effect-milo">
                    <img src="<?php echo get_template_directory_uri();?>/img/microfilariae.jpg" alt="img03"/>
                    <figcaption>
                      <h2>ICIIS <span>2013</span></h2>
                      <p>connected component analysis object detection computer aided
diagnosis</p>
                      <a href="#">View more</a>
                    </figcaption>     
                </figure>
              <!--  <a href="#">
                    <img class="img-responsive" src="http://placehold.it/700x300" alt="">
                </a> -->
            </div>
            <div class="col-md-6 research" style="margin-top:1%;margin-left:5%;">
                <h3>Detection of microfilariae</h3>
                <p class="lead">Lymphatic filariasis is a leading cause of
                  permanent disability in many countries. Due to its asymptomatic 
                  and epidemiological characteristics, the whole population living 
                  in threatened areas need to be screened. The popular diagnostic 
                  method involves the manual microscopic observation of 
                  nocturnal blood smears in order to detect the presence of 
                  microfilariae. Due its strenuous and mundane nature, 
                  considerable detection errors are observed. 
                </p>
                <a class="btn btn-primary" href="#">View Project <span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Project Three -->
         <div class="row" style="margin-top:60px;margin-bottom:60px;">
            <div class="grid">
                <figure class="effect-milo">
                    <img src="<?php echo get_template_directory_uri();?>/img/panda.jpg" alt="img03"/>
                    <figcaption>
                      <h2><span>2015</span></h2>
                      <p>Internet of things</p>
                      <a href="#">View more</a>
                    </figcaption>     
                </figure>
              <!--  <a href="#">
                    <img class="img-responsive" src="http://placehold.it/700x300" alt="">
                </a> -->
            </div>
            <div class="col-md-6 research" style="margin-top:1%;margin-left:5%;">
                <h3>Current project</h3>
                <p class="lead">Pending..</p>
                <a class="btn btn-primary" href="#">View Project <span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
        </div>
        <!-- /.row -->
      </div>
  </div>
</div>
<?php get_footer(); ?>
