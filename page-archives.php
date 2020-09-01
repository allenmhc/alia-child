<?php
  /**
   * Template Name: Archives Template
   *
   * @package WordPress
   * @subpackage Alia Child
   */
?>

<?php get_header(); ?>

<section id="primary" class="container main_content_area">
  <h4 class="page-title screen-reader-text"><?php  printf( esc_html__( '%1$s Archives.', 'alia' ), get_bloginfo( 'name' ) );; ?></h4>


  <?php
		echo '<div class="page_body stories_grid_wrapper row">';

			$last_date = '';
			$num = 0;
      $cache_duration = 100 * (24 * 60 * 60);
      //$cache_duration = 30;

      $first_year = date('Y', strtotime(get_posts(array(
        'numberposts' => 1,
        'post_status' => 'publish',
        'order' => 'ASC'
      ))[0]->post_date));

      for ($i = date('Y'); $i >= $first_year; $i--) {
        $link = get_year_link($i);

        echo '<a class="stories_day_container clearfix" href="' .$link. '">';
          echo '<h2 class="story-day-title section_title title col12">'.$i.'</h2>';

          // Cache this year's HTML instead of rebuilding it every time
          $found = false;
          $year_html = wp_cache_get($i, 'cache_archives_html', false, $found);
          if (!$found) {
            $wp_query = new WP_Query(array(
              'post_type' => 'post',
              'post_status' => 'publish',
              'date_query' => array('year' => $i),
              'meta_key' => '_thumbnail_id',
              'orderby' => 'rand',
              'posts_per_page' => 4
            ));

            $year_html = '';
            while ($wp_query->have_posts()) : $wp_query->the_post();
              $year_html .= '<span class="story_item col3">';
              $year_html .= get_the_post_thumbnail(
                get_the_ID(),
                'alia_story_thumbnail',
                array( 'class' => 'img-responsive' )
              );
              $year_html .= '</span>';
            endwhile;

            wp_cache_set($i, $year_html, 'cache_archives_html', $cache_duration);
          }
          echo $year_html;
        echo '</a>';
      }

		echo '</div>'; // stories_grid_wrapper
	?>

</section><!-- #primary -->

<?php get_footer(); ?>
