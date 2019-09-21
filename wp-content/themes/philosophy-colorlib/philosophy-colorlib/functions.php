<?php

function wp_my_menu( $args = array() ) {
    static $menu_id_slugs = array();

    $defaults = array( 'menu' => '', 'container' => 'div', 'container_class' => '', 'container_id' => '', 'menu_class' => 'menu', 'menu_id' => '',
        'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'item_spacing' => 'preserve',
        'depth' => 0, 'walker' => '', 'theme_location' => '' );

    $args = wp_parse_args( $args, $defaults );

    if ( ! in_array( $args['item_spacing'], array( 'preserve', 'discard' ), true ) ) {
        // invalid value, fall back to default.
        $args['item_spacing'] = $defaults['item_spacing'];
    }

    /**
     * Filters the arguments used to display a navigation menu.
     *
     * @since 3.0.0
     *
     * @see wp_nav_menu()
     *
     * @param array $args Array of wp_nav_menu() arguments.
     */
    $args = apply_filters( 'wp_nav_menu_args', $args );
    $args = (object) $args;

    /**
     * Filters whether to short-circuit the wp_nav_menu() output.
     *
     * Returning a non-null value to the filter will short-circuit
     * wp_nav_menu(), echoing that value if $args->echo is true,
     * returning that value otherwise.
     *
     * @since 3.9.0
     *
     * @see wp_nav_menu()
     *
     * @param string|null $output Nav menu output to short-circuit with. Default null.
     * @param stdClass    $args   An object containing wp_nav_menu() arguments.
     */
    $nav_menu = apply_filters( 'pre_wp_nav_menu', null, $args );

    if ( null !== $nav_menu ) {
        if ( $args->echo ) {
            echo $nav_menu;
            return;
        }

        return $nav_menu;
    }

    // Get the nav menu based on the requested menu
    $menu = wp_get_nav_menu_object( $args->menu );

    // Get the nav menu based on the theme_location
    if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) )
        $menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );

    // get the first menu that has items if we still can't find a menu
    if ( ! $menu && !$args->theme_location ) {
        $menus = wp_get_nav_menus();
        foreach ( $menus as $menu_maybe ) {
            if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
                $menu = $menu_maybe;
                break;
            }
        }
    }

    if ( empty( $args->menu ) ) {
        $args->menu = $menu;
    }

    // If the menu exists, get its items.
    if ( $menu && ! is_wp_error($menu) && !isset($menu_items) )
        $menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

    /*
     * If no menu was found:
     *  - Fall back (if one was specified), or bail.
     *
     * If no menu items were found:
     *  - Fall back, but only if no theme location was specified.
     *  - Otherwise, bail.
     */
    if ( ( !$menu || is_wp_error($menu) || ( isset($menu_items) && empty($menu_items) && !$args->theme_location ) )
        && isset( $args->fallback_cb ) && $args->fallback_cb && is_callable( $args->fallback_cb ) )
        return call_user_func( $args->fallback_cb, (array) $args );

    if ( ! $menu || is_wp_error( $menu ) )
        return false;

    $nav_menu = $items = '';

    $show_container = false;
    if ( $args->container ) {
        /**
         * Filters the list of HTML tags that are valid for use as menu containers.
         *
         * @since 3.0.0
         *
         * @param array $tags The acceptable HTML tags for use as menu containers.
         *                    Default is array containing 'div' and 'nav'.
         */
        $allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
        if ( is_string( $args->container ) && in_array( $args->container, $allowed_tags ) ) {
            $show_container = true;
            $class = $args->container_class ? ' class="' . esc_attr( $args->container_class ) . '"' : ' class="menu-'. $menu->slug .'-container"';
            $id = $args->container_id ? ' id="' . esc_attr( $args->container_id ) . '"' : '';
            $nav_menu .= '<'. $args->container . $id . $class . '>';
        }
    }

    // Set up the $menu_item variables
    _wp_menu_item_classes_by_context( $menu_items );

    $sorted_menu_items = $menu_items_with_children = array();
    foreach ( (array) $menu_items as $menu_item ) {
        $sorted_menu_items[ $menu_item->menu_order ] = $menu_item;
        if ( $menu_item->menu_item_parent )
            $menu_items_with_children[ $menu_item->menu_item_parent ] = true;
    }

    // Add the menu-item-has-children class where applicable
    if ( $menu_items_with_children ) {
        foreach ( $sorted_menu_items as &$menu_item ) {
            if ( isset( $menu_items_with_children[ $menu_item->ID ] ) )
                $menu_item->classes[] = 'has-children'; //тут
        }
    }

    unset( $menu_items, $menu_item );

    /**
     * Filters the sorted list of menu item objects before generating the menu's HTML.
     *
     * @since 3.1.0
     *
     * @param array    $sorted_menu_items The menu items, sorted by each menu item's menu order.
     * @param stdClass $args              An object containing wp_nav_menu() arguments.
     */
    $sorted_menu_items = apply_filters( 'wp_nav_menu_objects', $sorted_menu_items, $args );

    $items .= walk_nav_menu_tree( $sorted_menu_items, $args->depth, $args );
    unset($sorted_menu_items);

    // Attributes
    if ( ! empty( $args->menu_id ) ) {
        $wrap_id = $args->menu_id;
    } else {
        $wrap_id = 'menu-' . $menu->slug;
        while ( in_array( $wrap_id, $menu_id_slugs ) ) {
            if ( preg_match( '#-(\d+)$#', $wrap_id, $matches ) )
                $wrap_id = preg_replace('#-(\d+)$#', '-' . ++$matches[1], $wrap_id );
            else
                $wrap_id = $wrap_id . '-1';
        }
    }
    $menu_id_slugs[] = $wrap_id;

    $wrap_class = $args->menu_class ? $args->menu_class : '';

    /**
     * Filters the HTML list content for navigation menus.
     *
     * @since 3.0.0
     *
     * @see wp_nav_menu()
     *
     * @param string   $items The HTML list content for the menu items.
     * @param stdClass $args  An object containing wp_nav_menu() arguments.
     */
    $items = apply_filters( 'wp_nav_menu_items', $items, $args );
    /**
     * Filters the HTML list content for a specific navigation menu.
     *
     * @since 3.0.0
     *
     * @see wp_nav_menu()
     *
     * @param string   $items The HTML list content for the menu items.
     * @param stdClass $args  An object containing wp_nav_menu() arguments.
     */
    $items = apply_filters( "wp_nav_menu_{$menu->slug}_items", $items, $args );

    // Don't print any markup if there are no items at this point.
    if ( empty( $items ) )
        return false;

    $nav_menu .= sprintf( $args->items_wrap, esc_attr( $wrap_id ), esc_attr( $wrap_class ), $items );
    unset( $items );

    if ( $show_container )
        $nav_menu .= '</' . $args->container . '>';

    /**
     * Filters the HTML content for navigation menus.
     *
     * @since 3.0.0
     *
     * @see wp_nav_menu()
     *
     * @param string   $nav_menu The HTML content for the navigation menu.
     * @param stdClass $args     An object containing wp_nav_menu() arguments.
     */
    $nav_menu = apply_filters( 'wp_nav_menu', $nav_menu, $args );

    if ( $args->echo )
        echo $nav_menu;
    else
        return $nav_menu;
}



