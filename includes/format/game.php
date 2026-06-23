<div id="un-stage-dialogue" class="dialogue-scene dialogue-quiz typing-effect" <?php if ($bg_image) { ?>style="background-image: url('<?php echo $bg_image;?>')" <?php } ?> >	
<?php	
    $game_code  = get_post_meta($stage_id, '_un_stage_game_embed', true);
	$game_type  = get_post_meta($stage_id, '_un_stage_game_type', true);
    $options = json_decode($game_code, true);
	
?>	
	

<?php if($game_type=="game_1"){


foreach ($options as $opt) {
	if($opt['textstart']!=''){$textStart = $opt['textstart'];}
    if($opt['textend']!=''){$textEnd = $opt['textend'];}
    if($opt['textnext']!=''){$textNext = $opt['textnext'];}
}	
?>
<div class="helpIrGamificationGameOne">
<div class='un-text-question'><?php echo $textStart; ?></div>
<ul class='un-text-options'>
<?php
$i=1;
foreach ($options as $opt) {
	$btn = $opt['btn'];
	$desc = $opt['desc'];
	if($btn!='' && $desc!=''){
	?>
	<li class="un-text-option helpIrGamificationGameOneOption" onclick="helpIrGamificationGameOneShowDescription('helpIrGamificationGameOneDesc<?php echo $i;?>')"><?php echo $btn;?>
	<div id="helpIrGamificationGameOneDesc<?php echo $i;?>" class="helpIrGamificationGameOneDescription"><?php echo $desc;?></div>
	</li>
	<?php
	$i++;
    }	
}
?>
</ul>
 
 <div class="game-message" id="gameFinalMessage"><center><?php echo $textEnd; ?> 
 <button class="next-stage-btn" onclick="nextstagegame()" id="gameFinalBtn"><?php echo $textNext; ?></button></center></div>

</div>
<?php }elseif($game_type=="game_2"){ 

foreach ($options as $opt) {
	if($opt['textstart']!=''){$textStart = $opt['textstart'];}
	if($opt['images']!=''){$showImages = $opt['images'];}
    if($opt['textend']!=''){$textEnd = $opt['textend'];}
    if($opt['textnext']!=''){$textNext = $opt['textnext'];}
    if($opt['texterror1']!=''){$textError1 = $opt['texterror1'];}
    if($opt['texterror2']!=''){$textError2 = $opt['texterror2'];}
}	

?>
<div class="helpIrGamificationGameTwo">
<div class='un-text-question'><?php echo $textStart; ?></div>
<div class="helpIrGamificationGameTwoOptions <?php if( $showImages=='no'){ ?>helpIrGamificationGameTwoOptionsOneLine<?php } ?>">
  
<?php
$i=1;
foreach ($options as $opt) {
	$title = $opt['title'];
	$image = $opt['image'];
	$status = $opt['status'];
	if($title!='' && $status!=''){
	?>
	<div class="helpIrGamificationGameTwoOption <?php if( $image==''){ ?> helpIrGamificationGameTwoOptionOneLine <?php } ?>  " data-correct="<?php echo $status;?>" >
    	 <?php if( $image!=''){ ?>   
	    <img src="<?php echo $image;?>" ><span>
	 	<?php } ?>         
	    <?php echo $title;?></span></div>
	<?php
	$i++;
    }	
}
?>  
  </div>
  <div class="game-message" id="gameFinalMessage"><center>
  <span class="textend"><?php echo $textEnd; ?></span>
  <span class="texterror1"><?php echo $textError1; ?></span>
  <span class="texterror2"><?php echo $textError2; ?></span>
  <button class="next-stage-btn" onclick="nextstagegame()" id="gameFinalBtn"><?php echo $textNext; ?></button></center></div>
</div>
<script>initHelpIrGamificationGameTwo();</script>

<?php }elseif($game_type=="game_3"){

 

foreach ($options as $opt) {
	if($opt['textstart']!=''){$textStart = $opt['textstart'];}
    if($opt['textend']!=''){$textEnd = $opt['textend'];}
    if($opt['textnext']!=''){$textNext = $opt['textnext'];}
    }	


?>
<div class="helpIrGamificationGameThree-game-message">
    <?php echo $textStart; ?>
</div>
<div id="helpIrGamificationGameThreePuzzle"></div>
<button id="helpIrGamificationGameThreeShuffle">تاسو کردن</button> 
<p id="helpIrGamificationGameThreeStatus"></p>
<center>
    <button class="next-stage-btn" onclick="nextstagegame()" id="gameFinalBtn" style="display:none;">
        <?php echo $textNext; ?>
    </button>
</center>

<script type="application/json" id="gameThreeData">
{
  "tiles": [
<?php
$i=1;
foreach ($options as $opt) {
    $contentv = $opt['imgpart'];
    if($contentv!='' ){
        if($i>1){ echo ','; }
        echo '"' . $contentv . '"';
        $i++;
    }   
}
?>  
  ],
  "messages": {
    "success": "<?php echo $textEnd; ?>"
  }
}
</script>

<script>
// Wrapping everything in an IIFE to avoid redeclaration issues
(function(){
    const gameData = JSON.parse(document.getElementById('gameThreeData').textContent);

    // Ensure GameThree exists (from your original script)
    if (typeof GameThree !== 'undefined' && GameThree.init) {
        GameThree.init(gameData);
    }
})();
</script>


<?php }elseif($game_type=="game_4"){ ?>

<script>
<?php
$i=1;
echo "const helpIrGamificationGameFourData = [";
foreach ($options as $opt) {
	if($opt['textstart']!=''){$textStart = $opt['textstart'];}
    if($opt['textend']!=''){$textEnd = $opt['textend'];}
    if($opt['textnext']!=''){$textNext = $opt['textnext'];}
	$image1 = $opt['image1'];
	$image2 = $opt['image2'];
	if($image1!='' && $image2!=''){
	?>
      { pair_id: <?php echo $i; ?>, image: "<?php echo $image1; ?>" },
      { pair_id: <?php echo $i; ?>, image: "<?php echo $image2; ?>" },

    <?php
	$i++;
    }	
}
echo "];";
?>

</script>
	
<div class="helpIrGamificationGameFour">
    <div class="game-container"></div>
	<div class="game-box-message">
    <div class="game-message">
        <?php echo $textStart; ?>
    </div>
	<button class="next-stage-btn" onclick="nextstagegame()" ><?php echo $textNext; ?></button>
    </div>
</div>
<script>
	const container = document.querySelector('.helpIrGamificationGameFour');
    if (container) {
        new HelpIrGamificationGameFour(container, {
            winMessage: "<?php echo $textEnd; ?>"
        });
    }
</script>



<?php }elseif($game_type=="game_5"){ ?>


<?php

foreach ($options as $opt) {
	if($opt['textstart']!=''){$textStart = $opt['textstart'];}
    if($opt['textend']!=''){$textEnd = $opt['textend'];}
    if($opt['textnext']!=''){$textNext = $opt['textnext'];}
    if($opt['backimg']!=''){$backImg = $opt['backimg'];}
    }	


?>



<div class="map-container helpIrGamificationGameFive-container" >
  <img src="<?php echo $backImg; ?>" alt="Map" class="helpIrGamificationGameFive-back" >
  <div id="helpIrGamificationGameFiveMessage" class="helpIrGamificationGameFive-message">
    <br><button id="helpIrGamificationGameFiveNextBtn" onclick="nextstagegame()"><?php echo $textNext; ?></button>
  </div>
</div>

<script>

      
if (!window.helpIrGamificationGameFiveInstance) {
  window.helpIrGamificationGameFiveInstance = new GamificationMapGameFive({
    containerSelector: ".helpIrGamificationGameFive-container",
    mapPoints: [
        
        
      <?php
$i=1;

foreach ($options as $opt) {
	$name = $opt['name'];
	$left = $opt['left'];
	$top = $opt['top'];
	$width = $opt['width'];
	$height = $opt['height'];
	$correct = $opt['correct'];
	$message = $opt['message'];
	$img = $opt['img'];
	if($name!='' && $img!=''){
	?>
      {
      id:<?php echo $i; ?>, name:"<?php echo $name; ?>", left:"<?php echo $left; ?>", top:"<?php echo $top; ?>", width:"<?php echo $width; ?>", height:"<?php echo $height; ?>",
      correct:<?php echo $correct; ?>, message:"<?php echo $message; ?>",
      img:"<?php echo $img; ?>"
      },

    <?php
	$i++;
    }	
}

?>        
        
    ],
    initialText: " <?php echo $textStart; ?>"
  });
} else {
  window.helpIrGamificationGameFiveInstance.init();
}
</script>

<?php }elseif($game_type=="game_6"){ ?>


<?php

foreach ($options as $opt) {
	if($opt['textstart']!=''){$textStart = $opt['textstart'];}
    if($opt['textend']!=''){$textEnd = $opt['textend'];}
    if($opt['textnext']!=''){$textNext = $opt['textnext'];}
    if($opt['textwrong']!=''){$textWrong = $opt['textwrong'];}
    }	


?>

<div class="helpIrGamificationGameSix-game-message">
    <?php echo $textStart; ?>
</div>
<div id="helpIrGamificationGameSix-board"></div>
<p id="helpIrGamificationGameSix-status"></p>
<center>
<button class="next-stage-btn" onclick="nextstagegame()" id="gameFinalBtn" style="display:none;">
 <?php echo $textNext; ?>
</button>
</center>

<script type="application/json" id="gameSixData">
{
  "pairs": [
<?php
$i=1;
foreach ($options as $opt) {
    $contentv = $opt['contentv'];
    $matchv = $opt['matchv'];
    $icon = $opt['iconv'];
    $contentc = $opt['contentc'];
    $matchc = $opt['matchc'];
    if($contentv!='' && $contentc!=''){
        if($i>1){ echo ','; }
        echo '{ "type": "sound", "content": "' . $contentv . '", "match": "' . $matchv . '", "icon": "' . $icon . '" },';
        echo '{ "type": "image", "content": "' . $contentc . '", "match": "' . $matchc . '" }';
        $i++;
    }   
}
?>
  ],
  "messages": {
    "success": "<?php echo $textEnd; ?>",
    "mismatch": "<?php echo $textWrong; ?>"
  }
}
</script>

<script>
(function(){
    // نام متغیر متفاوت و داخل IIFE
    const gameSixJson = JSON.parse(document.getElementById("gameSixData").textContent);

    if (typeof GameSix !== 'undefined' && GameSix.init) {
        GameSix.init({
            boardId: "helpIrGamificationGameSix-board",
            statusId: "helpIrGamificationGameSix-status",
            data: gameSixJson
        });
    }
})();
</script>


<?php }elseif($game_type=="game_8"){ ?>

<div class="helpIrGamificationGameSix-game-message">    
در مرحله معاینه بدنی، قد و وزن را توسط دو درجه زیر تعیین کنید. یادتان باشد وزن امین 24 کیلوگرم و قد او 120 سانتیمتر است.
</div>

<div class="helpIrGamificationGameEight-container">
  

  <label for="heightSlider">قد (cm): <span id="heightValue">110</span></label>
  <input type="range" id="heightSlider" min="110" max="140" value="110">
  <div id="heightMessage" class="helpIrGamificationGameEight-message"></div>

  <label for="weightSlider">وزن (kg): <span id="weightValue">20</span></label>
  <input type="range" id="weightSlider" min="20" max="30" value="20">
  <div id="weightMessage" class="helpIrGamificationGameEight-message"></div>

  <div id="finalMessage" class="helpIrGamificationGameEight-finalMessage"></div>
   <button class="next-stage-btn" onclick="nextstagegame()" id="nextStageBtn" style="display:none;">
ادامه دهید
</button>
</div>

<!-- JSON داخل صفحه -->
<script type="application/json" id="gameEightData">
{
  "correctHeight": 120,
  "correctWeight": 24
}
</script>

<script>
(function(){
    // متغیر داخل IIFE
    const gameEightConfig = JSON.parse(document.getElementById('gameEightData').textContent);
    if (typeof HelpIrGamificationGameEight !== 'undefined' && HelpIrGamificationGameEight.init) {
        HelpIrGamificationGameEight.init(gameEightConfig);
    }
})();
</script>



<?php } ?>




</div>



