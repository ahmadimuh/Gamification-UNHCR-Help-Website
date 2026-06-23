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

//game_next_btn

function nextstagegame() {
            var nextButton = jQuery('.un-stage-next-button');
            if (nextButton.length) {
                nextButton.click();  
            }
}



//game_type_1
function helpIrGamificationGameOneShowDescription(id) {
      if (document.getElementById(id).classList.contains('active')) {
          document.getElementById(id).classList.remove('active');
        } else {
          document.getElementById(id).classList.add('active');
        }   
}
function helpIrGamificationGameOneShowDescription(id) {

    var desc = document.getElementById(id);
    desc.classList.toggle('active');

    
    var clickedOption = event.currentTarget;
    clickedOption.classList.add('completed');

    helpIrGamificationGameOnecheckAllOptionsCompleted();
}

function helpIrGamificationGameOnecheckAllOptionsCompleted() {

    var allOptions = document.querySelectorAll('.helpIrGamificationGameOneOption');
    var completedOptions = document.querySelectorAll('.helpIrGamificationGameOneOption.completed');

    if (allOptions.length === completedOptions.length) {
        document.getElementById('gameFinalMessage').classList.add('show');
        document.getElementById('gameFinalBtn').classList.add('show');
        jQuery('.un-stage-next-button').show(); 
    }
}


