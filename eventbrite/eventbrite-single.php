<?php
/**
 * The Template for displaying all single Eventbrite events.
 */

get_header(); ?>

	<div id="main-content">
		<div class="container">
			<div id="content-area" class="clearfix">

			<?php
				// Get our event based on the ID passed by query variable.
				$event = new Eventbrite_Query( array( 'p' => get_query_var( 'eventbrite_id' ) ) );

				if ( $event->have_posts() ) :
					while ( $event->have_posts() ) : $event->the_post(); ?>

						<article id="event-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php the_post_thumbnail(); ?>

								<h1 class="entry-title"><?php the_title(); ?></h1>

								<div class="entry-meta">
									<?php eventbrite_event_meta(); ?>
								</div><!-- .entry-meta -->
							</header><!-- .entry-header -->

							<div class="entry-content">
								<?php the_content(); ?>

								<?php eventbrite_ticket_form_widget(); ?>
							</div><!-- .entry-content -->
						</article><!-- #post-## -->

					<?php endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;

				// Return $post to its rightful owner.
				wp_reset_postdata();
			?>
			</div> <!-- #content-area -->
		</div> <!-- .container -->
	</div> <!-- #main-content -->
<?php get_footer(); ?>
