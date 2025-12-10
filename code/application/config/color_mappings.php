<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Color Mappings Configuration
 * 
 * This file contains standardized color mappings for the application.
 * It maps color names to their corresponding hex values for consistent display.
 * 
 * Usage: 
 * $this->config->load('color_mappings');
 * $color_map = $this->config->item('color_mappings');
 */

$config['color_mappings'] = array(
    // Standard colors (lowercase for case-insensitive matching)
    'maroon' => '#2D0101',
    'orange' => '#E65E00',
    'flag green' => '#159512',
    'pink' => '#CC2867',
    'bottle green' => '#22482E',
    'royal blue' => '#1F286A',
    'purple' => '#321541',
    'red' => '#A50303',
    'yellow' => '#F9D168',
    'golden yellow' => '#EF9A31',
    'new yellow' => '#FCFA30',
    'sky blue' => '#19E4FF',
    'light pink' => '#FFD5DB',
    'charcoal melange' => '#6E6E6E',
    'grey melange' => '#C3C3C3',
    'navy blue' => '#2D314A',
    'white' => '#FFFFFF',
    'brick red' => '#7B2F1D',
    'coffee brown' => '#1C100F',
    'olive green' => '#453E2F',
    'petrol blue' => '#002A2F',
    'steel grey' => '#3A3E41',
    'mustard yellow' => '#CF8F26',
    'black' => '#151515',
    'beige' => '#EBCD8B',
    'lavender' => '#BBB1D2',
    'baby blue' => '#A4CEF8',
    'khaki' => '#9D6333',
    'mint' => '#BFFCF7',
    'coral' => '#C86E4E',
    'flamingo' => '#E29891',
    'mushroom' => '#CC9D93',
    'jade' => '#CCF5C9',
    'copper' => '#C2745F',
    'peach' => '#FFDEC6',
    
    // Basic color fallbacks
    'gray' => '#808080',
    'grey' => '#808080',
    'blue' => '#0000FF',
    'green' => '#008000',
    'navy' => '#000080',
    'silver' => '#C0C0C0',
);

/**
 * Helper function to convert color value to valid CSS hex color
 * 
 * @param string $colorValue The color value from database
 * @return string Valid CSS hex color
 */
function convert_to_css_color($colorValue) {
    global $config;
    
    if (empty($colorValue)) {
        return '#CCCCCC'; // Default gray
    }
    
    $colorValue = trim($colorValue);
    
    // Check if it's already a hex color with #
    if (substr($colorValue, 0, 1) === '#') {
        return $colorValue;
    }
    
    // Check if it's a hex color without # (6 characters, alphanumeric)
    if (preg_match('/^[0-9A-Fa-f]{6}$/', $colorValue)) {
        return '#' . strtoupper($colorValue);
    }
    
    // Load color mappings if not already loaded
    if (!isset($config['color_mappings'])) {
        include_once(APPPATH . 'config/color_mappings.php');
    }
    
    // Convert to lowercase for case-insensitive matching
    $colorLower = strtolower($colorValue);
    
    // Check if color exists in our mapping
    if (isset($config['color_mappings'][$colorLower])) {
        return $config['color_mappings'][$colorLower];
    }
    
    // Default fallback
    return '#CCCCCC';
}