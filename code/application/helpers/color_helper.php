<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Color Helper Functions
 * 
 * This helper provides utility functions for color conversion and management.
 */

if (!function_exists('get_css_color')) {
    /**
     * Convert any color value to a valid CSS hex color
     * 
     * @param string $colorValue The color value from database
     * @return string Valid CSS hex color
     */
    function get_css_color($colorValue) {
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
        
        // Use centralized color mappings
        $colorMappings = get_color_mappings();
        
        // Convert to lowercase for case-insensitive matching
        $colorLower = strtolower($colorValue);
        
        // Check if color exists in our mapping
        if (isset($colorMappings[$colorLower])) {
            return $colorMappings[$colorLower];
        }
        
        // Default fallback
        return '#CCCCCC';
    }
}

if (!function_exists('get_color_mappings')) {
    /**
     * Get the complete color mappings array
     * 
     * @return array Color mappings
     */
    function get_color_mappings() {
        return array(
            // From provided list
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
    }
}

if (!function_exists('find_color_name_by_hex')) {
    /**
     * Find color name by hex code (reverse lookup)
     * 
     * @param string $hexColor Hex color code (with or without #)
     * @return string|null Color name if found, null otherwise
     */
    function find_color_name_by_hex($hexColor) {
        $hexColor = ltrim($hexColor, '#');
        $hexColor = '#' . strtoupper($hexColor);
        
        $colorMappings = get_color_mappings();
        
        foreach ($colorMappings as $name => $hex) {
            if (strtoupper($hex) === $hexColor) {
                return $name;
            }
        }
        
        return null;
    }
}

if (!function_exists('get_best_color_match')) {
    /**
     * Get the best color match from database value
     * Returns both the CSS color and the best display name
     * 
     * @param string $dbColorValue The color value from database
     * @return array ['css_color' => string, 'display_name' => string]
     */
    function get_best_color_match($dbColorValue) {
        if (empty($dbColorValue)) {
            return ['css_color' => '#CCCCCC', 'display_name' => 'Unknown'];
        }
        
        $colorValue = trim($dbColorValue);
        $colorMappings = get_color_mappings();
        
        // First, try direct name match (case-insensitive)
        $colorLower = strtolower($colorValue);
        if (isset($colorMappings[$colorLower])) {
            return [
                'css_color' => $colorMappings[$colorLower],
                'display_name' => ucwords($colorLower)
            ];
        }
        
        // Convert to CSS color format
        $cssColor = get_css_color($colorValue);
        
        // Try to find a matching color name by hex code
        $matchedName = find_color_name_by_hex($cssColor);
        if ($matchedName) {
            return [
                'css_color' => $cssColor,
                'display_name' => ucwords($matchedName)
            ];
        }
        
        // If it's a valid hex color but no name match, use original name if available
        if (substr($colorValue, 0, 1) === '#' || preg_match('/^[0-9A-Fa-f]{6}$/', $colorValue)) {
            return [
                'css_color' => $cssColor,
                'display_name' => 'Custom Color'
            ];
        }
        
        // Use the original name if it's not a hex code
        return [
            'css_color' => $cssColor,
            'display_name' => ucwords(strtolower($colorValue))
        ];
    }
}

if (!function_exists('get_color_name_display')) {
    /**
     * Get display-friendly color name
     * 
     * @param string $colorValue The color value
     * @return string Display-friendly color name
     */
    function get_color_name_display($colorValue) {
        $match = get_best_color_match($colorValue);
        return $match['display_name'];
    }
}

if (!function_exists('is_light_color')) {
    /**
     * Determine if a color is light (for text contrast)
     * 
     * @param string $hexColor Hex color code (with or without #)
     * @return boolean True if color is light
     */
    function is_light_color($hexColor) {
        $hexColor = ltrim($hexColor, '#');
        
        if (strlen($hexColor) !== 6) {
            return false;
        }
        
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        
        // Calculate relative luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        
        return $luminance > 0.5;
    }
}