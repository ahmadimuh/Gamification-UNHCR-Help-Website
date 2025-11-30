<div class="un-stage un-stage-type-quiz" data-correct="<?php echo $stage_id;?>" data-wrong="0" data-neutral="0">
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
		
<div id="un-stage-dialogue" class="dialogue-scene dialogue-quiz typing-effect" style="background-image: url('<?php echo $bg_image; ?>')">

    <!-- سؤال ۱: سن -->
    <div class="un-question-block" id="question-age">
        <div class="un-quiz-question">شما در چه رنج سنی قرار دارید؟</div>
        <ul class="un-quiz-options">
            <li class="un-quiz-option" data-value="under_10">🔵 کمتر از 10 سال</li>
            <li class="un-quiz-option" data-value="10_20">🔵 بین 10 تا 20 سال</li>
            <li class="un-quiz-option" data-value="20_30">🔵 بین 20 تا 30 سال</li>
            <li class="un-quiz-option" data-value="30_40">🔵 بین 30 تا 40 سال</li>
            <li class="un-quiz-option" data-value="over_40">🔵 بالای 40 سال</li>
        </ul>
    </div>

    <!-- سؤال ۲: جنسیت -->
    <div class="un-question-block" id="question-gender" style="display: none;">
        <div class="un-quiz-question">جنسیت شما چیست؟</div>
        <ul class="un-quiz-options">
            <li class="un-quiz-option" data-value="female">🔵 زن</li>
            <li class="un-quiz-option" data-value="male">🔵 مرد</li>
        </ul>
    </div>

</div>
</div>

<script>
// اضافه کن به فایل js اصلی (از jQuery delegation استفاده می‌کنیم)
(function($){
    // وقتی محتوای stage به صورت داینامیک اضافه شد، این هندلرها کار می‌کنند
    $(document).on('click', '#question-age .un-quiz-option', function(e){
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
    $(document).on('click', '#question-gender .un-quiz-option', function(e){
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
            $('.un-flow-popup-content').html('<p>' + (unFlowMessages ? unFlowMessages.next_stage_loading : 'Loading...') + '</p>');
            $.post(UNFlow.ajax_url, {
                action: 'get_un_stage_by_id',
                nonce: UNFlow.nonce,
                stage_id: nextStage
            }, function(response){
                if (response.success) {
                    $('.un-flow-popup-content').html(response.data);
                } else {
                    $('.un-flow-popup-content').html('<p>' + (unFlowMessages ? unFlowMessages.error_next_stage : 'Error loading next stage') + '</p>');
                }
            });
            return;
        }

        // اگر هیچ چیزی پیدا نشد، لاگ کن
        console.error('Could not find next stage button or nextStage ID. Please ensure there is a .un-stage-next-button[data-next] or .un-stage[data-correct|data-next] present.');
    });

})(jQuery);

</script>
