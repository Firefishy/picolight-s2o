<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			 <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="title">
					<h1><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
				</div>
					<div class="meta"><a href="<?php the_permalink() ?>"><?php the_time('d. F Y') ?></a> &middot; <?php comments_popup_link(__('Write a comment', 'picolight'), __('1 comment', 'picolight'), __('% comments', 'picolight')); ?>
					<?php
						picolight_show_categories();
						picolight_show_tags();
					?>
					<?php edit_post_link( __('(Edit)', 'picolight'), '<span class="edit-link">', '</span>' ); ?></div>					
				<div class="entry">
					<?php the_content(__('More &raquo;', 'picolight')); ?>
					<div class="pagelinks">
						<?php wp_link_pages(); ?>
					</div>
				</div>			
			</div>
			<?php comments_template('', true); ?>

	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no article found', 'picolight'); ?>.</p>

<?php endif; ?>

	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>
