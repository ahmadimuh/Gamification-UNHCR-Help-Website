<?php
// نمایش مراحل
// [un_stage_view stage_id="123"]
add_shortcode('un_stage_view', function ($atts) {
    $atts = shortcode_atts(['stage_id' => 0], $atts);
    $stage_id = intval($atts['stage_id']);
    if (!$stage_id) return __('No stage specified.', 'un-gamification');

    $stage = get_post($stage_id);
    if (!$stage || $stage->post_type !== 'un_stage') return __('Stage not found.', 'un-gamification');

    $type = get_post_meta($stage_id, '_un_stage_type', true);

    // نمایش عناصر گرافیکی (اختیاری)
    $bg = esc_url(get_post_meta($stage_id, '_un_stage_background_image', true));
    $char1_img = esc_url(get_post_meta($stage_id, '_un_stage_char1_img', true));
    $char1_text1 = esc_html(get_post_meta($stage_id, '_un_stage_char1_text1', true));
    $char1_text2 = esc_html(get_post_meta($stage_id, '_un_stage_char1_text2', true));
    $char2_img = esc_url(get_post_meta($stage_id, '_un_stage_char2_img', true));
    $char2_text1 = esc_html(get_post_meta($stage_id, '_un_stage_char2_text1', true));
    $char2_text2 = esc_html(get_post_meta($stage_id, '_un_stage_char2_text2', true));

    ob_start();

    echo "<div class='un-stage' style='background-image:url($bg); background-size:cover; padding:2rem; min-height:400px'>";

    echo "<div class='dialogue' style='display:flex; justify-content:space-between; align-items:flex-end;'>";
    if ($char1_img) echo "<div><img src='$char1_img' style='max-height:150px'><p>$char1_text1</p><p>$char1_text2</p></div>";
    if ($char2_img) echo "<div><img src='$char2_img' style='max-height:150px'><p>$char2_text1</p><p>$char2_text2</p></div>";
    echo "</div><hr>";

    echo "<h2>{$stage->post_title}</h2>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $_POST['result'] ?? 'neutral';
        $next = get_post_meta($stage_id, "_un_stage_{$result}_stage_id", true);
        if ($next) {
            wp_redirect(add_query_arg('stage_id', $next));
            exit;
        } else {
            echo "<p><strong>🎉 " . __('End of the path', 'un-gamification') . "</strong></p>";
            return ob_get_clean();
        }
    }

    switch ($type) {
        case 'text':
            $html = get_post_meta($stage_id, '_un_stage_text_html', true);
            echo "<div class='un-html-content'>$html</div>";
            echo "<form method='post'><input type='hidden' name='result' value='neutral'><button type='submit'>" . __('Continue', 'un-gamification') . "</button></form>";
            break;

        case 'quiz':
            $question = get_post_meta($stage_id, '_un_stage_quiz_question', true);
            $options = json_decode(get_post_meta($stage_id, '_un_stage_quiz_options', true), true);
            echo "<form method='post'><p><strong>$question</strong></p>";
            foreach ($options as $i => $opt) {
                $text = esc_html($opt['text']);
                $type = esc_attr($opt['type']);
                echo "<label><input type='radio' name='result' value='$type'> $text</label><br>";
            }
            echo "<button type='submit'>" . __('Submit', 'un-gamification') . "</button></form>";
            break;

        case 'video':
            $url = get_post_meta($stage_id, '_un_stage_video_url', true);
            $vtype = get_post_meta($stage_id, '_un_stage_video_type', true);
            echo "<div class='video-wrapper' style='margin:1rem 0'>";
            if ($vtype === 'youtube') {
                echo "<iframe width='100%' height='315' src='https://www.youtube.com/embed/" . esc_attr($url) . "' frameborder='0' allowfullscreen></iframe>";
            } elseif ($vtype === 'aparat') {
                echo "<iframe src='https://www.aparat.com/video/video/embed/vt/frame/showvideo/yes/videohash/$url' width='100%' height='315' allowfullscreen></iframe>";
            } else {
                echo "<video controls width='100%'><source src='" . esc_url($url) . "' type='video/mp4'></video>";
            }
            echo "</div><form method='post'><input type='hidden' name='result' value='neutral'><button type='submit'>" . __('Continue', 'un-gamification') . "</button></form>";
            break;

        case 'game':
            $embed = get_post_meta($stage_id, '_un_stage_game_embed', true);
            echo "<div class='game-wrapper'>$embed</div>";
            echo "<form method='post'>
                <select name='result'>
                    <option value='correct'>" . __('Correct', 'un-gamification') . "</option>
                    <option value='wrong'>" . __('Wrong', 'un-gamification') . "</option>
                    <option value='neutral'>" . __('Neutral', 'un-gamification') . "</option>
                </select>
                <button type='submit'>" . __('Continue', 'un-gamification') . "</button>
            </form>";
            break;
    }

    echo "</div>";
    return ob_get_clean();
});


// نمایش اطلاعات یک مرحله
//[un_stage_debug stage_id="123"]
add_shortcode('un_stage_debug', function($atts) {
    $atts = shortcode_atts(['stage_id' => 0], $atts);
    $id = intval($atts['stage_id']);
    if (!$id) return __('⚠️ Stage ID not specified.', 'un-gamification');

    $post = get_post($id);
    if (!$post || $post->post_type !== 'un_stage') return __('❌ Stage not found.', 'un-gamification');

    $meta = get_post_meta($id);

    ob_start();
    echo "<h3>📍 " . __('Stage information: ', 'un-gamification') . "<strong>{$post->post_title}</strong> (ID: $id)</h3>";
    echo "<table style='border-collapse:collapse; width:100%' border='1'>";
    echo "<thead><tr><th>" . __('Key', 'un-gamification') . "</th><th>" . __('Value', 'un-gamification') . "</th></tr></thead><tbody>";

    foreach ($meta as $key => $values) {
        $value = maybe_unserialize($values[0]);
        if (is_array($value) || is_object($value)) {
            $value = '<pre>' . esc_html(print_r($value, true)) . '</pre>';
        } else {
            $value = esc_html($value);
        }
        echo "<tr><td><code>$key</code></td><td>$value</td></tr>";
    }

    echo "</tbody></table>";
    return ob_get_clean();
});
