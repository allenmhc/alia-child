<?php
  /**
   * Template Name: Categories Template
   *
   * @package WordPress
   * @subpackage Alia Child
   */
?>

<?php get_header(); ?>

<section id="primary" class="container main_content_area">
  <h4 class="page-title screen-reader-text"><?php  printf( esc_html__( '%1$s Category Archives.', 'alia' ), get_bloginfo( 'name' ) );; ?></h4>
  <h1 class="entry-title title post_title section_title">Categories</h1>


  <?php
		echo '<div class="page_body stories_grid_wrapper row">';

    $categories = get_terms(array('taxonomy' => 'category'));
    $cache_duration = 30 * (24 * 60 * 60);
    //$cache_duration = 30;

    foreach($categories as $category) {
      $name = $category->name;
      $link = get_category_link($category->term_id);

      echo '<a class="stories_day_container clearfix category_container" href="' .$link. '">';
        echo '<span class="category_title story-day-title title col2">' .$name. '</span>';

        // Cache this category's HTML instead of rebuilding it every time
        $category_html = wp_cache_get($name, 'cache_category_html');
        if (!$category_html) {
          $wp_query = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'category_name' => $name,
            'orderby' => 'date',
            'posts_per_page' => 5
          ));

          $category_html = '<div class="stories_circles_wrapper col4">';
          while ($wp_query->have_posts()) : $wp_query->the_post();
            $category_html .= '<span data-postid="' .get_the_ID(). '" class="story_circle">';
            $post_thumbnail = get_the_post_thumbnail(
              get_the_ID(),
              'alia_thumbnail_avatar',
              array( 'class' => 'img-responsive' )
            );
            $category_html .= ($post_thumbnail ? $post_thumbnail : '<div class="empty_thumbnail_spacer"></div>');
            $category_html .= '</span>';
          endwhile;
          $category_html .= '</div>';

          wp_cache_set($name, $category_html, 'cache_category_html', $cache_duration);
        }
        echo $category_html;
      echo '</a>';
    }

		echo '</div>'; // stories_grid_wrapper
	?>

</section><!-- #primary -->

<?php get_footer(); ?>
