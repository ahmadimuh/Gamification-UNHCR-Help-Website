<?php
// متاباکس برای مرحله: تعیین نوع و مسیرهای بعدی بر اساس نتیجه
// Meta box for stage: Define type and next stages based on result
add_action('add_meta_boxes', function () {
    add_meta_box(
        'un_stage_meta',
        __('Stage Settings', 'un-gamification'),
        'un_stage_meta_callback',
        'un_stage',
        'normal'
    );
});

function un_stage_meta_callback($post) {
    $type = get_post_meta($post->ID, '_un_stage_type', true);
    $next_correct = get_post_meta($post->ID, '_un_stage_correct_stage_id', true);
    $next_wrong = get_post_meta($post->ID, '_un_stage_wrong_stage_id', true);
    $next_neutral = get_post_meta($post->ID, '_un_stage_neutral_stage_id', true);

    $stages = get_posts([
        'post_type' => 'un_stage',
        'numberposts' => -1,
        'exclude' => [$post->ID]
    ]);

    // Stage type
    echo "<p><label>" . __('Stage Type:', 'un-gamification') . "</label><br>";
    echo "<select name='un_stage_type'>";
    $types = [
        'text' => __('Text Display', 'un-gamification'),
        'quiz' => __('Quiz Question', 'un-gamification'),
        'video' => __('Video', 'un-gamification'),
        'game' => __('Game', 'un-gamification'),
        'end' => __('End', 'un-gamification')
    ];
    foreach ($types as $value => $label) {
        $selected = ($value === $type) ? 'selected' : '';
        echo "<option value='$value' $selected>$label</option>";
    }
    echo "</select></p>";

    // Next stage for correct
    echo "<p><label>" . __('Next Stage for <strong>Correct</strong> Answer:', 'un-gamification') . "</label><br><select name='un_stage_correct_stage_id'><option value=''>-- " . __('Select', 'un-gamification') . " --</option>";
    foreach ($stages as $s) {
        $selected = ($s->ID == $next_correct) ? 'selected' : '';
        echo "<option value='{$s->ID}' $selected>{$s->post_title}</option>";
    }
    echo "</select></p>";

    // Next stage for wrong
    echo "<p><label>" . __('Next Stage for <strong>Wrong</strong> Answer:', 'un-gamification') . "</label><br><select name='un_stage_wrong_stage_id'><option value=''>-- " . __('Select', 'un-gamification') . " --</option>";
    foreach ($stages as $s) {
        $selected = ($s->ID == $next_wrong) ? 'selected' : '';
        echo "<option value='{$s->ID}' $selected>{$s->post_title}</option>";
    }
    echo "</select></p>";

    // Next stage for neutral
    echo "<p><label>" . __('Next Stage for <strong>Neutral</strong> Status:', 'un-gamification') . "</label><br><select name='un_stage_neutral_stage_id'><option value=''>-- " . __('Select', 'un-gamification') . " --</option>";
    foreach ($stages as $s) {
        $selected = ($s->ID == $next_neutral) ? 'selected' : '';
        echo "<option value='{$s->ID}' $selected>{$s->post_title}</option>";
    }
    echo "</select></p>";
}

add_action('save_post_un_stage', function ($post_id) {
    update_post_meta($post_id, '_un_stage_type', sanitize_text_field($_POST['un_stage_type'] ?? ''));
    update_post_meta($post_id, '_un_stage_correct_stage_id', intval($_POST['un_stage_correct_stage_id'] ?? 0));
    update_post_meta($post_id, '_un_stage_wrong_stage_id', intval($_POST['un_stage_wrong_stage_id'] ?? 0));
    update_post_meta($post_id, '_un_stage_neutral_stage_id', intval($_POST['un_stage_neutral_stage_id'] ?? 0));
});
