<?php 
if ($char1_img!="" || $char1_text1 !="" || $char1_text2 !="") { $char1='on'; }
if ($char2_img!="" || $char2_text1 !="" || $char2_text2 !="") { $char2='on'; }
if ($char1=='on' && $char2=='on') { $char1_class = 'char-left';$char2_class = 'char-right';
}elseif ($char1=='on' && $char2!='on'){ $char1_class = 'char-single char-single-right';$char2_class = '';
}elseif ($char1!='on' && $char2=='on'){ $char1_class = '';$char2_class = 'char-single char-single-left'; }  
?>
<style>
.dialogue-scene {
    display: block;
}
.character {
    margin-bottom: 0px;
	display: contents;
}	
.char-single {
    width: 100%;
}	
.character-single img {
    max-height: 350px;
    max-width: 70%;
}	
.char-single img {
    max-height: 330px;
    max-width: 75%;
    position: absolute;
    bottom: 0px;
    left: 0px;
}	
.speech {
    top: 0px;
	z-index: 9;
}
.char-single .speech-right {
    border-right: 5px solid #d99058;
    border-left: 0px;
    max-width: 50%;
	left: 5px;
<?php if ($char2_text1) { ?>top: 0px;<?php } ?>
<?php if ($char2_text2) { ?>bottom: 5px;top: auto;<?php } ?>
}
.char-single .speech-left {
    border-left: 5px solid #00a594;
    border-right: 0px;
    max-width: 50%;
	right: 5px;
<?php if ($char1_text1) { ?>top: 0px;<?php } ?>
<?php if ($char1_text2) { ?>bottom: 5px;top: auto;<?php }  ?>		
}
	
.char-right img , .char-right img {
    max-height: 400px;
}    	
@media only screen and (max-width: 994px) {
.char-right img , .char-right img {
    max-height: 370px;
}  
}

@media only screen and (max-width: 640px) {
.char-right img , .char-right img {
    max-height: 330px;
}  
}

@media only screen and (max-width: 480px) {
.char-right img , .char-right img {
    max-height: 300px;
}  
}	
	
.char-left img {
    max-width: 45%;
    position: absolute;
    bottom: -50px;
    left: 0px;
}
.char-left .speech-left {
    border-left: 5px solid #00a594;
    border-right: 0px;
    top: 0px;
    left: 5px;
	max-width: 80%;
}


.char-right img {
    max-width: 45%;
    position: absolute;
    bottom: -50px;
    right: 0px;
}
.char-right .speech-right {
    border-right: 5px solid #d99058;
    border-left: 0px;
    top: auto;
    right: 5px;
    bottom: 10px;
}
	
.char-single.char-single-left img {
    right: 0px;
    left: auto;
}	
	
	
@media only screen and (max-width: 994px) {
    .character {
        margin-bottom: 0px;
    }
}
		
@media only screen and (max-width: 450px) {
.char-single img {
   left: -2%;
   max-width: 65%;
}
.char-single.char-single-left img {
    right: -2%;
    left: auto;
}		
.char-left img {
    left: -5%;
    bottom: -20px;
	max-width: 52%;
}
.char-right img {
    right: -5%;
    bottom: -20px;
	max-width: 52%;
}	
}
	
	
	
	
	
	
	
	
	
	
	
.typing-effect {
    opacity: 0; 
    animation: typing 1s forwards;
}
.typing-effect-2 {	
animation-delay: 1s;
}
.typing-effect-3 {	
animation-delay: 2s;
}
.typing-effect-4 {	
animation-delay: 3s;
}
.typing-effect-5 {	
animation-delay: 4s;
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

<div id="un-stage-dialogue" class="dialogue-scene typing-effect" <?php if ($bg_image) { ?>style="background-image: url('<?php echo $bg_image;?>')" <?php } ?> >
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