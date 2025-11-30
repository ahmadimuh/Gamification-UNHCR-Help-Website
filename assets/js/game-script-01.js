// استفاده از یک namespace خاص برای بازی
var GameNamespace = {
    score: 0,
    maxScore: 10,
    
    init: function() {
        console.log("Game initialized");
        this.setupEvents();
    },

    setupEvents: function() {
        // ثبت رویدادهای بازی
        document.querySelector('.game-button').addEventListener('click', this.startGame.bind(this));
    },

    startGame: function() {
        this.score = 0;
        this.updateMessage("Game Started! Score: 0");
        this.gameLoop();
    },

    gameLoop: function() {
        if (this.score < this.maxScore) {
            this.score++;
            this.updateMessage("Score: " + this.score);
            setTimeout(this.gameLoop.bind(this), 1000);  // هر ثانیه امتیاز افزایش می‌یابد
        } else {
            this.updateMessage("Game Over! Final Score: " + this.score);
        }
    },

    updateMessage: function(message) {
        document.querySelector('.game-message').textContent = message;
    }
};

// وقتی صفحه بارگذاری می‌شود، بازی را راه‌اندازی کن
document.addEventListener('DOMContentLoaded', function() {
    GameNamespace.init();
});
