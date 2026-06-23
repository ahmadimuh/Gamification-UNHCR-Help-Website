
<?php	
    $question = get_post_meta($stage_id, '_un_stage_quiz_question', true) ?: __('The question is not specified.', 'un-gamification');
    $options_json = get_post_meta($stage_id, '_un_stage_quiz_options', true);

    $options = json_decode($options_json, true);

?>		
		<div id="un-stage-dialogue" class="dialogue-scene dialogue-quiz typing-effect" <?php if ($bg_image) { ?>style="background-image: url('<?php echo $bg_image;?>')" <?php } ?> >		
<?php		
  if (!is_array($options)) {
    echo "<p class='un-error'>" . __('Error in quiz options (invalid JSON format)', 'un-gamification') . "</p>";
    wp_send_json_success(ob_get_clean());
    return;
}

echo "<div class='un-quiz-question'><strong>" . __('Question:', 'un-gamification') . "</strong> " . esc_html($question) . "</div>";
echo "<ul class='un-quiz-options'>";

foreach ($options as $opt) {
    $text = $opt['text'] ?? __('Option without text', 'un-gamification');
    $status = $opt['type'] ?? 'neutral'; // Assuming "type" field has value: correct / wrong / neutral
	$result = $opt['result'];
    echo "<li class='un-quiz-option' data-status='" . esc_attr($status) . "'>" . esc_html($text);
	if($result){
	echo "<span class='un-quiz-result'> (" . esc_html($result) . ") </span>";	
	}
	echo "</li>";
}

echo "</ul>";
echo "<p class='un-quiz-result'></p>";
?>
		</div>
<?php
		