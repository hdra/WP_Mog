<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Mog
 * @since Mog 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses mog_header_style()
 * @uses mog_admin_header_style()
 * @uses mog_admin_header_image()
 *
 * @package Mog
 */
function mog_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'mog_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000',
		'width'                  => 1000,
		'height'                 => 200,
		'flex-height'            => true,
		'flex-width'            => true,
		'wp-head-callback'       => 'mog_header_style',
		'admin-head-callback'    => 'mog_admin_header_style',
		'admin-preview-callback' => 'mog_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'mog_custom_header_setup' );


if ( ! function_exists( 'mog_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see mog_custom_header_setup().
 *
 * @since Mog 1.0
 */
function mog_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.header-title{ display: none;}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // mog_header_style

if ( ! function_exists( 'mog_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see mog_custom_header_setup().
 *
 * @since Mog 1.0
 */
function mog_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#headimg h2,
	#desc {
		text-align: center;
	}
	#headimg h2 {
		font-style: italic;
		color: #777;
	}
	#headimg h1 a div{
		font-size: 2.5em;
	}
	</style>
<?php
}
endif; // mog_admin_header_style

if ( ! function_exists( 'mog_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see mog_custom_header_setup().
 *
 * @since Mog 1.0
 */
function mog_admin_header_image() { ?>
	<div id="headimg">
		<?php
			if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
				$style = ' style="display:none;"';
			else
				$style = ' style="color:#' . get_header_textcolor() . ';"';
		?>
		<h1>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"  onclick="return false;">
				<?php
					$header_image = get_header_image();
					if ( ! empty( $header_image ) ): ?>
						<img src="<?php header_image(); ?>" alt="<?php bloginfo('name'); ?>"/>
				<?php endif; ?>
				<div <?php echo $style; ?> class="header-title"><?php bloginfo('name'); ?></div>
			</a>
		</h1>
		<h2 <?php echo $style; ?>><?php bloginfo( 'description' ); ?></h2>
	</div>
<?php }
endif; // mog_admin_header_image