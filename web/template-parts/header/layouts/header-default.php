<header class="mk-header">
	<div class="mk-header__topbar">
		<div class="mk-header__topbar__inner">
			<div class="mk-header__topbar__reviews">
				<svg class="mk-header__topbar__reviews__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
					<path fill="#4285F4" d="M23.52 12.273c0-.851-.076-1.67-.218-2.455H12v4.64h6.458a5.52 5.52 0 0 1-2.394 3.622v3.011h3.877c2.269-2.09 3.578-5.166 3.578-8.818Z"/>
					<path fill="#34A853" d="M12 24c3.24 0 5.955-1.075 7.941-2.909l-3.877-3.01c-1.075.72-2.45 1.145-4.064 1.145-3.126 0-5.771-2.111-6.716-4.948H1.28v3.108C3.256 21.302 7.31 24 12 24Z"/>
					<path fill="#FBBC05" d="M5.284 14.278A7.19 7.19 0 0 1 4.91 12c0-.79.136-1.56.375-2.278V6.614H1.28A11.996 11.996 0 0 0 0 12c0 1.936.464 3.769 1.28 5.386l4.004-3.108Z"/>
					<path fill="#EA4335" d="M12 4.773c1.762 0 3.344.606 4.59 1.795l3.442-3.442C17.951 1.19 15.236 0 12 0 7.31 0 3.256 2.698 1.28 6.614l4.004 3.108C6.229 6.884 8.874 4.773 12 4.773Z"/>
				</svg>
				<span class="mk-header__topbar__reviews__stars" aria-hidden="true">
					<span class="mk-header__topbar__reviews__stars__fg"></span>
				</span>
				<span class="mk-header__topbar__reviews__score">4,8</span>
			</div>
			<?php get_template_part('template-parts/header/nav-top'); ?>
		</div>
	</div>

	<div class="mk-header__main">
		<div class="mk-header__main__inner">
			<div class="mk-header__main__logo">
				<a class="mk-header__logo" href="<?php echo esc_url(home_url('/')); ?>">
					<img src="<?php echo esc_url(get_field('logo' , 'option')['url']);?>" alt="<?php bloginfo('name'); ?>">
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
