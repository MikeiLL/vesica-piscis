<?php

define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width', 1600 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height', 230 ) );

function add_vesica_piscis_styles() {
    wp_enqueue_style( 'twenty-thirteen-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'vesica-piscis-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('twenty-thirteen-style')
    );
    wp_enqueue_style('vesica_piscis_styles', get_stylesheet_directory_uri().'/css/uru_plugin_styles.css');
}

add_action( 'wp_enqueue_scripts', 'add_vesica_piscis_styles' );

function add_test_scripts() {
	wp_enqueue_script('see_me', get_stylesheet_directory_uri() . '/js/add_schedule_button.js', array('jquery'), null, true);
	}
//add_action( 'wp_enqueue_scripts', 'add_test_scripts' );

// Override twentythirteen theme style

remove_theme_support( 'custom-header' );

function my_custom_header_setup() {
	$args = array(
		'default-text-color'     => '220e10',
		'default-image'          => '%s/images/headers/circle.png',

		'height'                 => 130,
		'width'                  => 1600,

		'wp-head-callback'       => 'my_header_style',
		'admin-head-callback'    => 'my_admin_header_style',
		'admin-preview-callback' => 'twentythirteen_admin_header_image',
	);
	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'my_custom_header_setup' );

function my_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();

	if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;
	?>
	<style type="text/css" id="twentythirteen-header-css">
	<?php
		if ( ! empty( $header_image ) ) :
	?>
		.site-header {
			background: url(<?php header_image(); ?>) no-repeat scroll top;
			background-size: 1600px auto;
		}
	<?php
		endif;

		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
			if ( empty( $header_image ) ) :
	?>
		.site-header .home-link {
			min-height: 0;
		}
	<?php
			endif;

		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-title,
		.site-description {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}

function my_admin_header_style() {
	$header_image = get_header_image();
?>
	<style type="text/css" id="twentythirteen-admin-header-css">
	.appearance_page_custom-header #headimg {
		border: none;
		-webkit-box-sizing: border-box;
		-moz-box-sizing:    border-box;
		box-sizing:         border-box;
		<?php
		if ( ! empty( $header_image ) ) {
			echo 'background: url(' . esc_url( $header_image ) . ') no-repeat scroll top; background-size: 1600px auto;';
		} ?>
		padding: 0 20px;
	}
	#headimg .home-link {
		-webkit-box-sizing: border-box;
		-moz-box-sizing:    border-box;
		box-sizing:         border-box;
		margin: 0 auto;
		max-width: 1040px;
		<?php
		if ( ! empty( $header_image ) || display_header_text() ) {
			echo 'min-height: 130px;';
		} ?>
		width: 100%;
	}
	<?php if ( ! display_header_text() ) : ?>
	#headimg h1,
	#headimg h2 {
		position: absolute !important;
		clip: rect(1px 1px 1px 1px); /* IE7 */
		clip: rect(1px, 1px, 1px, 1px);
	}
	<?php endif; ?>
	#headimg h1 {
		font: bold 60px/1 Bitter, Georgia, serif;
		margin: 0;
		padding: 58px 0 10px;
	}
	#headimg h1 a {
		text-decoration: none;
	}
	#headimg h1 a:hover {
		text-decoration: underline;
	}
	#headimg h2 {
		font: 200 italic 24px "Source Sans Pro", Helvetica, sans-serif;
		margin: 0;
		text-shadow: none;
	}
	.default-header img {
		max-width: 230px;
		width: auto;
	}
	</style>
<?php
}
?>
<?php
function add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info

function insert_fb_in_head() {
	global $post;
        setup_postdata($post);
        $default_image=get_stylesheet_directory_uri() . "/seed-of-life.png"; 
	if ( !is_singular()) //if it is not a post or a page
		{
		if (is_category())
			{
			echo '<meta property="og:description" content="URU Yoga News &amp; Events"/>';
        	echo '<meta property="og:url" content="' . get_permalink() . '"/>';
        	echo '<meta property="og:site_name" content="URU Yoga &amp; Beyond"/>';
        	echo '<meta property="og:image" content="' . $default_image . '"/>';
			}
		return;
		}
		else
		{
        echo '<meta property="fb:admins" content="1509922495"/>';
        echo '<meta property="og:title" content="' . get_the_title() . '"/>';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
        echo '<meta property="og:site_name" content="URU Yoga &amp; Beyond"/>';
        $the_excerpt = get_post($post->ID);
        $an_excerpt = wp_trim_words($the_excerpt->post_content);
        $caption_free_excerpt = preg_replace("/(<p>|<div .*>)(\s*)(<a .*>)?(\s*)(<img .* \/>)(\s*)(<\/a>)?(\s*)(<p .*>.*<\/p>)?(\s*)(<\/p>|<\/div>)/", "", $an_excerpt);
        $og_excerpt = isset($caption_free_excerpt) ? $caption_free_excerpt : bloginfo('description');
        echo '<meta property="og:description" content="'.$og_excerpt.'"/>';
			if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
				echo '<meta property="og:image" content="' . $default_image . '"/>';
			}
			else{
				$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
				echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
			}
	echo "
";	}
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );


/*
 * Add this so we can grab various sized image URLs from the Media Library.
*/
// Adds a "Sizes" column
function sizes_column( $cols ) {
        $cols["sizes"] = "Sizes";
        return $cols;
}

// Fill the Sizes column
function sizes_value( $column_name, $id ) {
    if ( $column_name == "sizes" ) {
        // Including the direcory makes the list much longer 
        // but required if you use /year/month for uploads
        $up_load_dir =  wp_upload_dir();
        $dir = $up_load_dir['url'];

        // Get the info for each media item
        $meta = wp_get_attachment_metadata($id);

        // and loop + output
        foreach ( $meta['sizes'] as $name=>$info) {
            // could limit which sizes are output here with a simple if $name ==
            echo "<strong>" . $name . "</strong><br>";
            echo "<small>" . $dir . "/" . $info['file'] . " </small><br>";
        }
    }
}

// Hook actions to admin_init
function hook_new_media_columns() {
    add_filter( 'manage_media_columns', 'sizes_column' );
    add_action( 'manage_media_custom_column', 'sizes_value', 10, 2 );
}
add_action( 'admin_init', 'hook_new_media_columns' )
?>