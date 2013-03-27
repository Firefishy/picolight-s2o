<?php get_header(); ?>

	<div id="content">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			 <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="title">
					<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				</div>
					<div class="meta"><a href="<?php the_permalink() ?>"><?php the_time('d. F Y') ?></a> &middot; <?php comments_popup_link(__('Write a comment', 'picolight'), __('1 comment', 'picolight'), __('% comments', 'picolight')); ?>
					<?php
						picolight_show_categories();
						picolight_show_tags();
					?>
					<?php edit_post_link( __( '(Edit)', 'picolight' ), '<span class="edit-link">', '</span>' ); ?></div>

				<div class="entry">
					<?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { ?>

					<div class="thumbnail">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
							<?php the_post_thumbnail(); ?>
						</a>
					</div>
					<div class="indexexzerpt">
						<?php the_content(__('More &raquo;', 'picolight')); ?>
					</div>
					<?php }
					else {
						the_content(__('More &raquo;', 'picolight'));
					} ?>
					<?php if(wp_link_pages('echo=0') != "") { 
						echo '<div class="pagelinks">';
						wp_link_pages();
						echo '</div>';
					} ?>
				</div>
			</div>

		<?php endwhile; ?>
		<?php 
		if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		else { 
		?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo;  Older articles', 'picolight')); ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer articles &raquo;', 'picolight')); ?></div>
		</div>

		
		<?php } ?>

	<?php else : ?>

		<div class="page" >
			<h2><?php _e('Sorry, nothing found.', 'picolight'); ?></h2>
			<div class="entry">		
				<p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'picolight' );?>.</p>
			</div>
		</div>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
