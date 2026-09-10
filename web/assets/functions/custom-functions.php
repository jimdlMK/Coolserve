<?php
    /**
     * Haalt live Google-reviews (+ overall rating) op voor een Place ID via de
     * Google Places API, 1x per dag gecached in een transient (voorkomt onnodige
     * API-kosten/traagheid bij elke paginaweergave). Geeft false terug zodra
     * place_id/api_key ontbreken of de aanroep mislukt, zodat aanroepende code
     * daarop kan terugvallen op de handmatige CPT-reviews.
     *
     * Let op: Google's Places API levert maximaal 5 "meest relevante" reviews per
     * locatie — filteren op sterren gebeurt dus altijd binnen die maximaal 5.
     *
     * @return array{rating: float, user_ratings_total: int, reviews: array}|false
     */
    function mk_get_google_reviews($place_id, $api_key) {
        if (empty($place_id) || empty($api_key)) {
            return false;
        }

        $transient_key = 'mk_google_reviews_' . md5($place_id);
        $cached = get_transient($transient_key);
        if ($cached !== false) {
            return $cached;
        }

        $url = add_query_arg([
            'place_id' => rawurlencode($place_id),
            'fields'   => 'name,rating,user_ratings_total,reviews',
            'language' => 'nl',
            'key'      => rawurlencode($api_key),
        ], 'https://maps.googleapis.com/maps/api/place/details/json');

        $response = wp_remote_get($url, ['timeout' => 8]);

        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return false;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (empty($body['result']) || ($body['status'] ?? '') !== 'OK') {
            return false;
        }

        $result = $body['result'];

        $data = [
            'rating'              => (float) ($result['rating'] ?? 0),
            'user_ratings_total'  => (int) ($result['user_ratings_total'] ?? 0),
            'reviews'             => array_map(function ($review) {
                return [
                    'auteur'      => $review['author_name'] ?? '',
                    'sterren'     => (int) ($review['rating'] ?? 0),
                    'tekst'       => $review['text'] ?? '',
                    'relatief'    => $review['relative_time_description'] ?? '',
                    'foto_url'    => $review['profile_photo_url'] ?? '',
                ];
            }, $result['reviews'] ?? []),
        ];

        set_transient($transient_key, $data, DAY_IN_SECONDS);

        return $data;
    }

    /**
     * Geeft de gedeelde ster-rating markup terug (leeg grijs 5-sterren-rijtje met
     * een geel overlay-laagje dat op basis van het percentage wordt afgesneden) —
     * gebruikt in zowel de header-topbar als het reviews-blok, zodat beide exact
     * dezelfde visuele techniek delen i.p.v. los van elkaar CSS te dupliceren.
     */
    function mk_star_rating_html($rating, $extra_class = '') {
        $rating  = max(0, min(5, (float) $rating));
        $percent = ($rating / 5) * 100;

        $class = 'mk-stars' . ($extra_class ? ' ' . $extra_class : '');

        return '<span class="' . esc_attr($class) . '" aria-hidden="true"><span class="mk-stars__fg" style="width: ' . esc_attr($percent) . '%;"></span></span>';
    }

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
