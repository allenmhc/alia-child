<?php
	// Show Featured on first page only if set
	if (alia_option('alia_featured_first_page') && (get_query_var( 'paged', 1 ) == 0)) {
    set_query_var('alia_content_width', 'wide');
    for ($i = 0; $i < 2; ++$i) {
      the_post();
      echo '<div class="row full_width_list first_full_width"><div class="col12">';
      get_template_part( 'template-parts/post/content', get_post_format() );
      echo '</div></div>'; // Close full_width_list row div and col12 div
    }
  }
?>

<div class="row grid_list grid_list_2_col">
<?php
/* Start the Loop */

set_query_var('alia_content_width', 'grid');
while ( have_posts() ) : the_post();
  echo '<div class="grid_col col6">';
    get_template_part( 'template-parts/post/content', get_post_format() );
  echo '</div>'; // end thepost_row row
endwhile;
?>
<!-- Close grid_list -->
</div>

<?php alia_pagination(); ?>
