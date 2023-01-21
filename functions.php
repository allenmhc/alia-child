<?php
function add_meta_tags() {
  echo '<meta name="apple-mobile-web-app-capable" content="yes">';
  echo '<meta name="apple-mobile-web-app-status-bar-style" content="default" />';
}
add_action('wp_head', 'add_meta_tags');

function alia_enqueue_styles() {

    $parent_style = 'alia-parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'alia-child-style',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style( 'metropolis',
        get_stylesheet_directory_uri() . '/assets/fonts/Metropolis/stylesheet.css',
        array(),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style( 'nunito sans',
        get_stylesheet_directory_uri() . '/assets/fonts/NunitoSans/stylesheet.css',
        array(),
        wp_get_theme()->get('Version')
    );

    if ( is_rtl() ) {
    	wp_style_add_data( $parent_style, 'rtl', 'replace' );
    }

}
add_action( 'wp_enqueue_scripts', 'alia_enqueue_styles' );

if ( ! function_exists( 'alia_custom_body_css' ) ) :
function alia_custom_body_css() {
  $main_font_css = 'nunito_sansregular, sans-serif';
  $main_bold_font_css = 'nunito_sansbold, sans-serif';
  $main_italic_font_css = 'nunito_sansitalic, sans-serif';
  $main_bold_italic_font_css = 'nunito_sansbold_italic, sans-serif';
  $custom_css = "body { font-family: {$main_font_css}; }";
  $custom_css .= "strong { font-family: {$main_bold_font_css}; font-style: normal; }";
  $custom_css .= "em { font-family: {$main_italic_font_css}; font-style: normal; }";
  $custom_css .= "strong em, em strong { font-family: {$main_bold_italic_font_css}; font-style: normal; }";
  wp_add_inline_style( 'alia-customstyle', $custom_css );
}
endif;
add_action( 'wp_enqueue_scripts', 'alia_custom_body_css', 60);

