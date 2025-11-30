
<style>
.un-quiz-question {
    background: rgb(255 255 255 / 90%);
    margin-top: 0px;
    padding: 5px 5px;
    border-radius: 10px;
}
.un-quiz-options {
    background: rgb(255 255 255 / 90%);
    margin-top: 5px;
    padding: 5px 5px;
    border-radius: 10px;
}	
.un-quiz-options li {
    padding: 5px;
    background-color: #e5e5e5b0;
    border-radius: 10px;
    margin-bottom: 4px;
    border-bottom: dashed 1px #4779a0;
    list-style-type: none;
    cursor: pointer;
}	
.un-quiz-options li.wrong {
    background-color: #e05f5fb0 !important;
}	
.un-quiz-options li.correct {
    background-color: #45bd3db0 !important;
}		
	
.typing-effect {
    opacity: 0; 
    animation: typing 1s forwards;
}


@keyframes typing {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}
</style>	
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
    echo "<li class='un-quiz-option' data-status='" . esc_attr($status) . "'>🔵 " . esc_html($text) . "</li>";
}

echo "</ul>";
echo "<p class='un-quiz-result'></p>";
?>
		</div>
<?php
		