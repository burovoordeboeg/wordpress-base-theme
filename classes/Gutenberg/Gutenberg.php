<?php

	namespace BvdB;

	class Gutenberg
	{
        
		private static $instance = null;
		
		// Setup default paths
        private $blocksDir;
        public $themeVersion;

        function __construct() {

            // Set the directory for the blocks
            $this->blocksDir = get_template_directory_uri() . '/views/blocks';

            // Get theme settings
            $activeTheme = wp_get_theme();
            $this->themeVersion = $activeTheme->get('Version');

			// Set the colors for ACF
			add_action( 'acf/input/admin_footer', array($this, 'registerACFColorPallette') );

        }
        
        /**
         * Register ACF Block Type
         * Docs: https://www.advancedcustomfields.com/resources/acf_register_block_type/
         * 
         * @param array $settings
         * @param array $assets
         * 
         * @return void
         */
        public function registerBlock( array $settings, array $assets ) {
            
            // Check if ACF is active
            if( function_exists('acf_register_block_type') ) {
                
                // Register the block
                add_action('acf/init', function() use ($settings, $assets) {

                    // Register the ACF block
                    acf_register_block_type(
                        array(
                            'name' => $settings['name'],
                            'title' => sprintf( __( '%s', 'bvdb' ), $settings['title'] ),
                            'description' => sprintf( __( '%s', 'bvdb' ), $settings['description'] ),
                            'category' => $settings['category'],
                            'icon' => $settings['icon'],
                            'keywords' => $settings['keywords'] ?: array(),
                            'post_types' => $settings['post_types'] ?: array(),
                            'mode' => $settings['mode'] ?: 'auto',
                            'align' => $settings['title'] ?: array( 'wide', 'full' ),
                            
                            // Use render_callback is instead of a render template
                            // to make sure it uses the render method in this class
                            'render_callback' => array($this, 'renderBlock'),

                            // Enqueue the assets (scripts and styles)
                            'enqueue_assets' => (function() use ($settings, $assets) {
                                
                                // Call the correct styles in front or back end whatever is set to load
                                foreach( (( is_admin() && !empty($assets['admin']) ) ? $assets['admin'] : $assets['frontend']) as $type => $src ) {
                                    
                                    call_user_func_array(

                                        // Call enqueue_style or _script when type is appropriate
                                        (( $type == 'style' || $type == 'css' ) ? 'wp_enqueue_style' : 'wp_enqueue_script'),

                                        // Send along the correct variables
                                        array(
                                            $settings['name'] . '-' . explode('.', $src, 1)[0], 
                                            $this->blocksDir . '/' . $settings['name'] . '/dist/' . (( $type == 'script' || $type == 'js' ) ? 'js/' : 'css/') . $src, 
                                            (( $type == 'script' || $type == 'js' ) ? array('jquery') : array() ), 
                                            $this->themeVersion,
                                            (( $type == 'script' || $type == 'js' ) ? true : 'all' ), 
                                        )
                                    );
                                }
                                
                            }),
                            'supports' => array(
                                // Customize alignment toolbar, use false for disable alignment
								'align' => $settings['align'] ?: array( 'wide', 'full' ),
								
                                // Disable preview/edit toggle
								'mode' => $settings['mode'] ?: 'auto',
								
                                // This property allows the block to be added multiple times.
                                'multiple' => $settings['multiple'] ?: true,
                            ),
                            
                        )
                    );

                });
            }
        }

        /**
         * Render Gutenberg Block function
         *
         * @param array $block
         * @param string $content
         * @param boolean $preview
         * @param integer $post_id
         * 
         * @return string HTML output
         */
        public function renderBlock( array $block, string $content, bool $preview, int $post_id ) {

            // First parse the block name
            $slug = str_replace('acf/', '', $block['name']);

            // Set the styling options
            $id = $slug . '-' . $block['id'];
            if( !empty($block['anchor']) ) {
                $id = $block['anchor'];
            }

            // Create class attribute allowing for custom classname
            $classes = '';
            if( !empty($block['className']) ) {
                $classes .= ' ' . $block['className'];
            }
            
            // Add the block alignment values
            if( !empty($block['align']) ) {
                $classes .= ' align' . $block['align'];
            }

            // Setup default data object and add the id and class
            $data = array(
                'id' => esc_attr($id),
                'classes' => esc_attr($classes)
            );

            // Now index the the block ACF datafields
            foreach($block['data'] as $key => $value) {
                if( substr( $key, 0, 1 ) != '_' ) {
                    
                    if( strpos($key, 'field_') === false ) {
                        // If it is a general field key (not prefixed with field_)
                        // we can just use the key which is available in the loop. 
                        $data[$key] = get_field($key);
                    } else {
                        // On update, ACF gives the field key instead of name
                        // for some reason, so we need to get the field object
                        // and select the name so we can use that for the 
                        // twig object, otherwise it results in conflict.
                        $fieldname = get_field_object($key);
                        $data[$fieldname['name']] = get_field($key);
                    }
                }
            }

            // Instantiate the Twig theme class
            $twig = new Twig\Twig();

            // Render the template
            $twig->render('blocks/' . $slug . '/' . $slug, $data);

		}
		
		/**
		 * Undocumented function
		 *
		 * @param array $colors
		 * @return void
		 */
		public function registerColors( array $colors ) {
			$theme = Theme::getInstance();
			$theme->support->add( 'editor-color-palette', $colors );
		}

		/**
		 * Helper function to set the color palette to the 
		 * ACF color picker
		 *
		 * @return string JavaScript code
		 */
		public function registerACFColorPallette() {

			$colors = current( (array) get_theme_support( 'editor-color-palette' ) );
			if( $colors && is_array($colors) && isset($colors[0]['color']) ) {

				// Format in as string for JavaScript array
				echo '<script type="text/javascript">' .
						'(function( $ ) {' .
							'acf.add_filter( \'color_picker_args\', function( args, $field ){' .
							// add the hexadecimal codes here for the colors you want to appear as swatches
							'args.palettes = ["' . implode('","', array_column($colors, 'color')) . '"];' .
							// return colors
							'return args;' .
							'});' .
						'})(jQuery);' .
					'</script>';
			}

			return;
		}



        /**
         * Get Instance of the current class, of none exist, create the class
         *
         * @return object instance
         */
        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new Gutenberg();
            }
            return self::$instance;
        }

	}

?>