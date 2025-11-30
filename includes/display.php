<?php
// شورت کد نمایش کلیه جریان ها و مراحل 
// [un_flows_list]
add_shortcode('un_flows_list', 'un_display_flows_by_category');
function un_display_flows_by_category() {
    $output = '';

    $categories = get_terms([
        'taxonomy' => 'un_flow_category',
        'hide_empty' => false,
    ]);

    foreach ($categories as $category) {
        $output .= "<h2>📂 {$category->name}</h2>";

        $flows = get_posts([
            'post_type' => 'un_flow',
            'numberposts' => -1,
            'tax_query' => [[
                'taxonomy' => 'un_flow_category',
                'field' => 'term_id',
                'terms' => $category->term_id,
            ]]
        ]);

        foreach ($flows as $flow) {
            $is_unlocked = function_exists('un_is_flow_unlocked') ? un_is_flow_unlocked($flow->ID) : true;
            $lock_icon = $is_unlocked ? '🔓' : '🔒';

            $output .= "<div class='flow-box'>";
            $output .= "<h3>{$lock_icon} {$flow->post_title}</h3>";

            if ($is_unlocked) {
                // دریافت مراحل مرتبط با این جریان
                $stages = get_posts([
                    'post_type' => 'un_stage',
                    'numberposts' => -1,
                    'meta_key' => '_un_stage_flow_id',
                    'meta_value' => $flow->ID
                ]);

                if ($stages) {
                    $output .= "<ul>";
                    foreach ($stages as $stage) {
                        $output .= "<li>{$stage->post_title}</li>";
                    }
                    $output .= "</ul>";
                } else {
    $output .= "<p><em>" . __('No stages available.', 'un-gamification') . "</em></p>";
}

$output .= "<a href='" . get_permalink($flow) . "'>" . __('View Flow', 'un-gamification') . "</a>";
} else {
    $output .= "<p><em>" . __('This flow is not unlocked for you yet.', 'un-gamification') . "</em></p>";
}

            $output .= "</div>";
        }
    }

    return $output;
}

