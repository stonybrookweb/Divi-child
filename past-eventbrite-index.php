<?php
/**
 * Template Name: Past Eventbrite Events
 */

 get_header(); ?>

 	<div id="main-content">
 		<div class="container">
 			<div id="content-area" class="clearfix">

 			<?php
 				// Set up and call our Eventbrite query.
 				$events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
 					'display_private' => true,     // boolean
 					'status' => 'ended',           // string (only available for display_private true)
 					// 'nopaging' => false,        // boolean
 					// 'limit' => null,            // integer
 					// 'organizer_id' => null,     // integer
 					// 'p' => null,                // integer
 					// 'post__not_in' => null,     // array of integers
 					// 'venue_id' => null,         // integer
 					// 'category_id' => null,      // integer
 					// 'subcategory_id' => null,   // integer
 					// 'format_id' => null,        // integer
 				) ) );

 				if ( $events->have_posts() ) :
 					while ( $events->have_posts() ) : $events->the_post();?>

						<?php
						// workaround API incorrect linking
						$last_slash = strrpos($post->url, '/');
						$slug = substr($post->url, $last_slash);
						$slug = "/events" . $slug; // trailing slash included in results of substr
						?>

 						<article id="event-<?php the_ID(); ?>" <?php post_class("past-eventbrite"); ?>>
 							<header class="entry-header">
								<a class="post-thumbnail" href="<?php echo $slug; ?> "><img src="<?php echo $post->logo_url ;?>" class="wp-post-image"></a>

								<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', $slug ), '</a></h1>' ); ?>

								<div class="entry-meta">
                  <?php $venue = eventbrite_event_venue(); // get venue object for current event ?>
                  <p><?php echo eventbrite_event_time(); ?><br>
                  <?php echo $venue->name; ?><br>
                  <?php echo $venue->address->localized_address_display; ?></p>
								</div><!-- .entry-meta -->

							</header><!-- .entry-header -->
						</article><!-- #post-## -->

 					<?php endwhile;

 					// Previous/next post navigation.
 					eventbrite_paging_nav( $events );

 				else :
 					// If no content, include the "No posts found" template.
 					get_template_part( 'content', 'none' );

 				endif;

 			?>
 			</div> <!-- #content-area -->
 		 </div> <!-- .container -->
 		</div> <!-- #main-content -->


 <?php get_footer(); ?>
