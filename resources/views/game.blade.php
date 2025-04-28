@extends('layouts.app')

@section('content')
<div class="game-container">
    
    <header class="game-header">
        <h1 class="game-title">Memory Master</h1>
        <div class="header-controls">
            @auth
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="control-btn logout-btn">
                    <i class="fas fa-power-off"></i>
                </button>
            </form>
            @endauth
            <button id="themeToggle" class="control-btn theme-btn">
                <i class="fas fa-palette"></i>
            </button>
        </div>
    </header>

    <div class="theme-modal" id="themeModal">
        <div class="modal-content">
            <h3>Select Card Theme</h3>
            <div class="difficulty-options">
                <h4>Difficulty:</h4>
                <div class="difficulty-option active" data-difficulty="easy">Easy (4×4)</div>
                <div class="difficulty-option" data-difficulty="medium">Medium (5×5)</div>
                <div class="difficulty-option" data-difficulty="hard">Hard (6×6)</div>
            </div>
            <div class="theme-options">
                <div class="theme-option active" data-theme="animals">
                    <div class="theme-preview animal-theme">🐶🐱🦁</div>
                    <span>Animals</span>
                </div>
                <div class="theme-option" data-theme="sports">
                    <div class="theme-preview sports-theme">⚽🏀🏈</div>
                    <span>Sports</span>
                </div>
                <div class="theme-option" data-theme="fruits">
                    <div class="theme-preview fruit-theme">🍎🍌🍒</div>
                    <span>Fruits</span>
                </div>
            </div>
            <button id="startGame" class="action-btn start-btn">
                Start Game <i class="fas fa-play"></i>
            </button>
        </div>
    </div>

    
    <div class="game-interface" id="gameInterface" style="display: none;">
        <div class="game-stats">
            <div class="stat-box">
                <i class="fas fa-running"></i>
                <span id="moves">0</span> Moves
            </div>
            <div class="stat-box">
                <i class="fas fa-clock"></i>
                <span id="timer">0</span>s
            </div>
            <div class="stat-box">
                <i class="fas fa-star"></i>
                <span id="score">0</span> Points
            </div>
        </div>

        <div class="game-board" id="gameBoard"></div>
        
        <div class="game-actions">
            <button id="restartBtn" class="action-btn restart-btn">
                <i class="fas fa-redo"></i> Restart
            </button>
            <a href="{{ route('leaderboard') }}" class="action-btn leaderboard-btn">
                <i class="fas fa-trophy"></i> Leaderboard
            </a>
        </div>
    </div>


    <div class="completion-modal" id="completionModal" style="display: none;">
        <div class="modal-content">
            <h3 id="resultTitle">Congratulations!</h3>
            <div class="result-stats">
                <p><i class="fas fa-running"></i> Moves: <span id="finalMoves">0</span></p>
                <p><i class="fas fa-clock"></i> Time: <span id="finalTime">0</span>s</p>
                <p><i class="fas fa-star"></i> Score: <span id="finalScore">0</span></p>
            </div>
            <div class="modal-actions">
                <button id="playAgainBtn" class="action-btn primary-btn">
                    <i class="fas fa-redo"></i> Play Again
                </button>
                <button id="newGameBtn" class="action-btn secondary-btn">
                    <i class="fas fa-gamepad"></i> New Game
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #FF6B6B;
        --secondary: #6B8AFD;
        --dark: #2A2D34;
        --light: #F8F7FF;
        --success: #4CAF50;
        --warning: #FFC107;
        --danger: #EF476F;
        --info: #06D6A0;
    }

    .game-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .game-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid rgba(42, 45, 52, 0.1);
    }

    .game-title {
        color: var(--primary);
        font-family: 'Press Start 2P', cursive;
        font-size: 1.8rem;
        text-shadow: 2px 2px 0 var(--dark);
        margin: 0;
    }

    .header-controls {
        display: flex;
        gap: 10px;
    }

    .control-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: var(--secondary);
        color: white;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .control-btn:hover {
        transform: scale(1.1);
    }

    .logout-btn {
        background: var(--primary);
    }

    .theme-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(42, 45, 52, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        text-align: center;
    }

    .modal-content h3 {
        color: var(--dark);
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
    }

    .difficulty-options {
        margin-bottom: 1.5rem;
    }

    .difficulty-options h4 {
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .difficulty-option {
        display: inline-block;
        padding: 8px 15px;
        margin: 0 5px;
        border-radius: 20px;
        background: #f0f0f0;
        cursor: pointer;
        transition: all 0.3s;
    }

    .difficulty-option.active {
        background: var(--secondary);
        color: white;
    }

    .difficulty-option:hover {
        transform: translateY(-2px);
    }

    .theme-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 2rem;
    }

    .theme-option {
        cursor: pointer;
        transition: all 0.3s;
    }

    .theme-option:hover {
        transform: translateY(-5px);
    }

    .theme-preview {
        width: 100px;
        height: 100px;
        margin: 0 auto 10px;
        border-radius: 8px;
        border: 3px solid transparent;
        transition: all 0.3s;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 2rem;
    }

    .theme-option:hover .theme-preview {
        border-color: var(--secondary);
    }

    .theme-option.active .theme-preview {
        border-color: var(--primary);
        box-shadow: 0 0 15px rgba(255, 107, 107, 0.5);
    }

    .animal-theme { background: #FFD166; color: #333; }
    .sports-theme { background: #06D6A0; color: #333; }
    .fruit-theme { background: #EF476F; color: white; }

    .start-btn {
        background: var(--primary);
        color: white;
        padding: 12px 30px;
        font-size: 1.1rem;
        transition: all 0.3s;
    }

    .start-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .game-interface {
        margin-top: 2rem;
    }

    .game-stats {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .stat-box {
        background: rgba(42, 45, 52, 0.8);
        border-radius: 8px;
        padding: 12px 20px;
        color: white;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1rem;
        min-width: 100px;
        justify-content: center;
    }

    .stat-box i {
        font-size: 1.2rem;
    }

    .game-board {
        display: grid;
        gap: 10px;
        margin: 0 auto;
        max-width: 600px;
    }

    .card {
        aspect-ratio: 1;
        background: var(--secondary);
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 2rem;
        cursor: pointer;
        transition: all 0.3s;
        transform-style: preserve-3d;
        position: relative;
        user-select: none;
    }

    .card::before {
        content: '?';
        position: absolute;
        font-size: 2rem;
        color: white;
    }

    .card.flipped {
        background: white;
        color: var(--dark);
        transform: rotateY(180deg);
    }

    .card.flipped::before {
        content: '';
    }

    .card.matched {
        background: var(--success);
        cursor: default;
        animation: pulse 0.5s;
    }

    .card.empty {
        visibility: hidden;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .game-actions {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 2rem;
    }

    .action-btn {
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        border: none;
        font-size: 1rem;
    }

    .restart-btn {
        background: var(--secondary);
        color: white;
    }

    .leaderboard-btn {
        background: var(--warning);
        color: var(--dark);
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .completion-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(42, 45, 52, 0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .completion-modal .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        text-align: center;
        max-width: 500px;
        width: 90%;
        animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .result-stats {
        margin: 1.5rem 0;
        font-size: 1.2rem;
        text-align: left;
    }

    .result-stats p {
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 1.5rem;
    }

    .primary-btn {
        background: var(--primary);
        color: white;
    }

    .secondary-btn {
        background: var(--secondary);
        color: white;
    }

    @media (max-width: 768px) {
        .theme-options {
            grid-template-columns: 1fr;
        }
        
        .game-stats {
            flex-direction: column;
            align-items: center;
        }
        
        .stat-box {
            width: 100%;
            max-width: 200px;
        }
        
        .game-actions {
            flex-direction: column;
            align-items: center;
        }
        
        .action-btn {
            width: 100%;
            max-width: 200px;
            justify-content: center;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const themes = {
        animals: ['🐶', '🐱', '🦁', '🐯', '🐮', '🐷', '🐸', '🐵', '🐔', '🐧', '🦄', '🐲'],
        sports: ['⚽', '🏀', '🏈', '⚾', '🎾', '🏐', '🏉', '🎱', '🏓', '🏸', '🏒', '🏏'],
        fruits: ['🍎', '🍌', '🍒', '🍓', '🍊', '🍋', '🍉', '🍇', '🍑', '🍍', '🥝', '🥥']
    };

    
    const difficultySettings = {
        easy: { pairs: 8, gridSize: 4, time: 90 },
        medium: { pairs: 12, gridSize: 5, time: 120 },
        hard: { pairs: 18, gridSize: 6, time: 180 }
    };

    let currentTheme = 'animals';
    let currentDifficulty = 'medium';
    let cards = [];
    let flippedCards = [];
    let matchedPairs = 0;
    let moves = 0;
    let timeLeft = 0;
    let timer;
    let gameCompleted = false;
    let gameStarted = false;
    let totalPairs = 0;

    const themeModal = document.getElementById('themeModal');
    const gameInterface = document.getElementById('gameInterface');
    const gameBoard = document.getElementById('gameBoard');
    const movesDisplay = document.getElementById('moves');
    const timerDisplay = document.getElementById('timer');
    const scoreDisplay = document.getElementById('score');
    const restartBtn = document.getElementById('restartBtn');
    const startBtn = document.getElementById('startGame');
    const themeOptions = document.querySelectorAll('.theme-option');
    const difficultyOptions = document.querySelectorAll('.difficulty-option');
    const completionModal = document.getElementById('completionModal');
    const resultTitle = document.getElementById('resultTitle');
    const finalMoves = document.getElementById('finalMoves');
    const finalTime = document.getElementById('finalTime');
    const finalScore = document.getElementById('finalScore');
    const playAgainBtn = document.getElementById('playAgainBtn');
    const newGameBtn = document.getElementById('newGameBtn');

    themeOptions.forEach(option => {
        option.addEventListener('click', () => {
            themeOptions.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
            currentTheme = option.dataset.theme;
        });
    });

    difficultyOptions.forEach(option => {
        option.addEventListener('click', () => {
            difficultyOptions.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
            currentDifficulty = option.dataset.difficulty;
        });
    });

    startBtn.addEventListener('click', () => {
        themeModal.style.display = 'none';
        gameInterface.style.display = 'block';
        initGame();
    });

    function initGame() {
        gameBoard.innerHTML = '';
        gameStarted = true;
        gameCompleted = false;
        
        const settings = difficultySettings[currentDifficulty];
        timeLeft = settings.time;
        totalPairs = settings.pairs;
        
        const themeEmojis = themes[currentTheme];
        const selectedEmojis = themeEmojis.sort(() => 0.5 - Math.random()).slice(0, settings.pairs);
        cards = [...selectedEmojis, ...selectedEmojis];
        
        gameBoard.style.gridTemplateColumns = `repeat(${settings.gridSize}, 1fr)`;
        const shuffledCards = shuffleArray([...cards]);
        
        for (let i = 0; i < settings.gridSize * settings.gridSize; i++) {
            const card = document.createElement('div');
            card.className = 'card';
            card.dataset.index = i;
            
            if (i < settings.pairs * 2) {
                card.dataset.value = shuffledCards[i];
                card.addEventListener('click', flipCard);
            } else {
                card.classList.add('empty');
            }
            
            gameBoard.appendChild(card);
        }
        
        resetGameState();
        startTimer();
    }

    function resetGameState() {
        flippedCards = [];
        matchedPairs = 0;
        moves = 0;
        gameCompleted = false;
        movesDisplay.textContent = moves;
        timerDisplay.textContent = timeLeft;
        scoreDisplay.textContent = 0;
        clearInterval(timer);
    }

    
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    function flipCard() {
        if (gameCompleted || flippedCards.length >= 2 || 
            this.classList.contains('flipped') || 
            this.classList.contains('matched') ||
            this.classList.contains('empty')) {
            return;
        }

        this.classList.add('flipped');
        this.textContent = this.dataset.value;
        flippedCards.push(this);

        if (flippedCards.length === 2) {
            moves++;
            movesDisplay.textContent = moves;
            checkForMatch();
        }
    }

    
    function checkForMatch() {
        const [firstCard, secondCard] = flippedCards;
        
        if (firstCard.dataset.value === secondCard.dataset.value) {
            firstCard.classList.add('matched');
            secondCard.classList.add('matched');
            matchedPairs++;
            flippedCards = [];
            
            
            const score = calculateScore();
            scoreDisplay.textContent = score;
            
            if (matchedPairs === totalPairs) {
                endGame(true);
            }
        } else {
            setTimeout(() => {
                firstCard.classList.remove('flipped');
                secondCard.classList.remove('flipped');
                firstCard.textContent = '';
                secondCard.textContent = '';
                flippedCards = [];
            }, 1000);
        }
    }

    
    function calculateScore() {
        const baseScore = matchedPairs * 100;
        const timeBonus = Math.floor(timeLeft / 5);
        const movePenalty = moves * 2;
        return Math.max(0, baseScore + timeBonus - movePenalty);
    }

    
    function startTimer() {
        timerDisplay.textContent = timeLeft;
        timer = setInterval(() => {
            timeLeft--;
            timerDisplay.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                endGame(false);
            }
        }, 1000);
    }

    function endGame(isWin) {
        gameCompleted = true;
        clearInterval(timer);
        
        const score = calculateScore();
        
        if (isWin) {
            resultTitle.textContent = 'Congratulations!';
            resultTitle.style.color = 'var(--success)';
        } else {
            resultTitle.textContent = 'Time\'s Up!';
            resultTitle.style.color = 'var(--danger)';
        }
        
        finalMoves.textContent = moves;
        finalTime.textContent = difficultySettings[currentDifficulty].time - timeLeft;
        finalScore.textContent = score;
        
        setTimeout(() => {
            completionModal.style.display = 'flex';
        }, 500);
    }

    restartBtn.addEventListener('click', () => {
        completionModal.style.display = 'none';
        initGame();
    });

    playAgainBtn.addEventListener('click', () => {
        completionModal.style.display = 'none';
        initGame();
    });

    
    newGameBtn.addEventListener('click', () => {
        completionModal.style.display = 'none';
        gameInterface.style.display = 'none';
        themeModal.style.display = 'flex';
    });

    
    themeOptions[0].classList.add('active');
    difficultyOptions[1].classList.add('active'); 
});
</script>
@endsection