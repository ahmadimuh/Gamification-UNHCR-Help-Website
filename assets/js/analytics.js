// ==============================
// UN DataLayer Helper
// ==============================

(function (window) {

    // اطمینان از وجود dataLayer
    window.dataLayer = window.dataLayer || [];

    // ------------------------------
    // Private Helper
    // ------------------------------
    function push(data) {
        window.dataLayer.push(data);
        // برای دیباگ (اختیاری)
        // console.log("DataLayer:", data);
    }

    // ------------------------------
    // Public API
    // ------------------------------
    const UNDataLayer = {

        // ==========================
        // Virtual Page View (Popup)
        // ==========================
        pageView: function ({
            stageId,
            category = "general",
            title = "",
            type = "Popup page",
            language = "FA"
        }) {

            push({
                event: "virtual_page_view",
                load_type: "Modal page load",
                module_type: "Modal / popup",

                virtual_page_path: `/${category}/${stageId}/`,
                virtual_page_location: window.location.origin + `/${category}/${stageId}/`,
                virtual_page_title: title || `Stage ${stageId}`,

                content_language: language,
                content_id: stageId,
                content_group: category,
                content_type: type,
                content_name: title || `Stage ${stageId}`
            });
        },

        // ==========================
        // Quiz Click
        // ==========================
        quizClick: function ({
            stageId,
            category,
            question,
            answer,
            language = "FA"
        }) {

            push({
                event: "vitual_modal_questionaire_click",

                content_language: language,
                content_id: stageId,
                content_group: category,
                content_type: "Questionnaire",

                content_ask: question,
                content_choice: answer
            });
        },

        // ==========================
        // Video Play
        // ==========================
        videoPlay: function ({
            stageId,
            category,
            language = "FA"
        }) {

            push({
                event: "vitual_modal_video_play",

                content_language: language,
                content_id: stageId,
                content_group: category,
                content_type: "Video"
            });
        },

        // ==========================
        // Generic Event (برای آینده)
        // ==========================
        custom: function (data) {
            push(data);
        }

    };

    // Export به window
    window.UNDataLayer = UNDataLayer;

})(window);