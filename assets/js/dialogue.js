document.addEventListener('DOMContentLoaded', function () {
  const leftLines = document.querySelectorAll('.speech-left .line');
  const rightLines = document.querySelectorAll('.speech-right .line');

  // اگر هیچ دیالوگی وجود ندارد، کد را اجرا نکن
  if (!leftLines.length && !rightLines.length) return;

  // ابتدا همه دیالوگ‌ها را مخفی نگه داریم
  gsap.set([leftLines, rightLines], {opacity: 0, y: 20});

  // مرحله گفتگو را اجرا کن
  const tl = gsap.timeline();

  tl.to('.speech-left', {opacity: 1, duration: 0.3})
    .to(leftLines, {
      opacity: 1,
      y: 0,
      duration: 0.5,
      stagger: 1
    })
    .to('.speech-right', {opacity: 1, duration: 0.3}, '+=0.5')
    .to(rightLines, {
      opacity: 1,
      y: 0,
      duration: 0.5,
      stagger: 1
    });
});


//show next level blink after 30 Second
//click next-level-alert
jQuery(document).ready(function($) {
    // First time
    setTimeout(function() {
        jQuery('.next-level-alert').fadeIn().on('click', function() {
            var nextButton = jQuery('.un-stage-next-button');
            if (nextButton.length) {
                nextButton.click();  
            }
        });
    }, 30000);  

    setTimeout(function() {
        var nextButton = jQuery('.un-stage-next-button');
        if (nextButton.length) {
            nextButton.addClass('un-stage-next-button-alert');  
        }
    }, 15000);  

    // After AJAX Loading
    $(document).ajaxComplete(function() {
        setTimeout(function() {
            jQuery('.next-level-alert').fadeIn().on('click', function() {
                var nextButton = jQuery('.un-stage-next-button');
                if (nextButton.length) {
                    nextButton.click(); 
                }
            });
        }, 30000); 

        setTimeout(function() {
            var nextButton = jQuery('.un-stage-next-button');
            if (nextButton.length) {
                nextButton.addClass('un-stage-next-button-alert'); 
            }
        }, 15000);
    });
});

//game
 function startGame() {
    var GameNamespace = {
        selectedCells: [],
        matchedPairs: 0,
        totalPairs: 3,

        init: function() {
            this.shuffleCells(); // خانه‌ها را به صورت رندم چینش می‌کنیم
            this.setupEvents();
        },

        setupEvents: function() {
            var cells = document.querySelectorAll('.game-cell');
            cells.forEach(cell => {
                cell.addEventListener('click', this.flipCell.bind(this));
            });
        },

        flipCell: function(event) {
            var cell = event.currentTarget;

            // اگر دو خانه باز شده باشند، بازگشت به حالت اولیه
            if (this.selectedCells.length === 2) {
                this.resetFlippedCells();
            }

            // اگر خانه قبلاً باز شده باشد، هیچ کار نکنیم
            if (cell.classList.contains('flipped')) {
                return;
            }

            // خانه را باز کن
            cell.classList.add('flipped');
            this.selectedCells.push(cell);

            // وقتی دو خانه انتخاب شد
            if (this.selectedCells.length === 2) {
                this.checkMatch();
            }
        },

        checkMatch: function() {
            var [firstCell, secondCell] = this.selectedCells;

            // اگر دو خانه مشابه باشند
            if (firstCell.textContent === secondCell.textContent) {
                this.matchedPairs++;
                this.updateMessage(`حل شده‌ها: ${this.matchedPairs}`);

                // اگر تمام جفت‌ها پیدا شده باشد
                if (this.matchedPairs === this.totalPairs) {
                    this.updateMessage("آفرین شما حل کردید...");
                    // شبیه‌سازی کلیک دکمه مرحله بعد
                    setTimeout(() => {
                        this.simulateNextButtonClick();
                    }, 1000);  // 1 ثانیه صبر می‌کند و سپس کلیک را شبیه‌سازی می‌کند
                }
            } else {
                // اگر دو خانه مشابه نباشند، آن‌ها را دوباره برگردان
                setTimeout(() => {
                    firstCell.classList.remove('flipped');
                    secondCell.classList.remove('flipped');
                    this.selectedCells = [];
                }, 1000);
            }
        },

        resetFlippedCells: function() {
            this.selectedCells.forEach(cell => {
                cell.classList.remove('flipped');
            });
            this.selectedCells = [];
        },

        simulateNextButtonClick: function() {
            const nextButton = jQuery('.un-stage-next-button');
            if (nextButton.length) {
                nextButton.trigger('click'); // شبیه‌سازی کلیک
            } else {
                console.log("Next button not found");
            }
        },

        shuffleCells: function() {
            const cells = document.querySelectorAll('.game-cell');
            const cellsArray = Array.from(cells);
            const shuffledArray = this.shuffleArray(cellsArray);
            const gameContainer = document.querySelector('.game-container');

            // پاک کردن خانه‌ها از صفحه و اضافه کردن خانه‌های جدید به ترتیب رندم
            
			gameContainer.innerHTML = '';
            shuffledArray.forEach(cell => {
                gameContainer.appendChild(cell);
            });
        },

        shuffleArray: function(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]]; // Swap elements
            }
            return array;
        },

        updateMessage: function(message) {
            document.querySelector('.game-message').textContent = message;
        }
    };

    // شروع بازی بلافاصله بعد از بارگذاری صفحه
    GameNamespace.init();
}

