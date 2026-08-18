<?php get_header(); ?>
	<div id="main-content" class="<?php echo mkbase_main_class(); ?>">
		<?php while ( have_posts() ) : the_post();
			$dienst_form_id = get_field('diensten_contact_form_id', 'options');
		?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>

					<?php if ($dienst_form_id) :
						$mk_contact_formulier_id      = 'contact';
						$mk_contact_formulier_label   = 'Contact';
						$mk_contact_formulier_titel   = 'Klaar voor ' . get_the_title() . '?';
						$mk_contact_formulier_tekst   = 'Neem vrijblijvend contact met ons op voor advies op maat. Wij komen graag bij u langs voor een gratis inspectie en offerte.';
						$mk_contact_formulier_form_id = $dienst_form_id;
						include get_stylesheet_directory() . '/template-parts/blocks/contact-formulier/render.php';
					endif; ?>
				</div> <!-- .entry-content -->
			</article> <!-- #post -->
		<?php endwhile; ?>
	</div> <!-- #main-content -->
<?php get_footer(); ?>
