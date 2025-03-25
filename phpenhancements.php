<?php
/**
 * PHP Enhancements for manage.php
 * Provides additional functionality for EOI management system
 */

/**
 * Enhances SQL query with ORDER BY clause based on sort parameters
 * 
 * @param string $sql Original SQL query
 * @param string $sort_field Field to sort by
 * @param string $sort_order Sort order (ASC or DESC)
 * @return string Enhanced SQL query with sorting
 */
function enhanceQueryWithSorting($sql, $sort_field, $sort_order) {
    // Define allowed sort fields to prevent SQL injection
    $allowed_fields = [
        'id' => 'EOInumber',
        'job_reference' => 'JobReferenceNumber',
        'first_name' => 'FirstName',
        'last_name' => 'LastName',
        'email' => 'Email',
        'status' => 'Status'
    ];
    
    // Validate sort field
    if (!array_key_exists($sort_field, $allowed_fields)) {
        $sort_field = 'id'; // Default sort field
    }
    
    // Validate sort order
    $sort_order = strtoupper($sort_order) === 'DESC' ? 'DESC' : 'ASC';
    
    // Add ORDER BY clause
    $sql .= " ORDER BY " . $allowed_fields[$sort_field] . " " . $sort_order;
    
    return $sql;
}

/**
 * Generate sort links for table headers
 * 
 * @param string $field Field name
 * @param string $display_name Display name for the field
 * @param string $current_sort_field Currently sorted field
 * @param string $current_sort_order Current sort order
 * @param string $action Current action being performed
 * @param array $params Additional form parameters to preserve
 * @return string HTML for sortable table header
 */
function getSortableHeaderLink($field, $display_name, $current_sort_field, $current_sort_order, $action, $params = []) {
    // Determine the new sort order
    $new_sort_order = ($field == $current_sort_field && $current_sort_order == 'ASC') ? 'DESC' : 'ASC';
    
    // Start building form with the anchor for scrolling to results
    $link = '<form method="post" action="#results" style="display:inline; margin:0; padding:0;">';
    $link .= '<input type="hidden" name="action" value="' . htmlspecialchars($action) . '">';
    $link .= '<input type="hidden" name="sort_field" value="' . htmlspecialchars($field) . '">';
    $link .= '<input type="hidden" name="sort_order" value="' . htmlspecialchars($new_sort_order) . '">';
    
    // Add any additional parameters
    foreach ($params as $key => $value) {
        if (!empty($value)) {
            $link .= '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
        }
    }
    
    // Add submit button styled as a custom sort button
    $link .= '<button type="submit" class="sort-button">';
    $link .= $display_name;
    
    // Determine arrow direction for current sort field
    if ($field == $current_sort_field) {
        $link .= ($current_sort_order == 'ASC') ? ' ▲' : ' ▼';
    }
    
    $link .= '</button></form>';
    
    return $link;
}

/**
 * Generate hidden form inputs for sorting
 * 
 * @param string $sort_field Field to sort by
 * @param string $sort_order Sort order
 * @return string HTML for hidden form inputs
 */
function getSortFormInputs($sort_field, $sort_order) {
    $html = '<input type="hidden" name="sort_field" value="' . htmlspecialchars($sort_field) . '">';
    $html .= '<input type="hidden" name="sort_order" value="' . htmlspecialchars($sort_order) . '">';
    return $html;
}
?>