/* --------
 * add custom css.
------------------------------------------- */
if ( ! function_exists( 'alia_custom_css' ) ) :
function alia_custom_css() {

	$main_font_css = '';
	$title_font_css = '';
	$alia_custom_fonts_array = alia_custom_fonts_collection();

	if ( alia_option('alia_main_font', 'roboto') && alia_option('alia_main_font', 'roboto') != 'default') {
		if (alia_option('alia_main_font', 'roboto') == 'system') {
			$main_font_css = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';

		}else{
			$main_font_id = alia_option('alia_main_font', 'roboto');
			$main_custom_font = $alia_custom_fonts_array[$main_font_id];
			$main_font_css = $main_custom_font['css'];
		}
	}

	if ( alia_option('alia_title_font', 'poppins') && alia_option('alia_title_font', 'poppins') != 'default') {
		if (alia_option('alia_title_font', 'poppins') == 'system') {
			$title_font_css = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
		}else{
			$title_font_id = alia_option('alia_title_font', 'poppins');
			$title_custom_font = $alia_custom_fonts_array[$title_font_id];
			$title_font_css = $title_custom_font['css'];
		}

	}

	if (alia_option('alia_load_fonts_locally') == true) {
		// Load Google Fonts locally
		if ((alia_option('alia_main_font', 'roboto') == 'roboto') && (alia_option('alia_title_font', 'poppins') == 'poppins')) {
			wp_enqueue_style( 'alia-fonts', get_theme_file_uri('/assets/fonts/default-google-fonts.css'), array(), null );
		} else {
			if ( alia_option('alia_main_font', 'roboto') && alia_option('alia_main_font', 'roboto') != 'default' && alia_option('alia_main_font', 'roboto') != 'system' ) {
				wp_enqueue_style( 'alia-font-main', get_theme_file_uri('/assets/fonts/'.alia_option('alia_main_font', 'roboto').'.css'), array(), null );
			}

			if ( alia_option('alia_title_font', 'poppins') && alia_option('alia_title_font', 'poppins') != 'default' && alia_option('alia_title_font', 'poppins') != 'system' ) {
				wp_enqueue_style( 'alia-font-titles', get_theme_file_uri('/assets/fonts/'.alia_option('alia_title_font', 'poppins').'.css'), array(), null );
			}
		}
    wp_enqueue_style( 'alia-fonts', get_theme_file_uri('/assets/fonts/notoserif.css'), array(), null );
	} else {
		// Add custom fonts URL
		wp_enqueue_style( 'alia-fonts', alia_custom_fonts_url(), array(), null );
	}

	// Add custom fonts to style
    wp_enqueue_style(
        'alia-customstyle', get_theme_file_uri('/assets/css/customstyle.css')
    );

    $custom_css = "";

    if ($main_font_css) {
    	$custom_css .= "body { font-family: {$main_font_css}; }";
    }

    if ($title_font_css) {
    	$custom_css .= "h1, h2, h3, h4, h5, h6, .title, .text_logo, .comment-reply-title, .header_square_logo a.square_letter_logo { font-family: {$title_font_css}; }";
    }

    $main_color = "";
    if (alia_option('alia_main_color', '#ff374a')) {

    	$main_color = alia_option('alia_main_color', '#ff374a');

    	$custom_css .= "a { color: {$main_color}; }";

    	$custom_css .= "input[type='submit']:hover { background-color: {$main_color}; }";

    	$custom_css .= ".main_color_bg { background-color: {$main_color}; }";

    	$custom_css .= ".main_color_text { color: {$main_color}; }";

    	$custom_css .= ".social_icons_list.header_social_icons .social_icon:hover { color: {$main_color}; }";

    	$custom_css .= ".header_square_logo a.square_letter_logo { background-color: {$main_color}; }";

    	$custom_css .= ".header_nav .text_logo a span.logo_dot { background-color: {$main_color}; }";

    	$custom_css .= ".header_nav .main_menu .menu_mark_circle { background-color: {$main_color}; }";

    	$custom_css .= ".full_width_list .post_title a:hover:before { background-color: {$main_color}; }";

    	if ( is_rtl() ) {

	    	$custom_css .= ".full_width_list .post_title a:hover:after { background: linear-gradient(to left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%);
	  background: -ms-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -o-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -moz-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-gradient(linear,right top,left top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,rgba(255, 255, 255, 0.0)));; }";

	 		$custom_css .= ".grid_list .post_title a:hover:before { background-color: {$main_color}; }";

	 		$custom_css .= ".grid_list .post_title a:hover:after { background: linear-gradient(to left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%);
	  background: -ms-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -o-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -moz-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-gradient(linear,right top,left top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,rgba(255, 255, 255, 0.0)));; }";

			$custom_css .= ".two_coloumns_list .post_title a:hover:before { background-color: {$main_color}; }";

			$custom_css .= ".two_coloumns_list .post_title a:hover:after { background: linear-gradient(to left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%);
	 background: -ms-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -o-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -moz-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-gradient(linear,right top,left top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,rgba(255, 255, 255, 0.0)));; }";
 		}else{
 			$custom_css .= ".full_width_list .post_title a:hover:after { background: linear-gradient(to right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%);
	  background: -ms-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -o-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -moz-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-gradient(linear,left top,right top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,rgba(255, 255, 255, 0.0)));; }";

	 		$custom_css .= ".grid_list .post_title a:hover:before { background-color: {$main_color}; }";

	 		$custom_css .= ".grid_list .post_title a:hover:after { background: linear-gradient(to right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%);
	  background: -ms-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -o-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -moz-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-gradient(linear,left top,right top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,rgba(255, 255, 255, 0.0)));; }";

			$custom_css .= ".two_coloumns_list .post_title a:hover:before { background-color: {$main_color}; }";

			$custom_css .= ".two_coloumns_list .post_title a:hover:after { background: linear-gradient(to right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%);
	 background: -ms-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -o-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -moz-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,rgba(255, 255, 255, 0.0) 100%); background: -webkit-gradient(linear,left top,right top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,rgba(255, 255, 255, 0.0)));; }";
 		}
 		$custom_css .= ".post_meta_container a:hover { color: {$main_color}; }";

 		$custom_css .= ".post.sticky .blog_meta_item.sticky_post { color: {$main_color}; }";

 		$custom_css .= ".blog_post_readmore a:hover .continue_reading_dots .continue_reading_squares > span { background-color: {$main_color}; }";

 		$custom_css .= ".blog_post_readmore a:hover .continue_reading_dots .readmore_icon { color: {$main_color}; }";

 		$custom_css .= ".comment-list .reply a:hover { color: {$main_color}; }";

 		$custom_css .= ".comment-list .reply a:hover .comments_reply_icon { color: {$main_color}; }";

 		$custom_css .= "form.comment-form .form-submit input:hover { background-color: {$main_color}; }";

 		if ( is_rtl() ) {
 			$custom_css .= ".comment-list .comment.bypostauthor .comment-content:before { border-top-color: {$main_color}; border-right-color: {$main_color}; }";
 		}else{
 			$custom_css .= ".comment-list .comment.bypostauthor .comment-content:before { border-top-color: {$main_color}; border-left-color: {$main_color}; }";
 		}

 		$custom_css .= ".comments-area a:hover { color: {$main_color}; }";

 		$custom_css .= ".newsletter_susbcripe_form label .asterisk { color: {$main_color}; }";

 		$custom_css .= ".newsletter_susbcripe_form .mce_inline_error { color: {$main_color}!important; }";

 		$custom_css .= ".newsletter_susbcripe_form input[type='submit']:hover { background-color: {$main_color}; }";
 		$custom_css .= ".widget_content #mc_embed_signup input[type='submit']:hover { background-color: {$main_color}; }";

 		$custom_css .= ".social_icons_list .social_icon:hover { color: {$main_color}; }";

 		$custom_css .= ".alia_post_list_widget .post_info_wrapper .title a:hover { color: {$main_color}; }";

 		$custom_css .= ".tagcloud a:hover { color: {$main_color}; }";

 		$custom_css .= ".navigation.pagination .nav-links .page-numbers.current { background-color: {$main_color}; }";

 		$custom_css .= ".navigation_links a:hover { background-color: {$main_color}; }";

 		$custom_css .= ".page-links > a:hover, .page-links > span { background-color: {$main_color}; }";

 		$custom_css .= ".story_circle:hover { border-color: {$main_color}; }";

 		$custom_css .= ".see_more_circle:hover { border-color: {$main_color}; }";

 		$custom_css .= ".main_content_area.not-found .search-form .search_submit { background-color: {$main_color}; }";

 		$custom_css .= ".blog_list_share_container .social_share_item_wrapper a.share_item:hover { color: {$main_color}; }";

 		$custom_css .= ".widget_content ul li a:hover { color: {$main_color}; }";

 		$custom_css .= ".footer_widgets_container .social_icons_list .social_icon:hover { color: {$main_color}; }";

 		$custom_css .= ".footer_widgets_container .widget_content ul li a:hover { color: {$main_color}; }";

 		$custom_css .= ".cookies_accept_button { background-color: {$main_color}; }";

 		$custom_css .= ".alia_gototop_button > i { background-color: {$main_color}; }";

    }


    wp_add_inline_style( 'alia-customstyle', $custom_css );

}
endif;
add_action( 'wp_enqueue_scripts', 'alia_custom_css', 55 );

