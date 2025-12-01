// Check if gtag is defined, which means GA4 is loaded
if (typeof gtag === "undefined") {
    console.error("Google Analytics (gtag) is not loaded. Please check GA setup.");
} else {
    console.log("Google Analytics (gtag) is connected.");
}

// تابع ارسال رویداد به Google Analytics
function sendGAEvent(eventName, params = {}) {
    if (typeof gtag === "function") {
        gtag('event', eventName, params);
        console.log("Event sent:", eventName, params); // نمایش در کنسول برای دیباگ
    } else {
        console.warn("gtag not loaded!");
    }
}


jQuery(document).ready(function($) {
  


// ثبت رویداد کلیک روی دکمه Start Flow
$(document).on('click', '.un-flow-button', function() {
    sendGAEvent('unhcr_help_ir_gamification_start_flow', {
        category: $(this).data('category') || 'none'
    });
});

// ثبت رویداد کلیک روی گزینه‌های سن
$(document).on('click', '#question-age .un-quiz-option', function() {
    sendGAEvent('unhcr_help_ir_gamification_age_option', {
        option: $(this).data('value')
    });
});

// ثبت رویداد کلیک روی گزینه جنسیت
$(document).on('click', '#question-gender .un-quiz-option', function() {
    sendGAEvent('unhcr_help_ir_gamification_gender_option', {
        option: $(this).data('value')
    });
});

// ثبت رویداد کلیک روی next stage button
$(document).on('click', '.un-stage-next-button', function() {
    const next = $(this).data('next') || 'unknown';
    sendGAEvent('unhcr_help_ir_gamification_next_stage', {
        next_stage: next
    });
});

// ثبت رویداد کلیک روی Back to Categories
$(document).on('click', '.un-back-to-categories-button', function() {
    sendGAEvent('unhcr_help_ir_gamification_back_to_categories');
});

// ثبت رویداد وقتی ویدیو بسته می‌شود
$(document).on('click', '.un-flow-popup-close', function() {
    sendGAEvent('unhcr_help_ir_gamification_close_flow_popup');
});

});