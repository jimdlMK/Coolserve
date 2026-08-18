<?php get_header(); ?>
	<div id="main-content" class="<?php echo mkbase_main_class(); ?>">
		<?php while ( have_posts() ) : the_post();
			$introtekst = get_field('introtekst');
			$locatie    = get_field('locatie');
			$uren       = get_field('uren');
			$salaris    = get_field('salaris');
			$locaties   = $locatie ? array_map('trim', explode(',', $locatie)) : [];

			$rol_tekst         = get_field('rol_tekst');
			$rol_afbeelding    = get_field('rol_afbeelding');
			$taken_tekst       = get_field('taken_tekst');
			$profiel_tekst     = get_field('profiel_tekst');
			$aanbod_tekst      = get_field('aanbod_tekst');
			$aanbod_afbeelding = get_field('aanbod_afbeelding');

			$overzicht_pagina = get_field('vacatures_overzicht_pagina', 'options');
			$form_id          = get_field('sollicitatie_form_id', 'options');

			$arrow_icon    = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');
			$koffer_icon   = file_get_contents(get_stylesheet_directory() . '/assets/images/koffer-icon.svg');
			$location_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/location-pin-grey.svg');
			$salaris_icon  = file_get_contents(get_stylesheet_directory() . '/assets/images/salaris-icon.svg');
		?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">

					<section class="mk-vacature-kop">
						<div class="mk-vacature-kop__container">
							<div class="mk-vacature-kop__container__inner">

								<h1 class="mk-vacature-kop__titel"><?php the_title(); ?></h1>

								<?php
									$overzicht_url = $overzicht_pagina ? get_permalink($overzicht_pagina) : '';
									if (!$overzicht_url) {
										$werken_bij_fallback = get_page_by_path('werken-bij');
										if ($werken_bij_fallback) {
											$overzicht_url = get_permalink($werken_bij_fallback);
										}
									}
								?>
								<nav class="mk-breadcrumbs">
									<a href="<?php echo esc_url(home_url()); ?>">Home</a>
									<span class="mk-breadcrumbs-sep">›</span>
									<?php if ($overzicht_url) : ?>
										<a href="<?php echo esc_url($overzicht_url); ?>">Werken bij</a>
									<?php else : ?>
										<span>Werken bij</span>
									<?php endif; ?>
									<span class="mk-breadcrumbs-sep">›</span>
									<strong><?php the_title(); ?></strong>
								</nav>

								<div class="mk-vacature-kop__sub">
									<?php if ($introtekst) : ?>
										<p class="mk-vacature-kop__sub__tekst"><?php echo esc_html($introtekst); ?></p>
									<?php endif; ?>

									<?php if ($form_id) : ?>
										<a class="btn btn--primary mk-vacature-kop__sub__cta" href="#solliciteren">
											<span>Direct solliciteren</span>
											<?php echo $arrow_icon; ?>
										</a>
									<?php endif; ?>
								</div>

								<?php if ($uren || $locaties || $salaris) : ?>
									<div class="mk-vacature-kop__labels">
										<?php if ($uren) : ?>
											<span class="mk-vacature-label mk-vacature-label--blauw"><?php echo $koffer_icon; ?><?php echo esc_html($uren); ?></span>
										<?php endif; ?>
										<?php foreach ($locaties as $loc) : ?>
											<span class="mk-vacature-label mk-vacature-label--grijs"><?php echo $location_icon; ?><?php echo esc_html($loc); ?></span>
										<?php endforeach; ?>
										<?php if ($salaris) : ?>
											<span class="mk-vacature-label mk-vacature-label--groen"><?php echo $salaris_icon; ?><?php echo esc_html($salaris); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>

							</div>
						</div>
					</section>

					<?php if ($rol_tekst || $rol_afbeelding) : ?>
						<section class="mk-vacature-sectie mk-vacature-sectie--media">
							<div class="mk-vacature-sectie__container">
								<div class="mk-vacature-sectie__container__inner">
									<?php if ($rol_tekst) : ?>
										<div class="mk-vacature-sectie__body"><?php echo wp_kses_post($rol_tekst); ?></div>
									<?php endif; ?>
									<?php if ($rol_afbeelding) : ?>
										<div class="mk-vacature-sectie__media">
											<img src="<?php echo esc_url($rol_afbeelding['url']); ?>" alt="<?php echo esc_attr($rol_afbeelding['alt']); ?>">
										</div>
									<?php endif; ?>
								</div>
							</div>
						</section>
					<?php endif; ?>

					<?php if ($taken_tekst || $profiel_tekst) : ?>
						<section class="mk-vacature-taken-profiel">
							<div class="mk-vacature-taken-profiel__container">
								<div class="mk-vacature-taken-profiel__container__inner">
									<?php if ($taken_tekst) : ?>
										<div class="mk-vacature-taken-profiel__col">
											<h2 class="mk-vacature-taken-profiel__col__titel">Wat ga je <span>doen?</span></h2>
											<div class="mk-vacature-taken-profiel__col__body"><?php echo wp_kses_post($taken_tekst); ?></div>
										</div>
									<?php endif; ?>
									<?php if ($profiel_tekst) : ?>
										<div class="mk-vacature-taken-profiel__col">
											<h2 class="mk-vacature-taken-profiel__col__titel">Wat neem je <span>mee?</span></h2>
											<div class="mk-vacature-taken-profiel__col__body"><?php echo wp_kses_post($profiel_tekst); ?></div>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</section>
					<?php endif; ?>

					<?php if ($aanbod_tekst || $aanbod_afbeelding) : ?>
						<section class="mk-vacature-sectie mk-vacature-sectie--media">
							<div class="mk-vacature-sectie__container">
								<div class="mk-vacature-sectie__container__inner">
									<div class="mk-vacature-sectie__body">
										<?php if ($aanbod_tekst) : ?>
											<h2 class="mk-vacature-sectie__titel">Wat bieden <span>wij?</span></h2>
											<?php echo wp_kses_post($aanbod_tekst); ?>
										<?php endif; ?>
									</div>
									<?php if ($aanbod_afbeelding) : ?>
										<div class="mk-vacature-sectie__media">
											<img src="<?php echo esc_url($aanbod_afbeelding['url']); ?>" alt="<?php echo esc_attr($aanbod_afbeelding['alt']); ?>">
										</div>
									<?php endif; ?>
								</div>
							</div>
						</section>
					<?php endif; ?>

					<?php if ($form_id) :
						$mk_contact_formulier_id      = 'solliciteren';
						$mk_contact_formulier_label   = 'Solliciteren';
						$mk_contact_formulier_titel   = 'Klaar om te solliciteren?';
						$mk_contact_formulier_tekst   = 'Stuur je CV en motivatie via het formulier of neem direct contact met ons op. We kijken uit naar je reactie!';
						$mk_contact_formulier_form_id = $form_id;
						include get_stylesheet_directory() . '/template-parts/blocks/contact-formulier/render.php';
					endif; ?>

				</div> <!-- .entry-content -->
			</article> <!-- #post -->
		<?php endwhile; ?>
	</div> <!-- #main-content -->
<?php get_footer(); ?>
