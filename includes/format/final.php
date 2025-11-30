<div id="un-stage-dialogue" class="dialogue-scene dialogue-quiz" <?php if ($bg_image) { ?>style="background-image: url('<?php echo $bg_image;?>')" <?php } ?> >
		<div class='un-stage-text'>
			<?php if ($content!="") { ?><?php echo $content;?><?php } ?>
<?php
 echo "<div class='un-stage un-stage-type-end'>";
   // echo "<h3>🎉 " . __('End of the flow', 'un-gamification') . "</h3>";
   // echo "<p>" . __('Congratulations! You have successfully completed this flow.', 'un-gamification') . "</p>";
    echo "<div class='un-stage-end-buttons'>";
    echo "</div>";
    echo "</div>";
?>							
		</div>		
</div>	
