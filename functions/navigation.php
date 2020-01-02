<?php   

    // Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;
    
    /**
     * Get the menu by location
     *
     * @param string $location
     * @param string $prefix
     * @return string 
     */
    function getMenu( $location, $prefix ) {
        // Create theme instance and call the theme class to initialize globally.
        include_once get_template_directory() . '/vendor/autoload.php';
        $theme = BvdB\Theme::getInstance();
        $theme->objects->navigation->get($location, $prefix, 2);
    }

    /**
     * Get the breadcrumbs from Yoast
     *
     * @return string Breadcrumb as HTML
     */
    function getBreadcrumb() {
        if( function_exists('yoast_breadcrumb') ) {
            if ( function_exists('yoast_breadcrumb') ) { 
                return yoast_breadcrumb();
            }
        }
    }

    /**
     * Get the sidebar and return it (instead of echo'ing)
     *
     * @param string $id
     * @return string HTML of dynamic sidebar
     */
    function getSidebar( string $id ) {
        ob_start();
        dynamic_sidebar( $id );
        $sidebar = ob_get_clean();
        return $sidebar;
    }

    /**
     * Get the page permalink by slug
     *
     * @param int $postid
     * @return string permalink of post
     */
    function getPageLinkByID( int $postid ) {
        return get_the_permalink($postid);
    }
    
    /**
     * Get the pagination links
     *
     * @return array with pagination 
     */
    function getPagination() {
		global $wp_query;
		$big = 999999999;
		return paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages,
			'prev_text' => __('', 'visualmasters'),
			'next_text' => __('', 'visualmasters')
		) );
    }

