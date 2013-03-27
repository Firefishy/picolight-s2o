<?php
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'picolight' ); ?></p>
	<?php
		return;
	}
?>
<?php if ( have_comments() ) : ?>
<div id="comments">
			<h3><?php comments_number();?></h3>

			<div class="comment-nav">
				<div class="alignleft"><?php previous_comments_link(); ?></div>
				<div class="alignright"><?php next_comments_link(); ?></div>
			</div>
			<ol class="commentlist">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use twentyeleven_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define twentyeleven_comment() and that will be used instead.
					 * See twentyeleven_comment() in twentyeleven/functions.php for more.
					 */
					wp_list_comments( array( 'callback' => 'picolight_comment' ) );
				?>
			</ol>
			<div class="comment-nav">
				<div class="alignleft"><?php previous_comments_link(); ?></div>
				<div class="alignright"><?php next_comments_link(); ?></div>
			</div>
</div>
	<?php else : // this is displayed if there are no comments so far ?>

	<?php if (comments_open()) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php elseif (! comments_open() && ! is_page()) : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments closed', 'picolight')?>.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>
	<div id="comment-form">
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p><?php _e('You must be', 'picolight'); ?> <a href="/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in', 'picolight'); ?></a> <?php _e('to leave a reply', 'picolight'); ?>.</p>
		<?php else : ?>
			<?php comment_form(); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>
