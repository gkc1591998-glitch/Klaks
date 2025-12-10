<?php
/**
 * Simple Color Conversion Functions
 * Include this file directly in views for immediate color conversion
 */

function convert_db_color_to_css($colorValue) {
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
    
    // Color name mappings from your list
    $colorMappings = array(
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
        // Basic colors
        'gray' => '#808080',
        'grey' => '#808080',
        'blue' => '#0000FF',
        'green' => '#008000',
        'navy' => '#000080',
        'silver' => '#C0C0C0',
    );
    
    // Convert to lowercase for case-insensitive matching
    $colorLower = strtolower($colorValue);
    
    // Check if color exists in our mapping
    if (isset($colorMappings[$colorLower])) {
        return $colorMappings[$colorLower];
    }
    
    // Default fallback
    return '#CCCCCC';
}

function get_color_display_name($colorValue) {
    if (empty($colorValue)) {
        return 'Unknown';
    }
    
    $colorValue = trim($colorValue);
    
    // Color name mappings (reverse lookup)
    $hexToName = array(
        '#2D0101' => 'Maroon',
        '#E65E00' => 'Orange', 
        '#159512' => 'Flag Green',
        '#CC2867' => 'Pink',
        '#22482E' => 'Bottle Green',
        '#1F286A' => 'Royal Blue',
        '#321541' => 'Purple',
        '#A50303' => 'Red',
        '#F9D168' => 'Yellow',
        '#EF9A31' => 'Golden Yellow',
        '#FCFA30' => 'New Yellow',
        '#19E4FF' => 'Sky Blue',
        '#FFD5DB' => 'Light Pink',
        '#6E6E6E' => 'Charcoal Melange',
        '#C3C3C3' => 'Grey Melange',
        '#2D314A' => 'Navy Blue',
        '#FFFFFF' => 'White',
        '#7B2F1D' => 'Brick Red',
        '#1C100F' => 'Coffee Brown',
        '#453E2F' => 'Olive Green',
        '#002A2F' => 'Petrol Blue',
        '#3A3E41' => 'Steel Grey',
        '#CF8F26' => 'Mustard Yellow',
        '#151515' => 'Black',
        '#EBCD8B' => 'Beige',
        '#BBB1D2' => 'Lavender',
        '#A4CEF8' => 'Baby Blue',
        '#9D6333' => 'Khaki',
        '#BFFCF7' => 'Mint',
        '#C86E4E' => 'Coral',
        '#E29891' => 'Flamingo',
        '#CC9D93' => 'Mushroom',
        '#CCF5C9' => 'Jade',
        '#C2745F' => 'Copper',
        '#FFDEC6' => 'Peach',
    );
    
    // First convert to CSS color
    $cssColor = convert_db_color_to_css($colorValue);
    
    // Try to find name by hex
    if (isset($hexToName[$cssColor])) {
        return $hexToName[$cssColor];
    }
    
    // Check if it's a direct name match
    $colorMappings = array(
        'maroon' => 'Maroon',
        'orange' => 'Orange',
        'flag green' => 'Flag Green',
        'pink' => 'Pink',
        'bottle green' => 'Bottle Green',
        'royal blue' => 'Royal Blue',
        'purple' => 'Purple',
        'red' => 'Red',
        'yellow' => 'Yellow',
        'golden yellow' => 'Golden Yellow',
        'new yellow' => 'New Yellow',
        'sky blue' => 'Sky Blue',
        'light pink' => 'Light Pink',
        'charcoal melange' => 'Charcoal Melange',
        'grey melange' => 'Grey Melange',
        'navy blue' => 'Navy Blue',
        'white' => 'White',
        'brick red' => 'Brick Red',
        'coffee brown' => 'Coffee Brown',
        'olive green' => 'Olive Green',
        'petrol blue' => 'Petrol Blue',
        'steel grey' => 'Steel Grey',
        'mustard yellow' => 'Mustard Yellow',
        'black' => 'Black',
        'beige' => 'Beige',
        'lavender' => 'Lavender',
        'baby blue' => 'Baby Blue',
        'khaki' => 'Khaki',
        'mint' => 'Mint',
        'coral' => 'Coral',
        'flamingo' => 'Flamingo',
        'mushroom' => 'Mushroom',
        'jade' => 'Jade',
        'copper' => 'Copper',
        'peach' => 'Peach',
    );
    
    $colorLower = strtolower($colorValue);
    if (isset($colorMappings[$colorLower])) {
        return $colorMappings[$colorLower];
    }
    
    // If it's a hex color, return "Custom Color"
    if (substr($colorValue, 0, 1) === '#' || preg_match('/^[0-9A-Fa-f]{6}$/', $colorValue)) {
        return 'Custom Color';
    }
    
    // Return capitalized original name
    return ucwords(strtolower($colorValue));
}

function get_complete_color_info($colorValue) {
    return array(
        'css_color' => convert_db_color_to_css($colorValue),
        'display_name' => get_color_display_name($colorValue),
        'original_value' => $colorValue
    );
}
?>