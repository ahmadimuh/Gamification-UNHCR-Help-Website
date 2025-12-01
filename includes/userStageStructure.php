<?php
//🔷 1. جریان‌ها (Flows) → post_type: un_flow
//🔶 2. مراحل (Stages) → post_type: un_stage
//هر مرحله یک جریان داره (یک‌به‌چند: flow → stages)
// Register custom post type: Flow
add_action('init', function () {
    register_post_type('un_flow', [
        'labels' => [
            'name'          => __('Flows', 'un-gamification'),
            'singular_name' => __('Flow', 'un-gamification'),
            'add_new'       => __('Add Flow', 'un-gamification'),
            'edit_item'     => __('Edit Flow', 'un-gamification'),
            'new_item'      => __('New Flow', 'un-gamification'),
            'view_item'     => __('View Flow', 'un-gamification'),
        ],
        'public'        => true,
        'menu_icon'     => 'dashicons-randomize',
        'supports'      => ['title', 'editor', 'thumbnail'],
        'show_in_rest'  => true,
        'has_archive'   => true,
    ]);
});

// Register taxonomy: Flow Categories
add_action('init', function () {
    register_taxonomy('un_flow_category', 'un_flow', [
        'labels' => [
            'name'              => __('Flow Categories', 'un-gamification'),
            'singular_name'     => __('Flow Category', 'un-gamification'),
            'search_items'      => __('Search Categories', 'un-gamification'),
            'all_items'         => __('All Categories', 'un-gamification'),
            'edit_item'         => __('Edit Category', 'un-gamification'),
            'update_item'       => __('Update Category', 'un-gamification'),
            'add_new_item'      => __('Add New Category', 'un-gamification'),
            'new_item_name'     => __('New Category Name', 'un-gamification'),
            'menu_name'         => __('Flow Categories', 'un-gamification'),
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'flow-category'],
    ]);
});

// Register custom post type: Stage
add_action('init', function () {
    register_post_type('un_stage', [
        'labels' => [
            'name'          => __('Stages', 'un-gamification'),
            'singular_name' => __('Stage', 'un-gamification'),
            'add_new'       => __('Add Stage', 'un-gamification'),
            'edit_item'     => __('Edit Stage', 'un-gamification'),
            'new_item'      => __('New Stage', 'un-gamification'),
            'view_item'     => __('View Stage', 'un-gamification'),
        ],
        'public'        => true,
        'menu_icon'     => 'dashicons-flag',
        'supports'      => ['title', 'editor', 'thumbnail'],
        'show_in_rest'  => true,
    ]);
});

// Add flow selector meta box to stage editor
add_action('add_meta_boxes', function () {
    add_meta_box(
        'un_stage_flow_meta',
        __('Related Flow', 'un-gamification'),
        'un_stage_flow_meta_callback',
        'un_stage',
        'side',
        'default'
    );
});

function un_stage_flow_meta_callback($post) {
    $selected_flow_id = get_post_meta($post->ID, '_un_stage_flow_id', true);
    $flows = get_posts([
        'post_type' => 'un_flow',
        'numberposts' => -1,
    ]);

    echo '<select name="un_stage_flow_id">';
    echo '<option value="">-- ' . __('Select Flow', 'un-gamification') . ' --</option>';
    foreach ($flows as $flow) {
        $selected = $flow->ID == $selected_flow_id ? 'selected' : '';
        echo "<option value='{$flow->ID}' {$selected}>{$flow->post_title}</option>";
    }
    echo '</select>';
}

add_action('save_post_un_stage', function ($post_id) {
    if (isset($_POST['un_stage_flow_id'])) {
        update_post_meta($post_id, '_un_stage_flow_id', intval($_POST['un_stage_flow_id']));
    }
});

