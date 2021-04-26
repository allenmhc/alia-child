<?php
global $alia_header_h1_tag;
if ($alia_header_h1_tag == 1 && is_front_page()) {
	$text_logo_attr = 'h1';
} else {
	$text_logo_attr = 'p';
}

if (alia_option('alia_default_logo_retina')) {
	$is_retina_logo = " no_retina_logo";
} else {
	$is_retina_logo = " has_retina_logo";
}
?>

<div class="container">

	<?php // if image & title are shown in the top bar
	if (alia_cross_option('alia_show_header_site_title', '', 1)): ?>
		<div class="site_branding">
			<<?php echo $text_logo_attr; ?> class="text_logo"><?php
				?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <span class="logo_weak">in</span><span class="logo_strong">retrospect</span>
        <?php
					if (alia_cross_option('alia_show_site_title_dot', '', 1)): ?><span class="logo_dot"></span><?php endif;
				?></a>
			</<?php echo $text_logo_attr; ?>>
			<?php if ($alia_header_h1_tag == 1) { ?>
				<h3 class="screen-reader-text"><?php bloginfo( 'name' ); ?></h3>
			<?php } ?>
      <div class="text_tagline">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
          <span class="tagline_extended">creating</span> space for reflection
        </a>
      </div>
      </a>
		</div>
	<?php endif; ?>


	<!-- Place header control before main menu if site title is enabled -->
	<?php if (alia_cross_option('alia_show_header_site_title', '', 1)): ?>
		<div class="header_controls">

			<!-- start search box -->
			<div class="header_search header_control_wrapper">
					<?php get_template_part( 'header', 'searchform' ); ?>
			</div>
			<!-- end search box -->

      <!-- start rss -->
      <div class="header_rss header_control_wrapper">
        <a href="<?php echo esc_url( home_url( '/feed' ) ); ?>" rel="rss">
          <i class="fas fa-rss header_control_icon"></i>
        </a>
      </div>
      <!-- end rss -->

			<?php if( has_nav_menu( 'top' ) || is_active_sidebar( 'sidebar-sliding' ) ): ?>
			<div class="header_sliding_sidebar_control header_control_wrapper">
				<a id="user_control_icon" class="sliding_sidebar_button" href="#">
					<i class="fas fa-bars header_control_icon"></i>
				</a>
			</div>
			<?php endif; ?>

		</div>
	<?php endif; ?>


	<?php if ( has_nav_menu( 'top' ) ) : ?>
		<div class="main_menu">
			<?php get_template_part( 'template-parts/header/navigation', 'top' ); ?>
			<span class="menu_mark_circle hidden_mark_circle"></span>
		</div>
	<?php endif; ?>

	<!-- Place header control after main menu if site title is enabled -->
	<?php if (!alia_cross_option('alia_show_header_site_title', '', 1)): ?>
		<div class="header_controls">

			<!-- start search box -->
			<div class="header_search header_control_wrapper">
					<?php get_template_part( 'header', 'searchform' ); ?>
			</div>
			<!-- end search box -->

      <!-- start rss -->
      <div class="header_search header_control_wrapper">
        <a href="<?php echo esc_url( home_url( '/feed' ) ); ?>" rel="rss">
          <i class="fas fa-rss header_control_icon"></i>
        </a>
      </div>
      <!-- end rss -->

			<?php if( has_nav_menu( 'top' ) || is_active_sidebar( 'sidebar-sliding' ) ): ?>
			<div class="header_sliding_sidebar_control header_control_wrapper">
				<a id="user_control_icon" class="sliding_sidebar_button" href="#">
					<i class="fas fa-bars header_control_icon"></i>
				</a>
			</div>
			<?php endif; ?>

		</div>
	<?php endif; ?>

</div><!-- end .container -->
