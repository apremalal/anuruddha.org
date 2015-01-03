<?php 

function regilandvalley_scripts_with_jquery()
{
	// Register the script like this for a theme:
	wp_register_script( 'custom-script', get_template_directory_uri().'/libs/bootstrap/js/bootstrap.min.js', array( 'jquery' ) );
	wp_register_script( 'custom-script', get_template_directory_uri().'/libs/bootstrap/js/holder.js', array( 'jquery' ) );
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'regilandvalley_scripts_with_jquery' );

add_action( 'wp_enqueue_scripts', 'webendev_load_font_awesome', 99 );

function new_excerpt_more( $more ) {
	return '<div class="clearfix"><a class="btn btn-primary" style="float:right" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'your-text-domain') . '</a></div>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

?>