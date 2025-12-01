<?php
/*
action: get_un_flows_by_category
بر اساس slug دسته‌بندی (taxonomy: un_flow_category) لیست جریان‌ها رو می‌اره
هر جریان شامل:
عنوان
توضیحات
دکمه شروع با آیدی اولین مرحله (برای مرحله بعدی)
action: get_un_flows_by_category
Based on the category slug (taxonomy: un_flow_category), it fetches the list of flows.
Each flow includes:
Title
Description
Start button with the ID of the first stage (for the next stage)
*/ 
add_action('wp_ajax_get_un_flows_by_category', 'get_un_flows_by_category_callback');
add_action('wp_ajax_nopriv_get_un_flows_by_category', 'get_un_flows_by_category_callback');

function get_un_flows_by_category_callback() {
    check_ajax_referer('un_flow_nonce', 'nonce');
	
	// بررسی مبدا درخواست (اطمینان از اینکه درخواست از سایت خودتان است)
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $site_url = get_site_url(); // URL سایت شما

    // بررسی اینکه مبدا درخواست با دامنه سایت شما همخوانی دارد یا خیر
    if (strpos($referer, $site_url) !== 0) {
        wp_send_json_error(__('Invalid request origin.', 'un-gamification'));
        return;
    }

    $category = sanitize_text_field($_POST['category']);

    // اگر دسته ارسال نشده، لیست دسته‌ها رو برگردون
    if (empty($category)) {
        $categories = get_terms([
            'taxonomy'   => 'un_flow_category',
            'hide_empty' => false,
        ]);

        if (empty($categories) || is_wp_error($categories)) {
            wp_send_json_error(__('No categories found.', 'un-gamification'));
        }

        ob_start();
        echo "<div class='un-flow-categories'>";


foreach ($categories as $cat) {
    $thumbnail = get_term_meta($cat->term_id, 'un_category_image_url', true) ?: 'https://via.placeholder.com/300x200?text=' . urlencode(__('No image', 'un-gamification'));
    echo "<div class='un-flow-category-item' data-slug='" . esc_attr($cat->slug) . "'>
        <img class='un-flow-category-thumb' src='" . esc_url($thumbnail) . "' alt='" . esc_attr($cat->name) . "' />
        <h4>" . esc_html($cat->name) . "</h4>
        <p>" . esc_html($cat->description) . "</p>
    </div>";
}		


        echo "</div>";
        $output = ob_get_clean();
        wp_send_json_success($output);
    }

    // در غیر این صورت، flowهای آن دسته را واکشی کن
    $args = [
        'post_type'      => 'un_flow',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'tax_query'      => [
            [
                'taxonomy' => 'un_flow_category',
                'field'    => 'slug',
                'terms'    => $category,
            ]
        ],
    ];

    $flows = get_posts($args);

    if (empty($flows)) {
        wp_send_json_error(__('No flows found in this category.', 'un-gamification'));
    }

    ob_start();

    foreach ($flows as $flow) {
        $id = $flow->ID;
        $thumbnail = get_the_post_thumbnail_url($id, 'large') ?: 'https://via.placeholder.com/300x200?text=' . urlencode(__('No image', 'un-gamification'));
        $duration  = get_post_meta($id, '_un_flow_duration', true) ?: __('Unknown', 'un-gamification');
        $title     = get_the_title($id);
        $desc      = get_post_meta($id, '_un_flow_description', true) ?: __('No description', 'un-gamification');
        $first_stage = get_post_meta($id, '_un_flow_first_stage_id', true) ?: 0;

        echo "<div class='un-flow-item'>
            <img class='un-flow-thumbnail' src='" . esc_url($thumbnail) . "' alt='" . esc_attr($title) . "' />
            <div class='un-flow-info'>
                <h4>" . esc_html($title) . "</h4>
                <p>" . esc_html($desc) . "</p>
                <button class='start-flow-button' data-stage='" . esc_attr($first_stage) . "'>" . __('Start', 'un-gamification') . "</button>
            </div>
        </div>";
    }

    $output = ob_get_clean();
    wp_send_json_success($output);
}





// Loading stages
add_action('wp_ajax_get_un_stage_by_id', 'get_un_stage_by_id_callback');
add_action('wp_ajax_nopriv_get_un_stage_by_id', 'get_un_stage_by_id_callback');

