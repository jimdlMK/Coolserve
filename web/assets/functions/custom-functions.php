<?php
    /**
     * Geeft een <img> met automatische srcset/sizes terug voor een ACF image-array
     * (return_format => array), zodat elk scherm (incl. retina/HiDPI) de scherpste
     * passende variant laadt i.p.v. altijd dezelfde vaste resolutie.
     */
    function mk_image($image, $size = 'full', $attrs = []) {
        if (empty($image) || !is_array($image)) {
            return '';
        }

        $id = $image['ID'] ?? $image['id'] ?? 0;

        if ($id) {
            $html = wp_get_attachment_image((int) $id, $size, false, $attrs);
            if ($html) {
                return $html;
            }
        }

        // Fallback zonder attachment-ID (bv. handmatig ingevoerde URL): normale <img>.
        $class = isset($attrs['class']) ? ' class="' . esc_attr($attrs['class']) . '"' : '';
        return '<img src="' . esc_url($image['url'] ?? '') . '" alt="' . esc_attr($image['alt'] ?? '') . '"' . $class . '>';
    }

    /**
     * Custom nav menu walker: top-level items met kinderen krijgen een
     * mega-menu wrapper (grid van submenu-items met icoon + pijltje),
     * i.p.v. een standaard geneste dropdown-lijst.
     */
    class Mk_Mega_Menu_Walker extends Walker_Nav_Menu {
        private $mk_children_count = [];
        private $mk_seen_count = [];

        public function walk($elements, $max_depth, ...$args) {
            $this->mk_children_count = [];
            foreach ($elements as $element) {
                $parent = (int) $element->menu_item_parent;
                if ($parent) {
                    $this->mk_children_count[$parent] = ($this->mk_children_count[$parent] ?? 0) + 1;
                }
            }
            $this->mk_seen_count = [];

            return parent::walk($elements, $max_depth, ...$args);
        }

        public function start_lvl(&$output, $depth = 0, $args = null) {
            $output .= '<div class="mk-mega-menu"><div class="mk-mega-menu__inner"><div class="mk-mega-menu__content"><ul class="mk-mega-menu__grid">';
        }

        public function end_lvl(&$output, $depth = 0, $args = null) {
            $output .= '</ul></div></div></div>';
        }

        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $classes = empty($item->classes) ? [] : (array) $item->classes;

            if ($depth === 0) {
                $classes[] = 'menu-item';
                if (in_array('menu-item-has-children', $classes, true)) {
                    $classes[] = 'has-mega-menu';
                }

                $class_names = esc_attr(implode(' ', array_filter($classes)));
                $output .= '<li class="' . $class_names . '">';
                $output .= '<a href="' . esc_url($item->url) . '">';
                $output .= '<span class="menu-item__label">' . esc_html($item->title) . '</span>';
                $output .= '</a>';
                return;
            }

            // Submenu-item binnen een mega-menu
            $parent = (int) $item->menu_item_parent;
            $total  = $this->mk_children_count[$parent] ?? 0;
            $this->mk_seen_count[$parent] = ($this->mk_seen_count[$parent] ?? 0) + 1;
            $is_last = $this->mk_seen_count[$parent] === $total;

            $icon = get_field('menu_icon', $item->ID);
            if ($icon) {
                $icon_url = $icon['url'];
            } elseif ($is_last) {
                $icon_url = get_stylesheet_directory_uri() . '/assets/images/tandwiel.png';
            } else {
                $icon_url = '';
            }

            $arrow_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');

            $class_names = esc_attr(implode(' ', array_filter($classes)));
            $output .= '<li class="mk-mega-menu__item' . ($class_names ? ' ' . $class_names : '') . '">';
            $output .= '<a href="' . esc_url($item->url) . '" class="mk-mega-menu__item__link">';

            if ($icon_url) {
                $output .= '<img class="mk-mega-menu__item__icon" src="' . esc_url($icon_url) . '" alt="">';
            }

            $output .= '<span class="mk-mega-menu__item__label">' . esc_html($item->title) . '</span>';
            $output .= '<span class="mk-mega-menu__item__arrow">' . $arrow_icon . '</span>';
            $output .= '</a>';
        }

        public function end_el(&$output, $item, $depth = 0, $args = null) {
            $output .= '</li>';
        }
    }
?>
