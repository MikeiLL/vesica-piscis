<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'main' ); ?>

			<div class="site-info">
				<?php do_action( 'twentythirteen_credits' ); ?>
				&copy; URU Yoga | <a href="https://www.google.com/maps?q=2400+Executive+Plaza+Drive+Pensacola,+FL+32504&amp;hl=en&amp;sll=30.481344,-87.196012&amp;sspn=0.0076,0.01502&amp;hnear=2400+Executive+Plaza+Rd,+Pensacola,+Florida+32504&amp;t=m&amp;z=16" target="_blank">2400 Executive Plaza Drive Pensacola, FL 32504</a>
| 850-377-5334 | Developed by <a href="http://www.mzoo.org" target="_blank">mZoo</a> using <?php printf( __( 'Wordpress', 'twentythirteen' ), 'WordPress' ); ?><!--SOFTACULOUS-->
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>