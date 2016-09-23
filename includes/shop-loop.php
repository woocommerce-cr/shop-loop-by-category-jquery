<div class="related-products">
	<form class="location">
		<?php
			$epLocation = $_GET['eplocation'];
		?>
		<label>
			By category
			<select>
				<option>- Choose location -</option>
				<?php
				  $taxonomy     = 'product_cat';
				  $orderby      = 'name';  
				  $show_count   = 0;      // 1 for yes, 0 for no
				  $pad_counts   = 0;      // 1 for yes, 0 for no
				  $hierarchical = 1;      // 1 for yes, 0 for no  
				  $title        = '';  
				  $empty        = 0;

				  $args = array(
				         'taxonomy'     => $taxonomy,
				         'orderby'      => $orderby,
				         'show_count'   => $show_count,
				         'pad_counts'   => $pad_counts,
				         'hierarchical' => $hierarchical,
				         'title_li'     => $title,
				         'hide_empty'   => $empty
				  );
				 $all_categories = get_categories( $args );
				 foreach ($all_categories as $cat) {
				    if($cat->category_parent == 0) {
				        $category_id = $cat->term_id;       
				        echo '<optgroup label="'. $cat->name .'"'. get_term_link($cat->slug, 'product_cat') .'/>';

				        $args2 = array(
				                'taxonomy'     => $taxonomy,
				                'child_of'     => 0,
				                'parent'       => $category_id,
				                'orderby'      => $orderby,
				                'show_count'   => $show_count,
				                'pad_counts'   => $pad_counts,
				                'hierarchical' => $hierarchical,
				                'title_li'     => $title,
				                'hide_empty'   => $empty
				        );
				        $sub_cats = get_categories( $args2 );
				        if($sub_cats) {
				            foreach($sub_cats as $sub_category) {
				                echo  '<option value="'.$sub_category->slug.'">'.$sub_category->name.'</option>' ;
				            }   
				        }
				    }       
				}
				?>
			</select>
		</label>
	</form>

	<script type="text/javascript">
		$('form.location select').change(function()
		{
			window.location.href = '?eplocation='+$(this).val();
		});
	</script>

	<div class="grid">
		<?php
		$params = array('posts_per_page' => 50, 'post_type' => 'product', 'meta_key' => 'post_type_save', 'product_cat' => $epLocation);
		$wc_query = new WP_Query($params);
		?>
		<?php if ($wc_query->have_posts()) : ?>
		<?php while ($wc_query->have_posts()) :
		$wc_query->the_post(); ?>

		<div class="inl">
			<span class="content-tag">Save <?php the_field('post_type_save'); ?></span>
			<i class="preview-image" style="background-image: url(<?php the_post_thumbnail_url(); ?>);"></i>
			<h3>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<a href="<?php the_permalink(); ?>" class="inl btn-2">View Details</a>
		</div><!--Inline-->

		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
		<?php else:  ?>
		<p>
		<?php _e( 'No Products'); ?>
		</p>
		<?php endif; ?>
	</div>

</div><!--Related products-->
