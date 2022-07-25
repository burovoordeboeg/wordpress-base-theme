<?php
/**
 * ACF Radio Color Palette
 * @link https://www.advancedcustomfields.com/resources/acf-load_field/
 * @link https://www.advancedcustomfields.com/resources/dynamically-populate-a-select-fields-choices/
 * @link https://whiteleydesigns.com/create-a-gutenberg-like-color-picker-with-advanced-custom-fields-using-theme-json/
 *
 * Dynamically populates any ACF field with text_editor_color_picker Field Name with custom theme.json palettes
 *
*/
add_filter('acf/load_field/name=text_editor_color_picker', 'bvdb_text_acf_radio_color_palette');
function bvdb_text_acf_radio_color_palette( $field ) {

     // create color palette array
     $color_palette = [];

     // check if theme.json is being used and if so, grab the settings
     if ( class_exists( 'WP_Theme_JSON_Resolver' ) ) {
          $settings = WP_Theme_JSON_Resolver::get_theme_data()->get_settings();

          // full theme color palette
          if ( isset( $settings['color']['palette']['theme'] ) ) {
               $color_palette = $settings['color']['palette']['theme'];
          }

          // custom block color palette
          // if ( isset( $settings['blocks']['core/button']['color']['palette'] ) ) {
          //      $color_palette = $settings['blocks']['acf/acf-separator']['color']['palette'];
          // }
     }

     // if there are colors in the $color_palette array
     if( ! empty( $color_palette ) ) {

          // loop over each color and create option
          foreach( $color_palette as $color ) {
               $field['choices'][ $color['slug'] ] = $color['name'];
          }
     }

     return $field;
}

add_filter('acf/load_field/name=bg_editor_color_picker', 'bvdb_bg_acf_radio_color_palette');
function bvdb_bg_acf_radio_color_palette( $field ) {

     // create color palette array
     $color_palette = [];

     // check if theme.json is being used and if so, grab the settings
     if ( class_exists( 'WP_Theme_JSON_Resolver' ) ) {
          $settings = WP_Theme_JSON_Resolver::get_theme_data()->get_settings();

          // full theme color palette
          if ( isset( $settings['color']['palette']['theme'] ) ) {
               $color_palette = $settings['color']['palette']['theme'];
          }

          // custom block color palette
          // if ( isset( $settings['blocks']['core/button']['color']['palette'] ) ) {
          //      $color_palette = $settings['blocks']['acf/acf-separator']['color']['palette'];
          // }
     }

     // if there are colors in the $color_palette array
     if( ! empty( $color_palette ) ) {

          // loop over each color and create option
          foreach( $color_palette as $color ) {
               $field['choices'][ $color['slug'] ] = $color['name'];
          }
     }

     return $field;
}