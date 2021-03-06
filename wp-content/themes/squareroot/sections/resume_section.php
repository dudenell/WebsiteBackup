<?php global $squareroot_data; ?>
	<?php the_content(); ?>

	<?php
	// get all the categories from the database
	$args = array(
		'taxonomy' => 'resume_filter'
	);
	$cats = get_categories( $args );

	// loop through the categries
	foreach ($cats as $cat) {

	// setup the cateogory ID
	$cat_id = $cat->term_id;
	// Make a header for the cateogry
	echo '<div class="' . $cat->name . ' timeline-cont clearfix">';
	echo '<span class="title"><strong>' . $cat->name . '</strong></span>';
	// create a custom wordpress query

	query_posts( "post_type=resume" );
	$count = 1;

	// start the wordpress loop!
	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // create our link now that the post is setup ?>
		<?php
		$taxonomy = strip_tags( get_the_term_list( $post->ID, 'resume_filter', '', ', ', '' ) );
		if ( $cat->name == $taxonomy ) {
			if ( $count % 2 != 0 ) {
				echo '<div class="group group-' . $count . ' clearfix">';
				echo '<span class="date">' . get_the_time( $squareroot_data['date_format'] ) . '</span>';
				echo '<span class="point-circle"></span>';

				echo '<div class="desc-box">';
				echo '<h4>' . get_the_title() . '</h4>';
				echo '<span class="sub-title">' . get_the_excerpt() . '</span>';
				echo '<p>' . get_the_content() . '</p>';
				echo '</div>';
				echo '</div>';
			} else {
				echo '<div class="group group-' . $count . ' group-alter clearfix">';
				echo '<div class="desc-box">';
				echo '<h4>' . get_the_title() . '</h4>';
				echo '<span class="sub-title">' . get_the_excerpt() . '</span>';
				echo '<p>' . get_the_content() . '</p>';
				echo '</div>';
				echo '<span class="point-circle"></span>';
				echo '<span class="date">' . get_the_time( $squareroot_data['date_format'] ) . '</span>';
				echo '</div>';
			}
			$count ++;

		}
		?>
	<?php endwhile; endif; // done our wordpress loop. Will start again for each category ?>
</div>
<?php } // done the foreach statement ?>
<?php if ( isset ( $count ) ) { ?>
	<div class="end-box clearfix">
		<span class="title end-of-box"><strong>End</strong></span>
	</div>
<?php } ?>