<?php 
if ($char1_img!="" || $char1_text1 !="" || $char1_text2 !="") { $char1='on'; }
if ($char2_img!="" || $char2_text1 !="" || $char2_text2 !="") { $char2='on'; }
if ($char1=='on' && $char2=='on') { $char1_class = 'char-left';$char2_class = 'char-right';
}elseif ($char1=='on' && $char2!='on'){ $char1_class = 'char-single char-single-right';$char2_class = '';
}elseif ($char1!='on' && $char2=='on'){ $char1_class = '';$char2_class = 'char-single char-single-left'; }  
?>


<div id="un-stage-dialogue" class="dialogue-scene typing-effect" <?php if ($bg_image) { ?>style="background-image: url('<?php echo $bg_image;?>')" <?php } ?> >
<div class="next-level-alert" >
<svg width="140px" height="140px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="next-level-alert-icon" >
<path fill-rule="evenodd" clip-rule="evenodd" d="M5.60439 4.23093C4.94586 3.73136 4 4.20105 4 5.02762V18.9724C4 19.799 4.94586 20.2686 5.60439 19.7691L14.7952 12.7967C15.3227 12.3965 15.3227 11.6035 14.7952 11.2033L5.60439 4.23093ZM2 5.02762C2 2.54789 4.83758 1.13883 6.81316 2.63755L16.004 9.60993C17.5865 10.8104 17.5865 13.1896 16.004 14.3901L6.81316 21.3625C4.83758 22.8612 2 21.4521 2 18.9724V5.02762Z" fill="#0F0F0F"></path>
<path d="M20 3C20 2.44772 20.4477 2 21 2C21.5523 2 22 2.44772 22 3V21C22 21.5523 21.5523 22 21 22C20.4477 22 20 21.5523 20 21V3Z" fill="#0F0F0F"></path>
</svg>
</div>	
	
	
<?php if ($content!="") { ?><div class='un-stage-text'><?php echo $content;?></div><?php } ?>
<?php if ($char1=='on') { ?>		
<div class="character  <?php echo $char1_class; ?> ">
<?php if ($char1_img) { ?>
<img src="<?php echo $char1_img;?>" alt="<?php echo  __('First character', 'un-gamification'); ?>" class="typing-effect typing-effect-2">
<?php } ?>
<?php if ($char1_text1 !="" || $char1_text2 !="") { ?>	
<div class="speech speech-left typing-effect typing-effect-3">
<?php if ($char1_text1) { ?><p class="line"><?php echo $char1_text1;?></p><?php } ?>
<?php if ($char1_text2) { ?><p class="line"><?php echo $char1_text2;?></p><?php } ?>
</div>
<?php } ?>	
</div>
<?php } ?>
<?php if ($char2=='on') { ?>	
<div class="character <?php echo $char2_class; ?> ">
<?php if ($char2_img) { ?>
<img src="<?php echo $char2_img;?>" alt="<?php echo  __('Second character', 'un-gamification'); ?>"  class="typing-effect typing-effect-4">
<?php } ?>
<?php if ($char2_text1 !="" || $char2_text2 !="") { ?>		
<div class="speech speech-right typing-effect typing-effect-5">
<?php if ($char2_text1) { ?><p class="line"><?php echo $char2_text1;?></p><?php } ?>
<?php if ($char2_text2) { ?><p class="line"><?php echo $char2_text2;?></p><?php } ?>
</div>
<?php } ?>		
</div>
<?php } ?>	
</div>