add_theme_support('post-formats', array(
    'image',
    'video',
    'audio',
    'standard'
));

function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}

function enqueue_comment_reply() {
    if( is_singular() )
        wp_enqueue_script('comment-reply');
}
add_action( 'wp_enqueue_scripts', 'enqueue_comment_reply' );


//HeaderMenu
function register_my_menus() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu' )
        )
    );
}
add_action( 'init', 'register_my_menus' );

//HeaderMenu

if( function_exists('acf_add_options_page') ) {

    $parent = acf_add_options_page(array(
        'page_title' 	=> 'Theme settings',
        'menu_title' 	=> 'Theme settings',
        'position'=>5,
        'redirect' 		=> false
    ));
    // add sub page
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Social',
        'menu_title' 	=> 'Social Links',
        'menu_slug' => 'child_opt',
        'parent_slug' 	=> $parent['menu_slug'],
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Contact',
        'menu_title' 	=> 'Page contact',
        'menu_slug' => 'child_opt2',
        'parent_slug' 	=> $parent['menu_slug'],
    ));
}

add_filter( 'excerpt_length', function(){
    return 20;
} );

add_filter( 'excerpt_more', 'new_excerpt_more' );
function new_excerpt_more( $more ){
    global $post;
    return '<a href="'. get_permalink($post) . '"> Читать дальше...</a>';
}

