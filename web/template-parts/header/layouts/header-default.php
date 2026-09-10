<?php
	$mk_google_place_id = get_field('google_reviews_place_id', 'option');
	$mk_google_api_key  = get_field('google_reviews_api_key', 'option');
	$mk_google_data     = mk_get_google_reviews($mk_google_place_id, $mk_google_api_key);

	// Vaste fallback-waarde zolang Place ID/API key nog niet zijn ingesteld of de
	// live ophaling mislukt — zelfde als het eerdere hardcoded cijfer.
	$mk_header_rating = $mk_google_data ? $mk_google_data['rating'] : 4.9;
?>
<header class="mk-header">
	<div class="mk-header__topbar">
		<div class="mk-header__topbar__inner">
			<a class="mk-header__topbar__reviews" href="https://www.google.com/maps/place/Coolserve+BV/@52.9638978,5.8910007,17z/data=!4m8!3m7!1s0x47c85fc6f2e37cf1:0xb2108c1619625083!8m2!3d52.9638978!4d5.8910007!9m1!1b1!16s%2Fg%2F11j64qy0vw" target="_blank" rel="noopener">
				<svg class="mk-header__topbar__reviews__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
					<path fill="#4285F4" d="M23.52 12.273c0-.851-.076-1.67-.218-2.455H12v4.64h6.458a5.52 5.52 0 0 1-2.394 3.622v3.011h3.877c2.269-2.09 3.578-5.166 3.578-8.818Z"/>
					<path fill="#34A853" d="M12 24c3.24 0 5.955-1.075 7.941-2.909l-3.877-3.01c-1.075.72-2.45 1.145-4.064 1.145-3.126 0-5.771-2.111-6.716-4.948H1.28v3.108C3.256 21.302 7.31 24 12 24Z"/>
					<path fill="#FBBC05" d="M5.284 14.278A7.19 7.19 0 0 1 4.91 12c0-.79.136-1.56.375-2.278V6.614H1.28A11.996 11.996 0 0 0 0 12c0 1.936.464 3.769 1.28 5.386l4.004-3.108Z"/>
					<path fill="#EA4335" d="M12 4.773c1.762 0 3.344.606 4.59 1.795l3.442-3.442C17.951 1.19 15.236 0 12 0 7.31 0 3.256 2.698 1.28 6.614l4.004 3.108C6.229 6.884 8.874 4.773 12 4.773Z"/>
				</svg>
				<?php echo mk_star_rating_html($mk_header_rating); ?>
				<strong class="mk-header__topbar__reviews__score"><?php echo esc_html(number_format_i18n($mk_header_rating, 1)); ?></strong>
			</a>
			<?php get_template_part('template-parts/header/nav-top'); ?>
		</div>
	</div>

	<div class="mk-header__main">
		<div class="mk-header__main__inner">
			<div class="mk-header__main__logo">
				<a class="mk-header__logo" href="<?php echo esc_url(home_url('/')); ?>">
					<?php echo mk_image(get_field('logo', 'option'), 'full', ['alt' => get_bloginfo('name')]); ?>
				</a>
			</div>
			<div class="mk-header__main__nav">
				<?php get_template_part('template-parts/header/nav-main'); ?>
				<div class="open-mobile-menu">
					<span class="lineone"></span>
					<span class="linetwo"></span>
					<span class="linethree"></span>
				</div>
			</div>
		</div>
	</div>
</header>
