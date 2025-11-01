<?php
declare( strict_types=1 );

/**
 * Dynamic block registrations.
 *
 * @package WZ\Core
 */
namespace WZ\Core;

class Blocks {
    /**
     * Register block assets.
     */
    public static function register_assets(): void {
        wp_register_script(
            'widezone-core-blocks',
            WZ_CORE_URL . 'assets/js/blocks.js',
            [ 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-editor' ],
            WZ_CORE_VERSION,
            true
        );

        wp_register_style(
            'widezone-core-blocks',
            WZ_CORE_URL . 'assets/css/blocks.css',
            [],
            WZ_CORE_VERSION
        );
    }

    /**
     * Register dynamic blocks.
     */
    public static function register(): void {
        $blocks = [
            'projects-grid' => [ __CLASS__, 'render_projects_grid' ],
            'industries-grid' => [ __CLASS__, 'render_industries_grid' ],
            'values-list' => [ __CLASS__, 'render_values_list' ],
            'offices-list' => [ __CLASS__, 'render_offices_list' ],
            'careers-list' => [ __CLASS__, 'render_careers_list' ],
            'contact-card' => [ __CLASS__, 'render_contact_card' ],
            'filters-bar' => [ __CLASS__, 'render_filters_bar' ],
        ];

        foreach ( $blocks as $block => $callback ) {
            register_block_type(
                'widezone/' . $block,
                [
                    'editor_script'   => 'widezone-core-blocks',
                    'editor_style'    => 'widezone-core-blocks',
                    'style'           => 'widezone-core-blocks',
                    'render_callback' => $callback,
                ]
            );
        }
    }

    protected static function render_projects_grid( array $attributes = [], string $content = '' ): string {
        $args = [
            'post_type'      => 'project',
            'posts_per_page' => $attributes['perPage'] ?? 6,
            'post_status'    => 'publish',
        ];
        $args = apply_filters( 'wz_core_projects_block_query', $args, $attributes );

        $query = new \WP_Query( $args );
        if ( ! $query->have_posts() ) {
            return '<div class="wp-block-widezone-projects-grid__empty">' . esc_html__( 'Projects coming soon.', 'widezone-core' ) . '</div>';
        }

        ob_start();
        echo '<div class="wp-block-widezone-projects-grid">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $regions  = get_the_term_list( get_the_ID(), 'region', '', ', ' );
            $horizons = get_the_term_list( get_the_ID(), 'horizon', '', ', ' );
            echo '<article class="project-card">';
            if ( has_post_thumbnail() ) {
                echo '<div class="project-card__media">' . get_the_post_thumbnail( get_the_ID(), 'medium_large', [ 'loading' => 'lazy' ] ) . '</div>';
            }
            echo '<div class="project-card__body">';
            echo '<h3 class="project-card__title"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
            echo '<div class="project-card__excerpt">' . wp_kses_post( wp_trim_words( get_the_excerpt(), 25 ) ) . '</div>';
            echo '<div class="project-card__meta">';
            if ( $regions ) {
                echo '<span class="project-card__badge">' . wp_kses_post( $regions ) . '</span>';
            }
            if ( $horizons ) {
                echo '<span class="project-card__badge">' . wp_kses_post( $horizons ) . '</span>';
            }
            echo '</div>';
            echo '<a class="project-card__link" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'View Project', 'widezone-core' ) . '</a>';
            echo '</div>';
            echo '</article>';
        }
        echo '</div>';
        wp_reset_postdata();

        return ob_get_clean();
    }

    protected static function render_industries_grid(): string {
        $query = new \WP_Query(
            [
                'post_type'      => 'industry',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
                'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
            ]
        );

        if ( ! $query->have_posts() ) {
            return '<div class="wp-block-widezone-industries-grid__empty">' . esc_html__( 'Industries will be announced soon.', 'widezone-core' ) . '</div>';
        }

        ob_start();
        echo '<div class="wp-block-widezone-industries-grid">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $icon = get_post_meta( get_the_ID(), 'industry_icon_svg', true );
            echo '<article class="industry-card">';
            if ( $icon ) {
                echo '<div class="industry-card__icon">' . wp_kses_post( $icon ) . '</div>';
            }
            echo '<h3 class="industry-card__title"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
            echo '<div class="industry-card__excerpt">' . wp_kses_post( wp_trim_words( get_the_excerpt(), 20 ) ) . '</div>';
            echo '</article>';
        }
        echo '</div>';
        wp_reset_postdata();

        return ob_get_clean();
    }

    protected static function render_values_list(): string {
        $values = Options::get_values();
        if ( empty( $values ) ) {
            return '';
        }

        ob_start();
        echo '<div class="wp-block-widezone-values-list">';
        foreach ( $values as $value ) {
            echo '<div class="values-list__item">';
            echo '<h3 class="values-list__title">' . esc_html( $value['title'] ?? '' ) . '</h3>';
            if ( ! empty( $value['description'] ) ) {
                echo '<p class="values-list__description">' . esc_html( $value['description'] ) . '</p>';
            }
            echo '</div>';
        }
        echo '</div>';

        return ob_get_clean();
    }

    protected static function render_offices_list(): string {
        $content = Shortcodes::offices();

        return '<div class="wp-block-widezone-offices-list">' . $content . '</div>';
    }

    protected static function render_careers_list(): string {
        $content = Shortcodes::jobs();

        return '<div class="wp-block-widezone-careers-list">' . $content . '</div>';
    }

    protected static function render_contact_card(): string {
        $email = Options::get_brand_option( 'email' );
        $phone = Options::get_brand_option( 'phone' );
        $address = Options::get_brand_option( 'address' );

        ob_start();
        echo '<div class="wp-block-widezone-contact-card">';
        if ( $email ) {
            echo '<p><strong>' . esc_html__( 'Email', 'widezone-core' ) . ':</strong> <a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a></p>';
        }
        if ( $phone ) {
            echo '<p><strong>' . esc_html__( 'Phone', 'widezone-core' ) . ':</strong> <a href="tel:' . esc_attr( preg_replace( '/\D+/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a></p>';
        }
        if ( $address ) {
            echo '<div class="wp-block-widezone-contact-card__address">' . wpautop( wp_kses_post( $address ) ) . '</div>';
        }
        echo '</div>';

        return ob_get_clean();
    }

    protected static function render_filters_bar( array $attributes = [] ): string {
        $content = Shortcodes::filters( [ 'type' => 'projects' ] );

        return '<div class="wp-block-widezone-filters-bar">' . $content . '</div>';
    }
}