/* --------
post meta tags
------------------------------------------- */
if ( ! function_exists( 'alia_post_meta' ) ) :
function alia_post_meta($post_position = '') {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="blog_meta_item sticky_post">%s</span>', '<i class="fas fa-bookmark"></i>' );
	}

	$format = get_post_format();
	$standard_format_icon = 'fas fa-align-left standardpost_format_icon';

	#if ( current_theme_supports( 'post-formats', $format ) ) {

	switch ($format) {
		case 'audio':
			$format_icon = 'fas fa-headphones-alt';
			break;
		case 'video':
			$format_icon = 'fas fa-film';
			break;
		case 'image':
			$format_icon = 'far fa-image';
			break;
		case 'aside':
			$format_icon = 'far fa-sticky-note';
			break;
		case 'quote':
			$format_icon = 'fa-quote-left';
			break;
		case 'link':
			$format_icon = 'fa-external-link';
			break;
		case 'gallery':
			$format_icon = 'far fa-images';
			break;
		case 'status':
			$format_icon = 'far fa-clipboard';
			break;
		case 'chat':
			$format_icon = 'far fa-sticky-note';
			break;
		default:
			$format_icon = $standard_format_icon;
	}

	if (get_post_format() != '' ) {
		$post_format_link = '<a class="post_format_icon_link" href="'.get_post_format_link( $format ).'"><i class="'.$format_icon.' post_meta_icon '.$format.'post_fromat_icon"></i></a>';
	}else{
		$post_format_link = '<i class="'.$format_icon.' post_meta_icon '.$format.'post_fromat_icon"></i>';
	}


	if (alia_cross_option('alia_show_author_avatar', '', 1) && get_avatar(get_the_author_meta('ID')) ) {
		if ( in_array( get_post_type(), array( 'page', 'post' ) ) ) {
			//if ( is_multi_author() ) {
			printf( '<span class="post_meta_item meta_item_author_avatar"><a class="meta_author_avatar_url" href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				alia_filter_lazyload_images(get_avatar(get_the_author_meta('ID'), 40))
			);
			//}
		}
	}
	#}

	echo '<div class="post_meta_info post_meta_row clearfix">';

	if (alia_cross_option('alia_show_author', '', 1)) {
		if ( in_array( get_post_type(), array( 'page', 'post' ) ) ) {
			//if ( is_multi_author() ) {
				if ($post_position == 'normalhentry') {
					printf( '<span class="post_meta_item meta_item_author"><span class="author vcard author_name"><span class="fn"><a class="meta_author_name url" href="%1$s">%2$s</a></span></span></span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);
				}else{
					printf( '<span class="post_meta_item meta_item_author"><span class="author author_name"><span><a class="meta_author_name" href="%1$s">%2$s</a></span></span></span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);
				}

			//}
		}
	}

	if (alia_cross_option('alia_show_categories', '', 1) ) {
		$categories_list = get_the_category_list( '<span>'.esc_attr_x( ', ', 'Used between list items, there is a space after the comma.', 'alia' ).'</span>' );

		if ( $categories_list ) {

			printf( '<span class="post_meta_item meta_item_category">%1$s%2$s</span>',
				$post_format_link,
				$categories_list
			);
		}
	}

	if (alia_cross_option('alia_show_date', '', 1)) {
		if ( in_array( get_post_type(), array( 'page', 'post', 'attachment' ) ) ) {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date()
			);

			echo '<a class="post_date_link" href="'.get_permalink().'">';
				printf( '<span class="post_meta_item meta_item_date"><span class="screen-reader-text"></span>%1$s</span>', $time_string );
			echo '</a>';
		}
	}

	if (alia_cross_option('alia_show_views', '', 0) == 1) {
		if ( in_array( get_post_type(), array( 'page', 'post', 'attachment' ) ) ) {
			$views = (get_post_meta(get_the_ID(), 'hits')) ? get_post_meta(get_the_ID(), 'hits')[0] : 0 ;
			echo '<a class="post_view_link" href="'.get_permalink().'">';
			printf( '<span class="post_meta_item meta_item_view"><i class="post_meta_icon far fa-eye"></i>%1$s</span>',
			$views
						);
			echo '</a>';
		}
	}

	echo '</div>';

}
endif;

// About Me Widget Override
require dirname( __FILE__ ) . '/inc/widgets/about-me.php';

// Add more social networks
function alia_child_setup() {
	global $social_networks;

	$social_networks['mastodon'] = 'Mastodon';
}
add_action( 'after_setup_theme', 'alia_child_setup' );
?>