//game_type_2
function initHelpIrGamificationGameTwo() {

  let selectedOptionshelpIrGamificationGameTwo = [];

  const correctOptions = document.querySelectorAll('.helpIrGamificationGameTwoOption[data-correct="true"]');
  if (!correctOptions.length) return;

  const maxSelections = correctOptions.length;

  const gameFinalMessage = document.getElementById("gameFinalMessage");
  if (!gameFinalMessage) return;

  const textEnd = gameFinalMessage.querySelector(".textend");
  const textError1 = gameFinalMessage.querySelector(".texterror1");
  const textError2 = gameFinalMessage.querySelector(".texterror2");
  const nextBtn = document.getElementById("gameFinalBtn");

  function resetMessagesHelpIrGamificationGameTwo() {
    textEnd.style.display = "none";
    textError1.style.display = "none";
    textError2.style.display = "none";
    nextBtn.style.display = "none";
  }

  function showSuccessHelpIrGamificationGameTwo() {
    resetMessagesHelpIrGamificationGameTwo();
    textEnd.style.display = "inline";
    nextBtn.style.display = "block";
    jQuery('.un-stage-next-button').show();
	textEnd.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  function showError1HelpIrGamificationGameTwo() {
    resetMessagesHelpIrGamificationGameTwo();
    textError1.style.display = "inline";
	textError1.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  function showError2HelpIrGamificationGameTwo() {
    resetMessagesHelpIrGamificationGameTwo();
    textError2.style.display = "inline";
	textError2.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  function checkAnswerHelpIrGamificationGameTwo() {

    if (selectedOptionshelpIrGamificationGameTwo.length === maxSelections) {

      const correctSelected =
        selectedOptionshelpIrGamificationGameTwo.filter(opt => opt.dataset.correct === "true");

      if (correctSelected.length === maxSelections) {
        showSuccessHelpIrGamificationGameTwo();
      } else {
        showError1HelpIrGamificationGameTwo();
      }

    } else {
      resetMessagesHelpIrGamificationGameTwo();
    }
  }

  document.querySelectorAll('.helpIrGamificationGameTwoOption')
    .forEach(option => {

      option.addEventListener("click", function () {

    if (option.classList.contains("selected")) {

      option.classList.remove("selected", "correct", "wrong");
      selectedOptionshelpIrGamificationGameTwo =
        selectedOptionshelpIrGamificationGameTwo.filter(opt => opt !== option);

    } else {

      if (selectedOptionshelpIrGamificationGameTwo.length >= maxSelections) {
       
        const removedOption = selectedOptionshelpIrGamificationGameTwo.shift();
        removedOption.classList.remove("selected", "correct", "wrong");
      }

      option.classList.add("selected");

      if (option.dataset.correct === "true") {
        option.classList.add("correct"); 
      } else {
        option.classList.add("wrong"); 
      }

      selectedOptionshelpIrGamificationGameTwo.push(option);
    }

    checkAnswerHelpIrGamificationGameTwo();
});

    });

  resetMessagesHelpIrGamificationGameTwo();
}


//game_type_3
const GameThree = (() => {
  let puzzle, shuffleBtn, status, nextBtn;
  let tiles = [];
  let originalTiles = [];
  let selectedTiles = [];
  let messages = {};

  function createTiles() {
    puzzle.innerHTML = '';
    tiles.forEach((tile, index) => {
      const div = document.createElement('div');
      div.classList.add('helpIrGamificationGameThreeTile');

      if(tile !== "") { 
        div.style.backgroundImage = `url(${tile})`;
        div.style.backgroundSize = 'cover';
      } else {
        div.style.background = '#ccc'; 
      }

      div.dataset.index = index;
      div.addEventListener('click', () => selectTile(index));
      puzzle.appendChild(div);
    });
  }

  function selectTile(index) {
    const tile = puzzle.children[index];
    if (selectedTiles.includes(index)) {
      selectedTiles = selectedTiles.filter(i => i !== index);
      tile.classList.remove('selected');
    } else {
      if (selectedTiles.length < 2) {
        selectedTiles.push(index);
        tile.classList.add('selected');
      }
    }

    if (selectedTiles.length === 2) {
      swapTiles(selectedTiles[0], selectedTiles[1]);
      selectedTiles = [];
    }
  }

  function swapTiles(i, j) {
    [tiles[i], tiles[j]] = [tiles[j], tiles[i]];
    createTiles();
    checkWin();
  }

  function checkWin() {
  const won = tiles.every((v, i) => v === originalTiles[i]);
  if (won) {
    status.textContent = messages.success;
    const nextBtn = document.getElementById('gameFinalBtn');
    jQuery('.un-stage-next-button').show();
    if (nextBtn) nextBtn.style.display = "block";
  } else {
    status.textContent = '';
    const nextBtn = document.getElementById('gameFinalBtn');
    if (nextBtn) nextBtn.style.display = "none";
  }
}

  function shuffleTiles() {
    for (let i = tiles.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [tiles[i], tiles[j]] = [tiles[j], tiles[i]];
    }
    createTiles();
  }

  return {
    init: (jsonData) => {
      puzzle = document.getElementById('helpIrGamificationGameThreePuzzle');
      shuffleBtn = document.getElementById('helpIrGamificationGameThreeShuffle');
      status = document.getElementById('helpIrGamificationGameThreeStatus');

      tiles = [...jsonData.tiles];
      originalTiles = [...jsonData.tiles];
      messages = jsonData.messages;

      shuffleBtn.addEventListener('click', shuffleTiles);

      shuffleTiles(); 
    }
  };
})();

//game_type_4


   function HelpIrGamificationGameFour(container , options = {}) {

        this.container = container;
        this.board = container.querySelector('.game-container');
        this.message = container.querySelector('.game-message');

        this.selectedCells = [];
        this.matchedPairs = 0;
        this.isGameActive = false;

        this.data = [...helpIrGamificationGameFourData];
        this.totalPairs = this.data.length / 4;

		this.options = options;
        this.winMessage = options.winMessage || "آفرین شما حل کردید...";


        this.init();
    }

    HelpIrGamificationGameFour.prototype.init = function() {
        this.shuffleArray(this.data);
        this.createBoard();
    };

    HelpIrGamificationGameFour.prototype.createBoard = function() {
        this.board.innerHTML = '';

        this.data.forEach(item => {
            const cell = document.createElement('div');
            cell.classList.add('game-cell', 'flipped'); // اول باز باشد
            cell.dataset.pair = item.pair_id;

            const img = document.createElement('img');
            img.src = item.image;

            cell.appendChild(img);
            this.board.appendChild(cell);

            cell.addEventListener('click', this.flipCell.bind(this));
        });

        // preview 2 ثانیه
        setTimeout(() => {
            this.closeAllCards();
        }, 2000);
    };

    HelpIrGamificationGameFour.prototype.closeAllCards = function() {
        const cells = this.board.querySelectorAll('.game-cell');
        cells.forEach(cell => cell.classList.remove('flipped'));
        this.isGameActive = true;
    };

    HelpIrGamificationGameFour.prototype.flipCell = function(event) {

        if (!this.isGameActive) return;

        const cell = event.currentTarget;

        if (
            cell.classList.contains('matched') ||
            cell.classList.contains('selected') ||
            this.selectedCells.length === 2
        ) return;

        cell.classList.add('flipped', 'selected');
        this.selectedCells.push(cell);

        if (this.selectedCells.length === 2) {
            this.checkMatch();
        }
    };

    HelpIrGamificationGameFour.prototype.checkMatch = function() {
        const [first, second] = this.selectedCells;

        if (first.dataset.pair === second.dataset.pair) {
            first.classList.add('matched');
            second.classList.add('matched');

            this.matchedPairs++;
            this.selectedCells = [];

            if (this.matchedPairs === this.totalPairs) {
                this.message.textContent = this.winMessage;

				jQuery('.un-stage-next-button').show();
				const btn = this.container.querySelector('.next-stage-btn');
					if (btn) {
						btn.style.display = 'inline-block';
					}
            }

        } else {
            setTimeout(() => {
                first.classList.remove('flipped', 'selected');
                second.classList.remove('flipped', 'selected');
                this.selectedCells = [];
            }, 800);
        }
    };

    HelpIrGamificationGameFour.prototype.shuffleArray = function(array) {
        array.sort(() => Math.random() - 0.5);
    };



//game_type_5


  class GamificationMapGameFive {
    constructor({ containerSelector, mapPoints, initialText }) {
      this.containerSelector = containerSelector;
      this.mapPoints = mapPoints;
      this.initialText = initialText;

      this.userSelections = [];
      this.correctSelected = false;

      this.init();
    }

    init() {
      const container = document.querySelector(this.containerSelector);
      if (!container) return;

      container.querySelectorAll(".helpIrGamificationGameFive-point").forEach(el => el.remove());

  
      this.message = container.querySelector("#helpIrGamificationGameFiveMessage");
      this.nextBtn = container.querySelector("#helpIrGamificationGameFiveNextBtn");

   
      this.mapPoints.forEach(point => {
        const div = document.createElement("div");
        div.classList.add("helpIrGamificationGameFive-point");
        div.style.left = point.left;
        div.style.top = point.top;
        div.style.width = point.width;
        div.style.height = point.height;

        const img = document.createElement("img");
        img.src = point.img;
        img.alt = point.name;
        div.appendChild(img);

        div.addEventListener("click", () => this.handlePointClick(point));

        container.appendChild(div);
      });

   
      this.showMessage(this.initialText, "rgba(0,123,255,0.85)", false);
    }

    showMessage(text, bgColor, showNextBtn = false) {
      this.message.style.opacity = 0;
      setTimeout(() => {
        this.message.textContent = text;
        if (showNextBtn) {
          this.nextBtn.style.display = "inline-block";
          jQuery('.un-stage-next-button').show();
          this.message.appendChild(this.nextBtn);
        } else {
          this.nextBtn.style.display = "none";
        }
        this.message.style.backgroundColor = bgColor;
        this.message.style.opacity = 1;
      }, 100);
    }

    handlePointClick(point) {
      this.userSelections.push({ id: point.id, correct: point.correct });

      if (point.correct) {
        this.correctSelected = true;
        this.showMessage(point.message, "rgba(40,167,69,0.85)", true);
      } else {
        if (!this.correctSelected) {
          this.showMessage(point.message, "rgba(220,53,69,0.85)", false);
          setTimeout(() => {
            this.message.style.opacity = 0;
          }, 5000);
        }
      }
    }

    getUserSelections() {
      return this.userSelections;
    }
  }
  
  
  
//game_type_6
  const GameSix = (() => {
  let board, status, nextBtn;
  let selected = [];
  let matched = 0;
  let pairs = [];
  let messages = {};

  function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
    }
  }

  function createTiles() {
    board.innerHTML = "";
    shuffle(pairs);
    matched = 0;
    selected = [];
    nextBtn.style.display = "none";

    pairs.forEach(item => {
      const tile = document.createElement("div");
      tile.classList.add("helpIrGamificationGameSix-tile");

      if(item.type === "sound") {
        const audio = document.createElement("audio");
        audio.src = item.content;
        audio.preload = "auto";
        tile.appendChild(audio);

        const icon = document.createElement("img");
        icon.src = item.icon;
        icon.style.width = "100%";
        icon.style.height = "100%";
        tile.appendChild(icon);
      } else {
        const img = document.createElement("img");
        img.src = item.content;
        tile.appendChild(img);
      }

      tile.addEventListener("click", () => selectTile(tile, item));
      board.appendChild(tile);
    });
  }

  function selectTile(tile, item) {
    if(tile.classList.contains("helpIrGamificationGameSix-disabled") || selected.length >= 2) return;

    tile.classList.add("helpIrGamificationGameSix-selected");

    if(item.type === "sound") {
      tile.querySelector("audio").play().catch(e => console.log(e));
    }

    selected.push({tile, item});

    if(selected.length === 2) {
      setTimeout(checkMatch, 500);
    }
  }

  function checkMatch() {
    const [first, second] = selected;

    if(first.item.content === second.item.match) {
      first.tile.classList.add("helpIrGamificationGameSix-matched", "helpIrGamificationGameSix-disabled");
      second.tile.classList.add("helpIrGamificationGameSix-matched", "helpIrGamificationGameSix-disabled");
      matched++;

      if(matched === pairs.length / 2) {
        status.textContent = messages.success;
        nextBtn.style.display = "block";
        jQuery('.un-stage-next-button').show();
      }
    } else {
      first.tile.classList.remove("helpIrGamificationGameSix-selected");
      second.tile.classList.remove("helpIrGamificationGameSix-selected");
      status.textContent = messages.mismatch;
    }

    selected = [];
  }

  return {
    init: ({boardId, statusId, data}) => {
      board = document.getElementById(boardId);
      status = document.getElementById(statusId);
      nextBtn = document.getElementById("gameFinalBtn");

      pairs = data.pairs;
      messages = data.messages;

      createTiles();
    }
  };
})();

//game_type_8
const HelpIrGamificationGameEight = (() => {
  let heightSlider, weightSlider, heightValue, weightValue;
  let heightMessage, weightMessage, finalMessage, nextBtn;

  let correctHeight = 120;
  let correctWeight = 24;

  let heightCorrect = false;
  let weightCorrect = false;

  let heightTimer = null;
  let weightTimer = null;

  function updateMessages() {
    const h = parseInt(heightSlider.value);
    const w = parseInt(weightSlider.value);

    // پیام قد
    if(h === 0){
      heightMessage.style.opacity = 0;
      heightCorrect = false;
      clearTimeout(heightTimer);
    } else if(h === correctHeight){
      heightMessage.textContent = `قد: ${h} cm صحیح ✅`;
      heightMessage.style.backgroundColor = "rgba(40,167,69,0.85)";
      heightMessage.style.opacity = 1;
      heightCorrect = true;
      clearTimeout(heightTimer);
      heightTimer = setTimeout(() => { heightMessage.style.opacity = 0; }, 3000);
    } else {
      heightMessage.textContent = `قد: ${h} cm اشتباه ❌`;
      heightMessage.style.backgroundColor = "rgba(220,53,69,0.85)";
      heightMessage.style.opacity = 1;
      heightCorrect = false;
      clearTimeout(heightTimer);
      heightTimer = setTimeout(() => { heightMessage.style.opacity = 0; }, 3000);
    }

    // پیام وزن
    if(w === 0){
      weightMessage.style.opacity = 0;
      weightCorrect = false;
      clearTimeout(weightTimer);
    } else if(w === correctWeight){
      weightMessage.textContent = `وزن: ${w} kg صحیح ✅`;
      weightMessage.style.backgroundColor = "rgba(40,167,69,0.85)";
      weightMessage.style.opacity = 1;
      weightCorrect = true;
      clearTimeout(weightTimer);
      weightTimer = setTimeout(() => { weightMessage.style.opacity = 0; }, 3000);
    } else {
      weightMessage.textContent = `وزن: ${w} kg اشتباه ❌`;
      weightMessage.style.backgroundColor = "rgba(220,53,69,0.85)";
      weightMessage.style.opacity = 1;
      weightCorrect = false;
      clearTimeout(weightTimer);
      weightTimer = setTimeout(() => { weightMessage.style.opacity = 0; }, 3000);
    }

    // پیام نهایی و دکمه ادامه
    if(heightCorrect && weightCorrect){
      finalMessage.textContent = `مقادیر صحیح هستند! ✅`;
      finalMessage.style.backgroundColor = "rgba(40,167,69,0.85)";
      finalMessage.style.opacity = 1;
      nextBtn.style.display = "inline-block";
      jQuery('.un-stage-next-button').show();
    } else {
      finalMessage.style.opacity = 0;
      nextBtn.style.display = "none";
    }
  }

  function setupEventListeners() {
    heightSlider.addEventListener("input", () => {
      heightValue.textContent = heightSlider.value;
      updateMessages();
    });

    weightSlider.addEventListener("input", () => {
      weightValue.textContent = weightSlider.value;
      updateMessages();
    });
  }

  return {
    init: (config) => {
      // عناصر
      heightSlider = document.getElementById("heightSlider");
      weightSlider = document.getElementById("weightSlider");
      heightValue = document.getElementById("heightValue");
      weightValue = document.getElementById("weightValue");
      heightMessage = document.getElementById("heightMessage");
      weightMessage = document.getElementById("weightMessage");
      finalMessage = document.getElementById("finalMessage");
      nextBtn = document.getElementById("nextStageBtn");

      // مقادیر از config
      correctHeight = config.correctHeight ?? 120;
      correctWeight = config.correctWeight ?? 24;

      // مقدار اولیه
      heightSlider.value = 0;
      weightSlider.value = 0;
      heightValue.textContent = 0;
      weightValue.textContent = 0;
      heightMessage.style.opacity = 0;
      weightMessage.style.opacity = 0;
      finalMessage.style.opacity = 0;
      nextBtn.style.display = "none";

      setupEventListeners();
    },
    getValues: () => ({
      height: parseInt(heightSlider.value),
      weight: parseInt(weightSlider.value)
    })
  };
})();