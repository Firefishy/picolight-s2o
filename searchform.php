			<form method="get" id="sidebarsearch" action="<?php echo home_url(); ?>" >
				<label class="hidden" for="s"><?php _e('Search', 'picolight'); ?>:</label>
				<div>
					<input type="text" value="<?php get_search_query();?>" name="s" id="s" />
					<input type="submit" id="searchsubmit" value="<?php _e('Search', 'picolight'); ?>" /> 
				</div>
			</form>	
