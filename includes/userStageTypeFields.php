<?php

add_action('save_post_un_flow', function($post_id) {
    if (!isset($_POST['un_flow_meta_box_nonce_field']) || !wp_verify_nonce($_POST['un_flow_meta_box_nonce_field'], 'un_flow_meta_box_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['un_flow_description'])) {
        update_post_meta($post_id, '_un_flow_description', sanitize_text_field($_POST['un_flow_description']));
    }

    if (isset($_POST['un_flow_first_stage_id'])) {
        update_post_meta($post_id, '_un_flow_first_stage_id', intval($_POST['un_flow_first_stage_id']));
    }

    if (isset($_POST['un_flow_duration'])) {
        update_post_meta($post_id, '_un_flow_duration', intval($_POST['un_flow_duration']));
    }
});

add_action('add_meta_boxes', function() {
    add_meta_box(
        'un_flow_meta_box',
        __('Flow Settings', 'un-gamification'),
        'un_flow_meta_box_callback',
        'un_flow',
        'normal',
        'high'
    );
});

function un_flow_meta_box_callback($post) {
    $desc        = get_post_meta($post->ID, '_un_flow_description', true);
    $first_stage = get_post_meta($post->ID, '_un_flow_first_stage_id', true);
    $duration    = get_post_meta($post->ID, '_un_flow_duration', true);

    wp_nonce_field('un_flow_meta_box_nonce', 'un_flow_meta_box_nonce_field');

    ?>
    <p>
        <label for="un_flow_description"><?php _e('Flow Description:', 'un-gamification'); ?></label><br>
        <textarea name="un_flow_description" id="un_flow_description" rows="4" style="width:100%;"><?php echo esc_textarea($desc); ?></textarea>
    </p>
    <p>
        <label for="un_flow_first_stage_id"><?php _e('First Stage ID:', 'un-gamification'); ?></label><br>
        <input type="number" name="un_flow_first_stage_id" id="un_flow_first_stage_id" value="<?php echo esc_attr($first_stage); ?>" style="width: 100%;" />
    </p>
    <p>
        <label for="un_flow_duration"><?php _e('Duration (minutes):', 'un-gamification'); ?></label><br>
        <input type="number" name="un_flow_duration" id="un_flow_duration" value="<?php echo esc_attr($duration); ?>" style="width: 100%;" />
    </p>
    <?php
}

add_action('add_meta_boxes', function () {
    add_meta_box('un_stage_type_meta', __('Advanced Stage Settings', 'un-gamification'), 'un_stage_type_meta_callback', 'un_stage', 'normal');
});

function un_stage_type_meta_callback($post) {
	
	
	$allowed_html = array(
    'a' => array(
        'href' => array(),
        'title' => array(),
        'class' => array()
    ),
    'p' => array(
        'class' => array() 
    ),
	);
	
	
	
    $type = get_post_meta($post->ID, '_un_stage_type', true);

    // Stage Values
    $text_html = get_post_meta($post->ID, '_un_stage_text_html', true);
    $quiz_question = get_post_meta($post->ID, '_un_stage_quiz_question', true);
    $quiz_options = get_post_meta($post->ID, '_un_stage_quiz_options', true);
    $video_url = get_post_meta($post->ID, '_un_stage_video_url', true);
    $video_type = get_post_meta($post->ID, '_un_stage_video_type', true);
    $game_embed = get_post_meta($post->ID, '_un_stage_game_embed', true);
    $game_type = get_post_meta($post->ID, '_un_stage_game_type', true);

    // Display settings
    $bg_image = get_post_meta($post->ID, '_un_stage_background_image', true);
    $char1_img = get_post_meta($post->ID, '_un_stage_char1_img', true);
    $char1_text1 = get_post_meta($post->ID, '_un_stage_char1_text1', true);
    $char1_text2 = get_post_meta($post->ID, '_un_stage_char1_text2', true);
    $char2_img = get_post_meta($post->ID, '_un_stage_char2_img', true);
    $char2_text1 = get_post_meta($post->ID, '_un_stage_char2_text1', true);
    $char2_text2 = get_post_meta($post->ID, '_un_stage_char2_text2', true);
    
    $audio_url = get_post_meta($post->ID, '_un_stage_audio_url', true);

    echo '<div style="margin-top:1rem">';
    echo '<p><strong>' . __('Stage Settings based on selected type:', 'un-gamification') . '</strong></p>';

    if ($type === 'text' || $type === 'end') {
        echo '<label>' . __('HTML Content:', 'un-gamification') . '</label><br>';
        echo '<textarea name="un_stage_text_html" rows="8" style="width:100%">' . esc_textarea($text_html) . '</textarea>';
    }

    if ($type === 'quiz') {
        echo '<label>' . __('Question Text:', 'un-gamification') . '</label><br>';
        echo '<input type="text" name="un_stage_quiz_question" value="' . esc_attr($quiz_question) . '" style="width:100%"><br><br>';
        echo '<label>' . __('Options (JSON format):', 'un-gamification') . '</label><br>';
        echo '<textarea name="un_stage_quiz_options" rows="6" style="width:100%">' . esc_textarea($quiz_options) . '</textarea>';
        echo '<small>' . __('Example: [ {"text": "Option 1", "type": "correct"}, {"text": "Option 2", "type": "wrong"} ]', 'un-gamification') . '</small>';
    }
    
    if ($type === 'text' || $type === 'quiz' || $type === 'game' || $type === 'end') {

    echo '<label>' . __('Audio URL:', 'un-gamification') . '</label><br>';
    echo '<input type="text" name="un_stage_audio_url" value="' . esc_attr($audio_url) . '" style="width:100%"><br><br>';
    }

    if ($type === 'video') {
        echo '<label>' . __('Video URL:', 'un-gamification') . '</label><br>';
        echo '<input type="text" name="un_stage_video_url" value="' . esc_attr($video_url) . '" style="width:100%"><br>';
        echo '<label>' . __('Video Type:', 'un-gamification') . '</label><br>';
        echo '<select name="un_stage_video_type">';
        foreach ([ 'youtube' => __('YouTube', 'un-gamification'), 'aparat' => __('Aparat', 'un-gamification'), 'local' => __('Local', 'un-gamification') ] as $val => $label) {
            $selected = ($video_type === $val) ? 'selected' : '';
            echo "<option value='$val' $selected>$label</option>";
        }
        echo '</select>';
    }

    if ($type === 'game') {
		echo '<label>' . __('Game Type:', 'un-gamification') . '</label><br>';
        echo '<select name="un_stage_game_type">';
        foreach ([ 
		'game_1' => __('Game 1', 'un-gamification'),
		'game_2' => __('Game 2', 'un-gamification'),
		'game_3' => __('Game 3', 'un-gamification'),
		'game_4' => __('Game 4', 'un-gamification'),
		'game_5' => __('Game 5', 'un-gamification'),
		'game_6' => __('Game 6', 'un-gamification'),
		'game_7' => __('Game 7', 'un-gamification'),
		'game_8' => __('Game 8', 'un-gamification')
		] as $val => $label) {
            $selected = ($game_type === $val) ? 'selected' : '';
            echo "<option value='$val' $selected>$label</option>";
        }
        echo '</select>';
        echo '<label>' . __('Game Embed Code or iframe URL:', 'un-gamification') . '</label><br>';
        echo '<textarea name="un_stage_game_embed" rows="4" style="width:100%">' . esc_textarea($game_embed) . '</textarea>';
    }

    echo '<hr><strong>' . __('🎭 Display Settings (Optional):', 'un-gamification') . '</strong><br>';

    echo '<label>' . __('🔳 Background Image URL:', 'un-gamification') . '</label><br>';
    echo '<input type="text" name="un_stage_background_image" value="' . esc_attr($bg_image) . '" style="width:100%"><br>';

    echo '<label>' . __('🧍‍♂️ Character 1 Image URL:', 'un-gamification') . '</label><br>';
    echo '<input type="text" name="un_stage_char1_img" value="' . esc_attr($char1_img) . '" style="width:100%"><br>';
    echo '<label>' . __('Character 1 Text 1:', 'un-gamification') . '</label><br>';
    echo '<textarea name="un_stage_char1_text1" rows="4" style="width:100%">' . esc_textarea($char1_text1) . '</textarea><br>';
    echo '<label>' . __('Character 1 Text 2:', 'un-gamification') . '</label><br>';
    echo '<input type="text" name="un_stage_char1_text2" value="' . esc_attr($char1_text2) . '" style="width:100%"><br>';

    echo '<label>' . __('🧍‍♀️ Character 2 Image URL:', 'un-gamification') . '</label><br>';
    echo '<input type="text" name="un_stage_char2_img" value="' . esc_attr($char2_img) . '" style="width:100%"><br>';
    echo '<label>' . __('Character 2 Text 1:', 'un-gamification') . '</label><br>';
	echo '<textarea name="un_stage_char2_text1" rows="4" style="width:100%">' . esc_textarea($char2_text1) . '</textarea><br>';
    echo '<label>' . __('Character 2 Text 2:', 'un-gamification') . '</label><br>';
    echo '<input type="text" name="un_stage_char2_text2" value="' . esc_attr($char2_text2) . '" style="width:100%"><br>';

    echo '</div>';
}

add_action('save_post_un_stage', function ($post_id) {
	update_post_meta($post_id, '_un_stage_text_html', wp_kses_post($_POST['un_stage_text_html'] ?? ''));
    update_post_meta($post_id, '_un_stage_quiz_question', sanitize_text_field($_POST['un_stage_quiz_question'] ?? ''));
    update_post_meta($post_id, '_un_stage_quiz_options', wp_kses_post($_POST['un_stage_quiz_options'] ?? ''));
    update_post_meta($post_id, '_un_stage_video_url', esc_url_raw($_POST['un_stage_video_url'] ?? ''));
    update_post_meta(
    $post_id,
    '_un_stage_audio_url',
    esc_url_raw($_POST['un_stage_audio_url'] ?? '')
    );
    
    
    update_post_meta($post_id, '_un_stage_video_type', sanitize_text_field($_POST['un_stage_video_type'] ?? ''));
    update_post_meta($post_id, '_un_stage_game_embed', $_POST['un_stage_game_embed'] ?? '');
    update_post_meta($post_id, '_un_stage_game_type', sanitize_text_field($_POST['un_stage_game_type'] ?? ''));

    update_post_meta($post_id, '_un_stage_background_image', esc_url_raw($_POST['un_stage_background_image'] ?? ''));
    update_post_meta($post_id, '_un_stage_char1_img', esc_url_raw($_POST['un_stage_char1_img'] ?? ''));
    update_post_meta($post_id, '_un_stage_char1_text1', wp_kses_post($_POST['un_stage_char1_text1'] ?? ''));
    update_post_meta($post_id, '_un_stage_char1_text2', sanitize_text_field($_POST['un_stage_char1_text2'] ?? ''));
    update_post_meta($post_id, '_un_stage_char2_img', esc_url_raw($_POST['un_stage_char2_img'] ?? ''));
    update_post_meta($post_id, '_un_stage_char2_text1', wp_kses_post($_POST['un_stage_char2_text1'] ?? ''));
    update_post_meta($post_id, '_un_stage_char2_text2', sanitize_text_field($_POST['un_stage_char2_text2'] ?? ''));
});






// Add image field to add form


// اضافه کردن جاوااسکریپت برای پیش‌نمایش کوچک تصویر هنگام تایپ URL
add_action('admin_footer', function() {
    $screen = get_current_screen();
    if ($screen->taxonomy === 'un_flow_category') {
        ?>
        <script>
            jQuery(document).ready(function($){
                $('#un_category_image_url').on('input', function(){
                    var url = $(this).val();
                    var preview = $(this).siblings('#un_category_image_preview');
                    if(url){
                        if(preview.find('img').length === 0){
                            preview.html('<img src="'+url+'" style="max-width:100px;">');
                        } else {
                            preview.find('img').attr('src', url);
                        }
                        preview.show();
                    } else {
                        preview.hide();
                    }
                });
            });
        </script>
        <?php
    }
});





add_action('un_flow_category_add_form_fields', function() { ?>
    <div class="form-field">
        <label for="un_category_image_url"><?php _e('Image URL', 'un-gamification'); ?></label>
        <input type="text" name="un_category_image_url" id="un_category_image_url" value="" style="width:100%;" placeholder="<?php esc_attr_e('Enter image URL here...', 'un-gamification'); ?>">
        <div id="un_category_image_preview" style="margin-top:10px; display:none;">
            <img src="" style="max-width:100px;">
        </div>
    </div>

    <div class="form-field">
        <label for="un_category_priority"><?php _e('Priority', 'un-gamification'); ?></label>
        <input type="number" name="un_category_priority" id="un_category_priority" value="0" style="width:100%;" placeholder="<?php esc_attr_e('Enter display priority...', 'un-gamification'); ?>">
        <p class="description"><?php _e('Lower numbers appear first', 'un-gamification'); ?></p>
    </div>
<?php });


add_action('un_flow_category_edit_form_fields', function($term) {
    $image_url = get_term_meta($term->term_id, 'un_category_image_url', true);
    $priority = get_term_meta($term->term_id, 'un_category_priority', true); ?>
    <tr class="form-field">
        <th scope="row"><label for="un_category_image_url"><?php _e('Image URL', 'un-gamification'); ?></label></th>
        <td>
            <input type="text" name="un_category_image_url" id="un_category_image_url" value="<?php echo esc_attr($image_url); ?>" style="width:100%;">
            <div id="un_category_image_preview" style="margin-top:10px;">
                <?php if ($image_url): ?>
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width:100px;">
                <?php endif; ?>
            </div>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="un_category_priority"><?php _e('Priority', 'un-gamification'); ?></label></th>
        <td>
            <input type="number" name="un_category_priority" id="un_category_priority" value="<?php echo esc_attr($priority ?: 0); ?>" style="width:100%;">
            <p class="description"><?php _e('Lower numbers appear first', 'un-gamification'); ?></p>
        </td>
    </tr>
<?php });

add_action('created_un_flow_category', 'un_save_category_extra_fields');
add_action('edited_un_flow_category', 'un_save_category_extra_fields');
function un_save_category_extra_fields($term_id) {
    if (isset($_POST['un_category_image_url'])) {
        update_term_meta($term_id, 'un_category_image_url', esc_url_raw($_POST['un_category_image_url']));
    }
    if (isset($_POST['un_category_priority'])) {
        update_term_meta($term_id, 'un_category_priority', intval($_POST['un_category_priority']));
    }
}
