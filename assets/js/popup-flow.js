const UNFlowCache = {}; // کش دسته‌ها و HTML مربوطه

jQuery(document).ready(function($) {
    let currentCategory = '';

    // ============================
    // Load Stage by ID
    // ============================
    function loadStage(stageId, status) {
        // لودینگ روی محتوا
        $('.un-flow-popup-content').addClass('loading');
        $('.un-flow-popup-content').append('<div class="un-flow-overlay"><div class="spinner"></div></div>');

        $.post(UNFlow.ajax_url, {
            action: 'get_un_stage_by_id',
            nonce: UNFlow.nonce,
            stage_id: stageId,
            status: status
        }, function(response) {
            $('.un-flow-popup-content').removeClass('loading');
            $('.un-flow-overlay').remove();

            if (response.success) {
                // اگر پاسخ شامل html و next_stage باشد
                const html = response.data.html ? response.data.html : response.data;
                const nextStage = response.data.next_stage ? response.data.next_stage : null;

                $('.un-flow-popup-content').html(html);

                // دکمه next stage را آپدیت کن
                if (nextStage) {
                    $('.un-stage-next-button').data('next', nextStage).show();
                } else {
                    $('.un-stage-next-button').hide();
                }

            } else {
                $('.un-flow-popup-content').html('<p>' + unFlowMessages.error_loading_stage + '</p>');
                $('.un-stage-next-button').hide();
            }
        });
    }

    // ============================
    // Fetch Flows by Category
    // ============================
    function fetchFlowsByCategory(category) {
        if (!category) return fetchCategories();

        if (UNFlowCache[category]) {
            $('.un-flow-popup-content').html(UNFlowCache[category]);
            return;
        }

        $('.un-flow-popup-content').html('<div class="un-flow-loading"><div class="spinner"></div></div>');

        $.post(UNFlow.ajax_url, {
            action: 'get_un_flows_by_category',
            nonce: UNFlow.nonce,
            category: category
        }, function(response) {
            if (response.success) {
                UNFlowCache[category] = response.data;
                $('.un-flow-popup-content').html(response.data);
            } else {
                $('.un-flow-popup-content').html('<p>' + unFlowMessages.error_loading_flows + '</p>');
            }
        });
    }

    // ============================
    // Fetch All Categories
    // ============================
    function fetchCategories() {
        const cacheKey = 'all_categories';

        if (UNFlowCache[cacheKey]) {
            $('.un-flow-popup-content').html(UNFlowCache[cacheKey]);
            return;
        }

        $('.un-flow-popup-content').html('<div class="un-flow-loading"><div class="spinner"></div></div>');

        $.post(UNFlow.ajax_url, {
            action: 'get_un_flows_by_category',
            nonce: UNFlow.nonce,
            category: ''
        }, function(response) {
            if (response.success) {
                UNFlowCache[cacheKey] = response.data;
                $('.un-flow-popup-content').html(response.data);
            } else {
                $('.un-flow-popup-content').html('<p>' + unFlowMessages.error_loading_flows + '</p>');
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
    $(document).on('click', '.un-flow-button', function() {
		
	
	// Check if new load page
    if ($('.un-flow-popup-content').is(':empty')) {
		
		$('.un-flow-popup-content').html('<div class="un-flow-loading"><div class="spinner"></div></div>');
		
		// Set Cookie for First user
  		  let exists = getCookie('unhcr_help_ir_gamification_user');
          if (!exists) {
             setStartCookie();
          }
	
        $('.un-flow-popup-overflow').fadeIn();
        $('#un-flow-popup').fadeIn();
		
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
	
        
        $('.un-flow-popup-overflow').fadeIn();
		$('#un-flow-popup').fadeIn();
	
	}	
		
    });

    // ============================
    // Click on Category Item
    // ============================
    $(document).on('click', '.un-flow-category-item', function() {
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
        $('.un-flow-popup-content').html('<div class="un-flow-loading"><div class="spinner"></div></div>');
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
        $('.un-flow-popup-content').html('<div class="un-flow-loading"><div class="spinner"></div></div>');
        loadStage(next);
    });

    // ============================
    // Quiz Option Click
    // ============================
    $(document).on('click', '.un-quiz-option', function() {
        const status = $(this).data('status');
        const container = $(this).closest('.un-stage');
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
		
        setTimeout(() => loadStage(nextStage), 1200);
    });

    // ============================
    // Restart Flow
    // ============================
    $(document).on('click', '.un-stage-restart-button', function() {
        if (window.currentFlow && window.currentFlow.firstStageId) {
            loadStage(window.currentFlow.firstStageId);
        } else {
            console.warn(unFlowMessages.restart_warning);
        }
    });

    // ============================
    // Close Stage
    // ============================
    $(document).on('click', '.un-stage-close-button', function() {
        $('.un-stage-close-button, .un-stage-restart-button').fadeOut();
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
    $(document).on('click', '.un-flow-popup-close', function() {
		
	// find & stop video
    const video = $('.un-stage-type-video video')[0];
    if (video) {
        video.pause(); // pause video
    }
		
        $('#un-flow-popup').fadeOut();
        $('.un-flow-popup-overflow').fadeOut();
    });

    // ============================
    // Back to Categories
    // ============================
    $(document).on('click', '.un-back-to-categories-button', function() {
        $('.un-stage-close-button, .un-stage-restart-button').fadeOut();
        currentCategory = '';
        fetchCategories();
		deleteStepCookie();
    });
});