function get_un_stage_by_id_callback() {
    check_ajax_referer('un_flow_nonce', 'nonce');

    $stage_id = intval($_POST['stage_id']);
	$status = $_POST['status'];
    if (!$stage_id) {
        wp_send_json_error(__('Invalid stage ID.', 'un-gamification'));
    }

    $type = get_post_meta($stage_id, '_un_stage_type', true) ?: 'text';
    $content = get_post_meta($stage_id, '_un_stage_text_html', true);

    ob_start();
	
	// Stage display settings
    $bg_image     = get_post_meta($stage_id, '_un_stage_background_image', true);
	// cookie survey set
	$info_done = isset($_COOKIE['unhcr_help_ir_gamification_info']) && sanitize_text_field($_COOKIE['unhcr_help_ir_gamification_info']) === 'true';


    if ($status==='first' && !$info_done) {
        
	require_once plugin_dir_path(__FILE__) . 'format/survey.php';//survey format	
	echo "<button id='nextStageBtnSU' class='un-stage-next-button un-stage-next-button-su' data-next='" . esc_attr($stage_id) . "'>" . __('Next stage', 'un-gamification') . "</button>";		
		//echo '<input type="hidden" id="next_stage_input" value="' . esc_attr($stage_id) . '">';
		
    }else{
	
    $correct_id = get_post_meta($stage_id, '_un_stage_correct_stage_id', true);
    $wrong_id   = get_post_meta($stage_id, '_un_stage_wrong_stage_id', true);
    $neutral_id = get_post_meta($stage_id, '_un_stage_neutral_stage_id', true);

    // Stage display settings
    $char1_img    = get_post_meta($stage_id, '_un_stage_char1_img', true);
    $char1_text1  = get_post_meta($stage_id, '_un_stage_char1_text1', true);
    $char1_text2  = get_post_meta($stage_id, '_un_stage_char1_text2', true);
    $char2_img    = get_post_meta($stage_id, '_un_stage_char2_img', true);
    $char2_text1  = get_post_meta($stage_id, '_un_stage_char2_text1', true);
    $char2_text2  = get_post_meta($stage_id, '_un_stage_char2_text2', true);
	$video_link  = get_post_meta($stage_id, '_un_stage_video_url', true);
	$video_type  = get_post_meta($stage_id, '_un_stage_video_type', true);
	$game_code  = get_post_meta($stage_id, '_un_stage_game_embed', true);

    if ($type === 'quiz') {
        echo "<div class='un-stage un-stage-type-quiz' 
            data-correct='" . esc_attr($correct_id) . "'
            data-wrong='" . esc_attr($wrong_id) . "'
            data-neutral='" . esc_attr($neutral_id) . "'>";
    } else {
        echo "<div class='un-stage un-stage-type-$type'>";
    }

    echo "<!-- " . sprintf(__('Stage #%d', 'un-gamification'), $stage_id) . " -->";

	if ($type === 'text') {
    require_once plugin_dir_path(__FILE__) . 'format/text.php';//text and dialog format

	
	} elseif ($type === 'quiz') {
	require_once plugin_dir_path(__FILE__) . 'format/quiz.php';//quiz format

		
} elseif ($type === 'video') {
    if ($video_type=='youtube') {
        // YouTube Embed
        $embed = wp_oembed_get($content);
        echo $embed ?: '<p>' . __('Unable to display video.', 'un-gamification') . '</p>';
    } elseif ($video_type=='aparat') {
        echo "<iframe src='" . esc_url($content) . "' width='100%' height='315' allowfullscreen></iframe>";
    } elseif ($video_type=='local') {
        echo "<video controls autoplay width='100%'><source src='" . esc_url($video_link) . "' type='video/mp4'></video>";
    } else {
        echo "<p>" . __('Video format not supported.', 'un-gamification') . "</p>";
    }
} elseif ($type === 'game') {
/*		
    if (strpos($content, '<iframe') !== false) {
        echo $content; // Raw HTML
    } elseif (preg_match('/\.html$/', $content)) {
        echo "<iframe src='" . esc_url($content) . "' width='100%' height='400'></iframe>";
    } else {
        echo "<p>" . __('Game not available for display.', 'un-gamification') . "</p>";
    }
*/
//		echo $game_code;


?>

<div class="game-container">
    <div class="game-cell">🔵</div>
    <div class="game-cell">🟢</div>
    <div class="game-cell">🟢</div>
    <div class="game-cell">🔵</div>
    <div class="game-cell">🟠</div>
    <div class="game-cell">🟠</div>
</div>
<div class="game-message"><?php echo __('تصاویر با موضوع مشابه را انتخاب کنید', 'un-gamification'); ?></div>




<?php
	
		
		
} elseif ($type === 'end') {
require_once plugin_dir_path(__FILE__) . 'format/final.php';//final format		

} else {
    echo "<p>" . __('Stage type not supported.', 'un-gamification') . "</p>";
}
		
	}		
	
		

if ($type === 'text' || $type === 'video' || $type === 'game') {
    if ($correct_id) {
      //  echo "<button class='un-stage-next-button' data-next='" . esc_attr($correct_id) . "'>" . __('Next stage', 'un-gamification') . "</button>";
		//	 echo '<input type="hidden" id="next_stage_input" value="' . esc_attr($stage_id) . '">';
    }
}

	echo "</div>";
	

$html = ob_get_clean();

// گرفتن آیدی مرحله بعد (در صورتی که وجود داشته باشد)
$next_stage_id = !empty($correct_id) ? intval($correct_id) : 0;

wp_send_json_success([
    'html' => $html,
    'next_stage' => $next_stage_id
]);
}
