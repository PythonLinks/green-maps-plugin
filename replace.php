<?php
function replace_anchor_tags($html) {
    $pattern = '/<a\b([^>]*?)href="([^"]*)"([^>]*)>/i';
    
    return preg_replace_callback($pattern, function($matches) {
        $before = $matches[1];  // Attributes before href
        $slug = $matches[2];    // Captured slug value
        $after = $matches[3];   // Attributes after href
        
        $newSlug = transform_href($slug);  // Your transformation logic
        return "<a{$before}href=\"{$newSlug}\"{$after}>";
    }, $html);
}

// Example transformation function
function transform_href($slug) {
    return "/green-maps?page-name=" . $slug;  // Customize this/
}

?>