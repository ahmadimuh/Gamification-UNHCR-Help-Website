<?php
// شورت‌کد برای دکمه بازکننده پاپ‌آپ جریان

// Shortcode for opening flow popup button
// [un_flow_button label="Start Flow" category="school"]
add_shortcode('un_flow_button', function($atts) {
    $atts = shortcode_atts([
        'label' => __('Start Flow', 'un-gamification'),
        'category' => ''
    ], $atts);

    $label = esc_html($atts['label']);
    $cat = esc_attr($atts['category']);

return "<button class='help-ir-gamification-button' data-category='$cat'>$label</button>";	
	
	
});

add_action('wp_footer', function() {
    ?>
<div class="help-ir-gamification-popup-overflow" style="display:none;"></div>
<div id="help-ir-gamification-popup" class="help-ir-gamification-popup" style="display:none;">
         <div class="help-ir-gamification-popup-inner">
            <div class="help-ir-gamification-popup-header">
                <span class="help-ir-gamification-popup-title"><?php _e('UNHCR Gamification', 'un-gamification'); ?></span>
                <button class="help-ir-gamification-popup-close">×</button>
            </div>
            <div class="help-ir-gamification-popup-body">
            <div class="help-ir-gamification-popup-content"></div>
            <div class="help-ir-gamification-loading"><div class="spinner"></di></div></div>
            </div>
            <div class="help-ir-gamification-popup-footer">

<svg width="25px" height="25px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="un-back-to-categories-button" style="padding: 0px;background: #ffffff00;">
<path d="M19 3.32001H16C14.8954 3.32001 14 4.21544 14 5.32001V8.32001C14 9.42458 14.8954 10.32 16 10.32H19C20.1046 10.32 21 9.42458 21 8.32001V5.32001C21 4.21544 20.1046 3.32001 19 3.32001Z" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8 3.32001H5C3.89543 3.32001 3 4.21544 3 5.32001V8.32001C3 9.42458 3.89543 10.32 5 10.32H8C9.10457 10.32 10 9.42458 10 8.32001V5.32001C10 4.21544 9.10457 3.32001 8 3.32001Z" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M19 14.32H16C14.8954 14.32 14 15.2154 14 16.32V19.32C14 20.4246 14.8954 21.32 16 21.32H19C20.1046 21.32 21 20.4246 21 19.32V16.32C21 15.2154 20.1046 14.32 19 14.32Z" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8 14.32H5C3.89543 14.32 3 15.2154 3 16.32V19.32C3 20.4246 3.89543 21.32 5 21.32H8C9.10457 21.32 10 20.4246 10 19.32V16.32C10 15.2154 9.10457 14.32 8 14.32Z" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
				
<svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="un-stage-close-button" style="display:none;padding: 0px;background: #ffffff00;">
<path d="M4 6H20M4 12H20M4 18H20" stroke="#0072bd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

<svg width="25px" height="25px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="un-stage-restart-button" style="display:none;padding: 0px;background: #ffffff00;">
<path d="M7.1998 10.8799L3.9998 14.0799L0.799805 10.8799" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M17.72 6.77007C16.6086 5.63347 15.1839 4.85371 13.6275 4.53032C12.0711 4.20693 10.4536 4.35459 8.98145 4.95439C7.5093 5.5542 6.24924 6.57899 5.362 7.898C4.47476 9.21701 4.0006 10.7703 4 12.3599V14.0901" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M16.7998 13.96L19.9998 10.75L23.1998 13.96" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6.28027 18.0801C7.39163 19.2167 8.8164 19.9962 10.3728 20.3196C11.9292 20.643 13.5467 20.4956 15.0188 19.8958C16.491 19.2959 17.751 18.2712 18.6383 16.9521C19.5255 15.6331 19.9997 14.0796 20.0003 12.49V10.76" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>				

<svg width="25px" transform="rotate(180 0 0)" height="25px" viewBox="0 0 24 24" fill="none" class="un-stage-back-button un-stage-back-button-alert " data-back="" xmlns="http://www.w3.org/2000/svg" style="padding: 0px;background: #ffffff00;display: none;">
<path d="M3.76001 7.22005V16.7901C3.76001 18.7501 5.89 19.98 7.59 19L11.74 16.61L15.89 14.21C17.59 13.23 17.59 10.78 15.89 9.80004L11.74 7.40004L7.59 5.01006C5.89 4.03006 3.76001 5.25005 3.76001 7.22005Z" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M20.24 18.1801V5.82007" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
				
<svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" class="un-stage-next-button"  data-next="" xmlns="http://www.w3.org/2000/svg" style="padding: 0px;background: #ffffff00;display: none;">
<path d="M3.76001 7.22005V16.7901C3.76001 18.7501 5.89 19.98 7.59 19L11.74 16.61L15.89 14.21C17.59 13.23 17.59 10.78 15.89 9.80004L11.74 7.40004L7.59 5.01006C5.89 4.03006 3.76001 5.25005 3.76001 7.22005Z" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M20.24 18.1801V5.82007" stroke="#0072bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>	


<svg version="1.0" xmlns="http://www.w3.org/2000/svg"
 width="25px" height="25px" viewBox="0 0 512.000000 512.000000"
 class="un-stage-audio-button"
 preserveAspectRatio="xMidYMid meet" >

<g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
fill="#0072bd" stroke="none">
<path d="M2635 4420 c-73 -13 -200 -80 -306 -162 -51 -39 -228 -204 -394 -367
-201 -198 -320 -307 -359 -331 -104 -61 -165 -71 -501 -81 -165 -4 -321 -13
-346 -18 -223 -48 -372 -197 -435 -436 -17 -62 -19 -112 -19 -465 0 -442 2
-462 73 -610 41 -88 136 -189 219 -233 107 -57 180 -68 508 -77 336 -9 396
-19 501 -80 40 -24 155 -130 354 -325 318 -313 432 -411 552 -475 265 -141
510 -42 602 245 54 170 66 444 66 1555 0 1111 -12 1385 -66 1555 -71 221 -246
340 -449 305z m102 -325 c14 -10 30 -41 42 -78 43 -140 46 -237 46 -1457 0
-1220 -3 -1317 -46 -1457 -13 -42 -28 -68 -45 -79 -22 -15 -28 -15 -67 0 -81
31 -224 153 -517 442 -302 297 -367 351 -498 411 -128 59 -218 73 -557 82
-191 6 -313 13 -335 21 -85 31 -138 102 -159 215 -14 78 -14 652 0 730 21 113
74 184 159 215 22 8 144 15 335 21 339 9 429 23 557 82 131 60 196 114 498
411 285 282 421 399 505 437 49 23 55 23 82 4z"/>
<path class="audio-wave" d="M4217 3776 c-22 -8 -50 -24 -63 -37 -55 -52 -58 -155 -5 -217 211
-251 322 -477 366 -747 19 -116 19 -315 0 -433 -39 -242 -157 -494 -320 -686
-70 -84 -85 -110 -85 -159 0 -107 91 -180 195 -157 31 7 54 24 100 73 197 210
356 526 417 830 33 162 33 472 0 634 -46 231 -147 465 -281 659 -75 109 -182
230 -209 238 -49 14 -81 14 -115 2z"/>
<path class="audio-wave" d="M3570 3349 c-60 -24 -100 -85 -100 -152 0 -35 10 -59 54 -129 62 -97
96 -172 128 -285 32 -113 32 -333 0 -446 -32 -113 -66 -188 -128 -285 -45 -72
-54 -93 -54 -132 0 -116 116 -189 222 -142 37 16 55 35 102 104 141 213 201
414 201 678 0 264 -66 483 -207 686 -70 102 -139 134 -218 103z"/>
</g>
</svg>



				
            </div>
        </div>
    </div>
    <?php
});
