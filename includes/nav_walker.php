<?php 
// Header Top menu
class Custom_header_top_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {}

    public function end_lvl( &$output, $depth = 0, $args = null ) {}

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = 'text-decoration-none small fw-bold text-dark';
        if ( $item->menu_order < count( wp_get_nav_menu_items( $args->menu ) ) ) {
            $classes .= ' me-3';
        }
        $output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $classes ) . '" target="' . esc_attr($item->target) . '">';
        $output .= esc_html( $item->title );
        $output .= '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}

// Header menu
class Custom_Header_Nav_Walker extends Walker_Nav_Menu {
    private $children_count = array();

    private $is_mega_menu = false;

    public function display_element(
        $element,
        &$children_elements,
        $max_depth,
        $depth,
        $args,
        &$output
    ) {

        if ( ! empty( $children_elements[ $element->ID ] ) ) {

            $this->children_count[ $element->ID ] =
                count( $children_elements[ $element->ID ] );
        }

        parent::display_element(
            $element,
            $children_elements,
            $max_depth,
            $depth,
            $args,
            $output
        );
    }

    public function start_el(
        &$output,
        $item,
        $depth = 0,
        $args = null,
        $id = 0
    ) {

        if ( $depth === 0 ) {

            $children_count = isset(
                $this->children_count[ $item->ID ]
            )
                ? $this->children_count[ $item->ID ]
                : 0;

            if ( $children_count > 0 ) {

                if ( $children_count > 7 ) {

                    $this->is_mega_menu = true;

                    $output .= '<li class="nav-item dropdown dropdown-mega position-static">';

                    $output .= '<a class="nav-link dropdown-toggle"
                        href="' . esc_url( $item->url ) . '" target="' . esc_attr($item->target) . '"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">';

                    $output .= esc_html( $item->title );

                    $output .= '</a>';

                    $output .= '<div class="dropdown-menu w-100 shadow-sm border-0 p-4">';
                    $output .= '<div class="container">';

                    $output .= '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-5">';

                    $output .= '<div class="col">';
                    $output .= '<ul class="list-unstyled">';

                }

                else {

                    $this->is_mega_menu = false;

                    $output .= '<li class="nav-item dropdown">';

                    $output .= '<a class="nav-link dropdown-toggle"
                        href="' . esc_url( $item->url ) . '" target="' . esc_attr($item->target) . '"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">';

                    $output .= esc_html( $item->title );

                    $output .= '</a>';

                    $output .= '<ul class="dropdown-menu">';
                }

            }

            else {

                $this->is_mega_menu = false;

                $output .= '<li class="nav-item">';

                $output .= '<a class="nav-link"
                    href="' . esc_url( $item->url ) . '" target="' . esc_attr($item->target) . '">';

                $output .= esc_html( $item->title );

                $output .= '</a>';
            }
        }

        else {

            if ( $this->is_mega_menu ) {

                static $child_count = 0;

                $child_count++;

                if (
                    $child_count > 1 &&
                    ( $child_count - 1 ) % 7 === 0
                ) {

                    $output .= '</ul>';
                    $output .= '</div>';

                    $output .= '<div class="col">';
                    $output .= '<ul class="list-unstyled">';
                }


                $output .= '<li>';

                $output .= '<a href="' . esc_url( $item->url ) . '" target="' . esc_attr($item->target) . '"
                    class="dropdown-item">';

                $output .= esc_html( $item->title );

                $output .= '</a>';

                $output .= '</li>';
            }

            else {

                $output .= '<li>';

                $output .= '<a href="' . esc_url( $item->url ) . '" target="' . esc_attr($item->target) . '"
                    class="dropdown-item">';

                $output .= esc_html( $item->title );

                $output .= '</a>';

                $output .= '</li>';
            }
        }
    }

    public function end_el(
        &$output,
        $item,
        $depth = 0,
        $args = null
    ) {

        if ( $depth === 0 ) {

            $children_count = isset(
                $this->children_count[ $item->ID ]
            )
                ? $this->children_count[ $item->ID ]
                : 0;

            if ( $children_count > 7 ) {

                $output .= '</ul>';
                $output .= '</div>';

                $output .= '</div>'; // row
                $output .= '</div>'; // container
                $output .= '</div>'; // dropdown-menu
            }

            elseif ( $children_count > 0 ) {

                $output .= '</ul>';
            }

            $output .= '</li>';
        }
    }

    public function start_lvl(
        &$output,
        $depth = 0,
        $args = null
    ) {
        // Prevent default <ul class="sub-menu">
    }

    public function end_lvl(
        &$output,
        $depth = 0,
        $args = null
    ) {
        // Prevent default closing </ul>
    }
}

// Footer Bottom menu
class Custom_Footer_Bottom_Nav_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = implode( ' ', array_filter( $classes ) );

        $output .= '<li class="' . esc_attr( $class_names ) . ' list-inline-item">';

        $attributes = '';

        if ( ! empty( $item->url ) ) {
            $attributes .= ' href="' . esc_url( $item->url ) . '"';
        }

        $output .= '<a' . $attributes . ' class="small text-decoration-none" target="' . esc_attr($item->target) . '">';
        $output .= esc_html( $item->title );
        $output .= '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}

// Footer Menu
function custom_footer_menu( $location ) {

    $locations = get_nav_menu_locations();

    if ( empty( $locations[ $location ] ) ) {
        return;
    }

    $menu_id = $locations[ $location ];

    $menu_items = wp_get_nav_menu_items( $menu_id );

    if ( empty( $menu_items ) ) {
        return;
    }

    $menu_object = wp_get_nav_menu_object( $menu_id );

    $total_items = count( $menu_items );

    // Split items into two balanced columns
    $first_column_count = ceil( $total_items / 2 );

    $chunks = array_chunk(
        $menu_items,
        $first_column_count
    );

    foreach ( $chunks as $index => $items ) :
        ?>

        <div class="col-lg-3 col-md-6">

            <?php if ( $index === 0 ) : ?>

                <h5 class="mb-3">
                    <?php echo esc_html( $menu_object->name ); ?>
                </h5>

            <?php else : ?>

                <h5 class="mb-3 d-none d-lg-block">&nbsp;</h5>

            <?php endif; ?>

            <ul class="list-unstyled">

                <?php foreach ( $items as $item ) : ?>

                    <li>
                        <a href="<?php echo esc_url( $item->url ); ?>" target="<?php echo esc_attr($item->target); ?>">
                            <?php echo esc_html( $item->title ); ?>
                        </a>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

        <?php
    endforeach;
}












?>