<?php
// Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles');

function my_theme_enqueue_styles(){

    $parent_style = 'parent-style'; // This is 'Divi-style' for the Divi theme.

    // load parent theme stylesheet
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // load child theme stylesheet  // WordPress seems to do automatically don't duplicate
    // wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style), wp_get_theme()->get('Version'));

    // load custom scripts from child theme
    wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/scripts/site.js', array() ,false, true);

}


function themeslug_setup() {
    /**
     * Add theme support for the Eventbrite API plugin.
     * See: https://wordpress.org/plugins/eventbrite-api/
     * Source: https://themeshaper.com/2014/12/08/working-with-the-eventbrite-api-plugin/
     */
    add_theme_support( 'eventbrite' );
}
add_action( 'after_setup_theme', 'themeslug_setup' );


// Create Shortcodes for use in Divi Theme Page Builder
// TODO: Refactor these shortcodes more efficiently if possible but keeping in mind using shortcodes in Divi Page Builder
// This way works best so far after several attempts

function eb_image(){
  $events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
    'limit' => 1,            // integer
  ) ) );

  ob_start();
  if ( $events->have_posts() ) :
    while ( $events->have_posts() ) : $events->the_post();
    // TODO: Get original uncropped image instead of image cropped to Eventbrite specs.
    // print "<pre>";
    // print_r($post);
    // echo "original image url: ";
    // echo $post->logo->original->url;
    // echo "<br>";
        the_post_thumbnail();
    endwhile;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  else :
    // TODO: Determine what to do for home page if no current events
    return none;
  endif;
  // Return $post to its rightful owner.
  wp_reset_postdata();
}

add_shortcode( 'eb_image', 'eb_image');

function eb_widget(){
  $events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
    'limit' => 1,            // integer
  ) ) );

  ob_start();
  if ( $events->have_posts() ) :
    while ( $events->have_posts() ) : $events->the_post();
        eventbrite_ticket_form_widget();
    endwhile;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  else :
    // TODO: Determine what to do for home page if no current events
    return none;
  endif;
  // Return $post to its rightful owner.
  wp_reset_postdata();
}

add_shortcode( 'eb_widget', 'eb_widget');


function eb_title(){
  $events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
    'limit' => 1,            // integer
  ) ) );

  ob_start();
  if ( $events->have_posts() ) :
    while ( $events->have_posts() ) : $events->the_post();
        the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
        // eventbrite_event_meta();
    endwhile;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  else :
    // TODO: Determine what to do for home page if no current events
    return none;
  endif;
  // Return $post to its rightful owner.
  wp_reset_postdata();
}

add_shortcode( 'eb_title', 'eb_title');

function eb_meta(){
  $events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
    'limit' => 1,            // integer
  ) ) );

  ob_start();
  if ( $events->have_posts() ) :
    while ( $events->have_posts() ) : $events->the_post();
        eventbrite_event_meta();
    endwhile;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  else :
    // TODO: Determine what to do for home page if no current events
    return none;
  endif;
  // Return $post to its rightful owner.
  wp_reset_postdata();
}

add_shortcode( 'eb_meta', 'eb_meta');
?>
