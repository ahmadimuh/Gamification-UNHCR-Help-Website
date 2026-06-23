const UNFlowCache = {}; // کش دسته‌ها و HTML مربوطه

jQuery(document).ready(function($) {
	
//برای پرسش سوالات سن و جنسیت

    // تابع برای راه‌اندازی سوالات گیمیفیکیشن
    function initializeQuiz() {
        
        // وقتی محتوای stage به صورت داینامیک اضافه شد، این هندلرها کار می‌کنند
        $(document)
    .off('click', '#question-age .un-quiz-option')
    .on('click', '#question-age .un-quiz-option', function(e){
            e.preventDefault();
            var $ageOpt = $(this);
            var selectedAge = $ageOpt.data('value') || $ageOpt.attr('data-value');

            // افکت و نمایش سؤال دوم
            $('#question-age').css('opacity', 0);
            setTimeout(function(){
                $('#question-age').hide();
                $('#question-gender').show().css('opacity', 1);
                // ذخیره موقت (اختیاری)
                try { localStorage.setItem('un_user_age', selectedAge); } catch(err) {}
                // نگهداری در data برای استفاده بعد
                $('#question-gender').data('selectedAge', selectedAge);
            }, 200);
        });

        // بعد از انتخاب جنسیت
        $(document)
       .off('click', '#question-gender .un-quiz-option')
       .on('click', '#question-gender .un-quiz-option', function(e){
            e.preventDefault();
            var $genderOpt = $(this);
            var selectedGender = $genderOpt.data('value') || $genderOpt.attr('data-value');

            // بازیابی سن انتخاب شده (از data یا localStorage)
            var selectedAge = $('#question-gender').data('selectedAge') || localStorage.getItem('un_user_age') || null;

            // ذخیره محلی
            try {
                localStorage.setItem('un_user_gender', selectedGender);
                if (selectedAge) localStorage.setItem('un_user_age', selectedAge);
            } catch(err){}

            // (اختیاری) ارسال به سرور برای ذخیره در user_meta
            // $.post(UNFlow.ajax_url, {
            //     action: 'save_user_age_gender',
            //     nonce: UNFlow.nonce,
            //     age: selectedAge,
            //     gender: selectedGender
            // }, function(resp){ console.log('saved age/gender', resp); });

            // تلاش برای پیدا کردن دکمه مرحله بعد و شبیه‌سازی کلیک روی آن
            var $nextBtn = $('.un-stage-next-button[data-next]').first();

            if ($nextBtn && $nextBtn.length) {
                // اگر دکمه وجود دارد، کلیکش را شبیه‌سازی کن تا handler موجود اجرا شود
                $nextBtn.trigger('click');
                return;
            }

            // اگر دکمه پیدا نشد، تلاش برای خواندن next از container data (مثلاً data-correct)
            var $container = $('.un-stage').first();
            var nextStage = $container.data('correct') || $container.data('next') || $container.attr('data-correct') || $container.attr('data-next');

            if (nextStage) {
                // مشابه کدی که در پروژه شما برای بارگزاری next stage استفاده شده
                $('.help-ir-gamification-popup-content').append('<p>' + (unFlowMessages ? unFlowMessages.next_stage_loading : 'Loading...') + '</p>');
                $.post(UNFlow.ajax_url, {
                    action: 'get_un_stage_by_id',
                    nonce: UNFlow.nonce,
                    stage_id: nextStage
                }, function(response){
                    if (response.success) {
                        $('.help-ir-gamification-popup-content').html(response.data);
                    } else {
                        $('.help-ir-gamification-popup-content').html('<p>' + (unFlowMessages ? unFlowMessages.error_next_stage : 'Error loading next stage') + '</p>');
                    }
                });
                return;
            }

            // اگر هیچ چیزی پیدا نشد، لاگ کن
            console.error('Could not find next stage button or nextStage ID. Please ensure there is a .un-stage-next-button[data-next] or .un-stage[data-correct|data-next] present.');
        });
    }

    // تابع initializeQuiz را اجرا کن
    $(document).ready(function(){
        initializeQuiz();
    });	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    let currentCategory = '';
    
    
// ============================
// Audio Manager
// ============================

let currentStageAudio = null;
let audioEnabled = localStorage.getItem('un_audio_enabled') !== 'false';
let currentAudioUrl = null;
$('.un-stage-audio-button').hide();
if (audioEnabled) {
    $('.un-stage-audio-button').removeClass('muted');
} else {
    $('.un-stage-audio-button').addClass('muted');
}


function stopStageAudio() {

    if (currentStageAudio) {

        currentStageAudio.pause();
        currentStageAudio.currentTime = 0;
        currentStageAudio = null;
    }
}

function playStageAudio(audioUrl) {

    stopStageAudio();

    if (!audioEnabled) {
        return;
    }

    if (!audioUrl) {
        return;
    }

    currentStageAudio = new Audio(audioUrl);

    currentStageAudio.play().catch(function(error) {
        console.log('Audio autoplay blocked:', error);
    });
}
    
$(document).on('click', '.un-stage-audio-button', function() {

    audioEnabled = !audioEnabled;

    localStorage.setItem(
        'un_audio_enabled',
        audioEnabled
    );

    if (!audioEnabled) {

        stopStageAudio();

        $(this).addClass('muted');

    } else {

        $(this).removeClass('muted');

        // پخش صدای همین مرحله
        if (currentAudioUrl) {
            playStageAudio(currentAudioUrl);
        }
    }

});
function updateAudioButton(audioUrl) {

    if (!audioUrl) {
        $('.un-stage-audio-button').hide();
        return;
    }

    $('.un-stage-audio-button').show();

    if (audioEnabled) {
        $('.un-stage-audio-button').removeClass('muted');
    } else {
        $('.un-stage-audio-button').addClass('muted');
    }
}
function hideAudioButton() {

    stopStageAudio();

    currentAudioUrl = null;

    $('.un-stage-audio-button').hide();
}
    // ============================
    // Load Stage by ID
    // ============================
    function loadStage(stageId, status) {
        // لودینگ روی محتوا
        $('.help-ir-gamification-loading').css('display', 'flex');

    $('.help-ir-gamification-popup-content').addClass('loading');

    $('.un-stage-back-button').prop('disabled', true);
    $('.un-stage-next-button').prop('disabled', true);
    $('.un-stage-restart-button').prop('disabled', true);

    $.post(UNFlow.ajax_url, {
        action: 'get_un_stage_by_id',
        nonce: UNFlow.nonce,
        stage_id: stageId,
        status: status
    }, function(response) {

            $('.help-ir-gamification-loading').hide();
            $('.help-ir-gamification-popup-content').removeClass('loading');
            $('.help-ir-gamification-overlay').remove();

            if (response.success) {
                // اگر پاسخ شامل html و next_stage باشد
                const html = response.data.html ? response.data.html : response.data;
                const nextStage = response.data.next_stage ? response.data.next_stage : null;
                
                const prevStage = response.data.prev_stage ? response.data.prev_stage : null;
                
                const typeStage = response.data.type_stage ? response.data.type_stage : null;
                
                const nameStage = response.data.name_stage ? response.data.name_stage : null;
                
                const catStage = response.data.cat_stage ? response.data.cat_stage : null;
                
                const audioUrl = response.data.audio_url ? response.data.audio_url : null;
                
               $('.help-ir-gamification-popup-content').html(html);

                currentAudioUrl = audioUrl;

                updateAudioButton(audioUrl);

                playStageAudio(audioUrl);
                
              
                
                UNDataLayer.pageView({
                         stageId: stageId,
                         category: catStage,
                         title: nameStage,
                         type: typeStage
                });

                // دکمه next stage را آپدیت کن
                if (nextStage) {
                    $('.un-stage-next-button').data('next', nextStage);
                }
                if (prevStage) {
                    $('.un-stage-back-button').data('back', prevStage);
                    $('.un-stage-back-button').show();
                } else {
                    $('.un-stage-back-button').hide();
                }
                if (nextStage && (typeStage=="text" || typeStage=="video")) {
                    $('.un-stage-next-button').show();
                } else {
                    $('.un-stage-next-button').hide();
                }
				
				//********gamecall
				const gameContainer = document.querySelector('.game-container');
                  if (gameContainer) {
                      
					  
				  }
				//********surveycall
				initializeQuiz();
				
				
				
				
                $('.un-stage-back-button').prop('disabled', false);
                $('.un-stage-next-button').prop('disabled', false);
                $('.un-stage-restart-button').prop('disabled', false);
        

            } else {
                $('.help-ir-gamification-popup-content').html('<p>' + unFlowMessages.error_loading_stage + '</p>');
                $('.un-stage-next-button').hide();
                $('.un-stage-back-button').hide();
            }
        });
    }

    // ============================
    // Fetch Flows by Category
    // ============================
    function fetchFlowsByCategory(category) {

    hideAudioButton();

    if (!category) return fetchCategories();

    $('.help-ir-gamification-loading').css('display', 'flex');

    $.post(UNFlow.ajax_url, {
        action: 'get_un_flows_by_category',
        nonce: UNFlow.nonce,
        category: category
    }, function(response) {

        $('.help-ir-gamification-loading').hide();

        if (response.success) {
            UNFlowCache[category] = response.data;
            $('.help-ir-gamification-popup-content').html(response.data);
        } else {
            $('.help-ir-gamification-popup-content')
                .html('<p>' + unFlowMessages.error_loading_flows + '</p>');
        }
    });
}

    // ============================
    // Fetch All Categories
    // ============================
    function fetchCategories() {
        const cacheKey = 'all_categories';
        hideAudioButton();
        if (UNFlowCache[cacheKey]) {
            $('.help-ir-gamification-popup-content').html(UNFlowCache[cacheKey]);
            return;
        }

        $('.help-ir-gamification-loading').css('display', 'flex');

        $.post(UNFlow.ajax_url, {
            action: 'get_un_flows_by_category',
            nonce: UNFlow.nonce,
            category: ''
        }, function(response) {
              $('.help-ir-gamification-loading').hide();
            if (response.success) {
                UNFlowCache[cacheKey] = response.data;
                $('.help-ir-gamification-popup-content').html(response.data);
            } else {
                $('.help-ir-gamification-popup-content').html('<p>' + unFlowMessages.error_loading_flows + '</p>');
            }
        });
    }
	
    // ============================
    // get Cookie 
    // ============================
function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
    return null;
}

	
	
	
	
    // ============================
    // set Cookie 
    // ============================	
	
function setStartCookie() {
    document.cookie = "unhcr_help_ir_gamification_user=true; path=/; max-age=" + (60 * 60 * 24 * 30);
}	
function setStepCookie(step) {
    document.cookie = "unhcr_help_ir_gamification_step=" + step + "; path=/; max-age=" + (60 * 60 * 24 * 30);
}	
function deleteStepCookie() {
    document.cookie = "unhcr_help_ir_gamification_step=; path=/; max-age=0";
}
function setSurveyCookie() {	
	document.cookie = "unhcr_help_ir_gamification_info=true; path=/; max-age=" + (60 * 60 * 24 * 30);	
}	
	
	
	
	
    // ============================
    // Open Popup (category or all)
    // ============================
    $(document).on('click', '.help-ir-gamification-button', function() {
		
	
	// Check if new load page
    if ($('.help-ir-gamification-popup-content').is(':empty')) {
		
	  $('.help-ir-gamification-loading').css('display', 'flex');
		
		// Set Cookie for First user
  		  let exists = getCookie('unhcr_help_ir_gamification_user');
          if (!exists) {
             setStartCookie();
          }
	
        $('.help-ir-gamification-popup-overflow').fadeIn();
        $('#help-ir-gamification-popup').fadeIn();
		
        const category = $(this).data('category') || '';
        currentCategory = category;
		
	    // find last Step
        let step = getCookie('unhcr_help_ir_gamification_step');
		
	    // go last Step
        if (step) {
        loadStage(parseInt(step));
        return; 
	    }	
		
		// load category	
		if (category) {
            fetchFlowsByCategory(category);
        } else {
            fetchCategories();
        }
	}else{
	
        
        $('.help-ir-gamification-popup-overflow').fadeIn();
		$('#help-ir-gamification-popup').fadeIn();
	
	}	
		
    });

    // ============================
    // Click on Category Item
    // ============================
    $(document).on('click', '.help-ir-gamification-category-item', function() {
        const categorySlug = $(this).data('slug');
        if (!categorySlug) return;
        currentCategory = categorySlug;
        fetchFlowsByCategory(categorySlug);
    });

    // ============================
    // Start Flow
    // ============================
    $(document).on('click', '.start-flow-button', function() {
        $('.un-stage-close-button, .un-stage-restart-button').fadeIn();
        const stageId = $(this).data('stage');
        window.currentFlow = { firstStageId: stageId };
		// set step cookie
   		setStepCookie(stageId);
        $('.help-ir-gamification-loading').css('display', 'flex');
        loadStage(stageId, 'first');
    });

    // ============================
    // Next Stage Button
    // ============================
    $(document).on('click', '.un-stage-next-button', function() {
        const next = $(this).data('next');
        if (!next) return;
		// set step cookie
   		setStepCookie(next);
        $('.help-ir-gamification-loading').css('display', 'flex');
        stopStageAudio();
        loadStage(next);
    });
    
    // ============================
    // show next btn 
    // ============================	
	
    function showNextBTN() { 
       $('.un-stage-next-button').show();
    }
    
    // ============================
    // BACK Stage Button
    // ============================
    $(document).on('click', '.un-stage-back-button', function() {
        const back = $(this).data('back');
        if (!back) return;
		// set step cookie
   		setStepCookie(back);
        $('.help-ir-gamification-loading').css('display', 'flex');
        stopStageAudio();
        loadStage(back);
    });

    // ============================
    // Quiz Option Click
    // ============================
    $(document).on('click', '.un-quiz-option', function() {
        const status = $(this).data('status');
        const container = $(this).closest('.un-stage');
        
        const questionText = $('.un-quiz-question:visible').text();
        const questionAnswer = $(this).text();
        const stageId = container.data('stage-id');
        const category = container.data('category');
        
        UNDataLayer.quizClick({
        stageId: stageId,
        category: category,
        question: questionText,
        answer: questionAnswer
        });
        
		$(this).find('.un-quiz-result').fadeIn();
        const nextMap = {
            correct: container.data('correct'),
            wrong: container.data('wrong'),
            neutral: container.data('neutral')
        };
        const nextStage = nextMap[status];
		if ($(this).closest('#question-gender').length) {
             setSurveyCookie();
        }
        if (!nextStage) {
            $(this).addClass('wrong');
            return;
        }

        $(this).addClass('correct');

        clearAllTimers(); 

        $('.un-stage-next-button').show();

        nextStageTimeout = setTimeout(() => {
         stopStageAudio();
         loadStage(nextStage);
        }, 10000);
        
    });

    // ============================
    // Restart Flow
    // ============================
    $(document).on('click', '.un-stage-restart-button', function() {
        if (window.currentFlow && window.currentFlow.firstStageId) {
            stopStageAudio();
            loadStage(window.currentFlow.firstStageId);
        } else {
            console.warn(unFlowMessages.restart_warning);
        }
    });

    // ============================
    // Close Stage
    // ============================
    $(document).on('click', '.un-stage-close-button', function() {
        hideAudioButton();
        $('.un-stage-close-button, .un-stage-restart-button, .un-stage-back-button, .un-stage-next-button').fadeOut();
        if (currentCategory) {
            fetchFlowsByCategory(currentCategory);
        } else {
            fetchCategories();
        }
		deleteStepCookie();
    });

    // ============================
    // Close Popup
    // ============================
    $(document).on('click', '.help-ir-gamification-popup-close', function() {
        
    hideAudioButton();
		
	// find & stop video
    const video = $('.un-stage-type-video video')[0];
    if (video) {
        video.pause(); // pause video
    }
		
        $('#help-ir-gamification-popup').fadeOut();
        $('.help-ir-gamification-popup-overflow').fadeOut();
    });

    // ============================
    // Back to Categories
    // ============================
    $(document).on('click', '.un-back-to-categories-button', function() {
        hideAudioButton();
        $('.un-stage-close-button, .un-stage-restart-button, .un-stage-back-button, .un-stage-next-button').fadeOut();
        currentCategory = '';
        fetchCategories();
		deleteStepCookie();
    });


//show next level blink after 30 Second
//click next-level-alert



     let alertTimeout, highlightTimeout, nextStageTimeout;
    
    function clearAllTimers() {
    clearTimeout(alertTimeout);
    clearTimeout(highlightTimeout);
    clearTimeout(nextStageTimeout);
    }
    
    
   function showNextButtonWithDelay() {

    clearAllTimers(); 

    $('.next-level-alert').hide();
    $('.un-stage-next-button').removeClass('un-stage-next-button-alert');

    alertTimeout = setTimeout(function() {
        $('.next-level-alert').fadeIn().off('click').on('click', function() {
            var nextButton = $('.un-stage-next-button');
            if (nextButton.length) {
                nextButton.click();  
            }
        });
    }, 30000);  

    highlightTimeout = setTimeout(function() {
        var nextButton = $('.un-stage-next-button');
        if (nextButton.length) {
            nextButton.addClass('un-stage-next-button-alert');  
        }
    }, 15000);  
}

    // اجرای اولیه
    showNextButtonWithDelay();

    // بعد از AJAX Loading
    $(document).ajaxComplete(function() {
        showNextButtonWithDelay();
    });

});