add_filter( 'wp_mail_from_name', function($from_name){
    return 'richegor@gmail.com'; // тут можно указать свою почту: asd@asd.ru
} );

function my_paginate( $args = '' ) {
    global $wp_query, $wp_rewrite;

    // Setting up default values based on the current URL.
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $url_parts    = explode( '?', $pagenum_link );

    // Get max pages and current page out of the current query, if available.
    $total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

    // Append the format placeholder to the base URL.
    $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

    // URL base depends on permalink settings.
    $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

    $defaults = array(
        'base'               => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
        'format'             => $format, // ?page=%#% : %#% is replaced by the page number
        'total'              => $total,
        'current'            => $current,
        'aria_current'       => 'page',
        'show_all'           => false,
        'prev_next'          => true,
        'prev_text'          => __( '&laquo; Previous' ),
        'next_text'          => __( 'Next &raquo;' ),
        'end_size'           => 1,
        'mid_size'           => 2,
        'type'               => 'list',
        'add_args'           => array(), // array of query args to add
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => '',
    );

    $args = wp_parse_args( $args, $defaults );

    if ( ! is_array( $args['add_args'] ) ) {
        $args['add_args'] = array();
    }

    // Merge additional query vars found in the original URL into 'add_args' array.
    if ( isset( $url_parts[1] ) ) {
        // Find the format argument.
        $format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
        $format_query = isset( $format[1] ) ? $format[1] : '';
        wp_parse_str( $format_query, $format_args );

        // Find the query args of the requested URL.
        wp_parse_str( $url_parts[1], $url_query_args );

        // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
        foreach ( $format_args as $format_arg => $format_arg_value ) {
            unset( $url_query_args[ $format_arg ] );
        }

        $args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
    }

    // Who knows what else people pass in $args
    $total = (int) $args['total'];
    if ( $total < 2 ) {
        return;
    }
    $current  = (int) $args['current'];
    $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
    if ( $end_size < 1 ) {
        $end_size = 1;
    }
    $mid_size = (int) $args['mid_size'];
    if ( $mid_size < 0 ) {
        $mid_size = 2;
    }
    $add_args = $args['add_args'];
    $r = '';
    $page_links = array();
    $dots = false;

    if ( $args['prev_next'] && $current && 1 < $current ) :
        $link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
        $link = str_replace( '%#%', $current - 1, $link );
        if ( $add_args )
            $link = add_query_arg( $add_args, $link );
        $link .= $args['add_fragment'];

        /**
         * Filters the paginated links for the given archive pages.
         *
         * @since 3.0.0
         *
         * @param string $link The paginated link URL.
         */
        $page_links[] = '<a class="pgn__prev" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['prev_text'] . '</a>';
    endif;
    for ( $n = 1; $n <= $total; $n++ ) :
        if ( $n == $current ) :
            $page_links[] = "<span aria-current='" . esc_attr( $args['aria_current'] ) . "' class='pgn__num current'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</span>";
            $dots = true;
        else :
            if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
                $link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
                $link = str_replace( '%#%', $n, $link );
                if ( $add_args )
                    $link = add_query_arg( $add_args, $link );
                $link .= $args['add_fragment'];

                /** This filter is documented in wp-includes/general-template.php */
                $page_links[] = "<a class='pgn__num' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a>";
                $dots = true;
            elseif ( $dots && ! $args['show_all'] ) :
                $page_links[] = '<span class="pgn__num">' . __( '&hellip;' ) . '</span>';
                $dots = false;
            endif;
        endif;
    endfor;
    if ( $args['prev_next'] && $current && $current < $total ) :
        $link = str_replace( '%_%', $args['format'], $args['base'] );
        $link = str_replace( '%#%', $current + 1, $link );
        if ( $add_args )
            $link = add_query_arg( $add_args, $link );
        $link .= $args['add_fragment'];

        /** This filter is documented in wp-includes/general-template.php */
        $page_links[] = '<a class="pgn__next" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['next_text'] . '</a>';
    endif;
    switch ( $args['type'] ) {
        case 'array' :
            return $page_links;

        case 'list' :
            $r .= "<ul>\n\t<li>";
            $r .= join("</li>\n\t<li>", $page_links);
            $r .= "</li>\n</ul>\n";
            break;

        default :
            $r = join("\n", $page_links);
            break;
    }
    return $r;
}