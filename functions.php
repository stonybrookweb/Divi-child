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

    // Font Awesome!!
    wp_enqueue_script( 'font-awesome', 'https://use.fontawesome.com/1798a3d786.js', array() ,false, true);

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

function eb_image(){
  global $post;
  $events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
    'limit' => 1,            // integer
  ) ) );

  ob_start();
  if ( $events->have_posts() ) :
    while ( $events->have_posts() ) : $events->the_post();
        // workaround API incorrect linking
        $last_slash = strrpos($post->url, '/');
        $slug = substr($post->url, $last_slash);
        $slug = "/events" . $slug; // trailing slash included in results of substr
        $site_url = site_url();
        $eb_event_local_url = $site_url . $slug;
        ?>

        <a class="post-thumbnail" href="<?php echo $eb_event_local_url; ?> "><img src="<?php echo $post->logo->original->url;?>" class="wp-post-image eb-homepage-event-image"></a>
        <?php
        endwhile;
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
  else :
    //If no event return an icon
      return '<i class="fa fa-calendar eb_event_placeholder_icon" aria-hidden="true"></i>';
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
  endif;
  // Return $post to its rightful owner.
  wp_reset_postdata();
}

add_shortcode( 'eb_widget', 'eb_widget');


function eb_title(){
  global $post;
  $events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
    'limit' => 1,            // integer
  ) ) );

  ob_start();
  if ( $events->have_posts() ) :
    while ( $events->have_posts() ) : $events->the_post();
        $last_slash = strrpos($post->url, '/');
        $slug = substr($post->url, $last_slash);
        $slug = "/events" . $slug; // trailing slash included in results of substr
        $site_url = site_url();
        $eb_event_local_url = $site_url . $slug;
        the_title( sprintf( '<h1 class="eb-entry-title"><a href="%s" rel="bookmark">', esc_url( $eb_event_local_url ) ), '</a></h1>' );
    endwhile;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  endif;
  // Return $post to its rightful owner.
  wp_reset_postdata();
}


add_shortcode( 'eb_title', 'eb_title');


function eb_description(){
  global $post;
  $events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
    'limit' => 1,            // integer
  ) ) );

  ob_start();
  if ( $events->have_posts() ) :
    while ( $events->have_posts() ) : $events->the_post();
        // workaround API incorrect linking
        $last_slash = strrpos($post->url, '/');
        $slug = substr($post->url, $last_slash);
        $slug = "/events" . $slug; // trailing slash included in results of substr
        $site_url = site_url();
        $eb_event_local_url = $site_url . $slug;

        // Get the excerpt and update with more link
        $eb_excerpt = get_the_excerpt();
        $eb_local_event_link = "<a href=" .  $site_url . $slug . ">Read Full Event Details</a>";
        $eb_needle = '&hellip;';
        $eb_excerpt =   str_replace($eb_needle, $eb_local_event_link, $eb_excerpt);
        echo $eb_excerpt;

    endwhile;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  else :
    // If no event return some default text
    $site_url = site_url();
    $eb_events_url = $site_url . '/events/recent-events/';
    $output = '<p>MBA Women Boston hosts many events during the year. Please check back often to see when our next event is scheduled.<p>';
    $output .= '<p>You can see the types of events we host by visting our <a href="' . $eb_events_url . '">recent events page.</a>';
    $output .= '<p>Sign up for our email list below and follow us on social media for event annoucements.';
    return $output;
  endif;
  // Return $post to its rightful owner.
  wp_reset_postdata();
}


add_shortcode( 'eb_description', 'eb_description');


// Footer year is set in theme options. This updates it to the current year
function updateFooterYear(){
  ?>
  <script>
  jQuery(document).ready(function(){
    var replacementText = jQuery('.copyright-year a').html().replace("2016", "<?php echo date('Y'); ?>");
    jQuery('.copyright-year a').html(replacementText);
  });
  </script>
<?php }

add_action('wp_footer', 'updateFooterYear');
?>
