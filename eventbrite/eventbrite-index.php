<?php
/**
 * Template Name: Eventbrite Events
 */

get_header(); ?>

	<div id="main-content">
		<div class="container">
			<div id="content-area" class="clearfix">



			<?php
				// Set up and call our Eventbrite query.
				$events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
					// 'display_private' => false, // boolean
					// 'status' => 'live',         // string (only available for display_private true)
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
					while ( $events->have_posts() ) : $events->the_post(); ?>

						<article id="event-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php the_post_thumbnail(); ?>

								<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

								<div class="entry-meta">
									<?php // eventbrite_event_meta(); ?>

									<?php $venue = eventbrite_event_venue(); // get venue object for current event ?>
									<p><?php echo eventbrite_event_time(); ?><br>
									<?php echo $venue->name; ?><br>
									<?php echo $venue->address->localized_address_display; ?><br>
									<a href="<?php echo eventbrite_event_eb_url(); ?>" target="_blank">Details</a></p>

								</div><!-- .entry-meta -->
							</header><!-- .entry-header -->

							<div class="entry-content">
								<?php eventbrite_ticket_form_widget(); ?>
							</div><!-- .entry-content -->

						</article><!-- #post-## -->

					<?php endwhile;

					// Previous/next post navigation.
					eventbrite_paging_nav( $events );

				else :
					//If no events post a custom notice
				?>

					<article>
						<header class="entry-header no-events-scheduled">
							<h1> There are no events currently scheduled.</h1>
							<h2>Please check back soon!</h2>
							<p>Take a look at some of our <a href="https://www.mbawomenboston.org/events/recent-events/">past events.</a></p>
						</header><!-- .entry-header -->
					</article><!-- #post-## -->

				<?php endif;

				// Return $post to its rightful owner.
				wp_reset_postdata();
			?>


			</div> <!-- #content-area -->
		</div> <!-- .container -->

		</div> <!-- #main-content -->

<?php get_footer(); ?>
