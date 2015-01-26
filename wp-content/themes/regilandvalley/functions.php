<?php 

function regilandvalley_scripts_with_jquery()
{
	// Register the script like this for a theme:
	wp_register_script( 'custom-script', get_template_directory_uri().'/libs/bootstrap/js/bootstrap.min.js', array( 'jquery' ) );
	wp_register_script( 'custom-script', get_template_directory_uri().'/libs/bootstrap/js/holder.js', array( 'jquery' ) );
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'custom-script' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

add_action( 'wp_enqueue_scripts', 'regilandvalley_scripts_with_jquery' );

add_action( 'wp_enqueue_scripts', 'webendev_load_font_awesome', 99 );

function register_site_menus() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}

add_action( 'init', 'register_site_menus' );

function new_excerpt_more( $more ) {
	return '<div class="clearfix"><a class="btn btn-primary" style="float:right" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'your-text-domain') . '</a></div>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

function arphabet_widgets_init() {

	register_sidebar( array(
		'name' => 'Global Footer widget bar',
		'id' => 'sidebar-1',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
}

add_action( 'widgets_init', 'arphabet_widgets_init' );

//removing wordpress editor auto formatting
remove_filter('the_content', 'wpautop');

function  regilandvalley_comment_nav() {
    // Are there comments to navigate through?
    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
    ?>
    <nav class="navigation comment-navigation" role="navigation">
            <h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'regilandvalley' ); ?></h2>
            <div class="nav-links">
                    <?php
                            if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'regilandvalley' ) ) ) :
                                    printf( '<div class="nav-previous">%s</div>', $prev_link );
                            endif;

                            if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'regilandvalley' ) ) ) :
                                    printf( '<div class="nav-next">%s</div>', $next_link );
                            endif;
                    ?>
            </div><!-- .nav-links -->
    </nav><!-- .comment-navigation -->
    <?php
    endif;
}

?>
