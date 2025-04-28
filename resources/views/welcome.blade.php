<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Master Challenge</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        :root {
            --game-accent: #FF6B6B;
            --game-dark: #2A2D34;
            --game-light: #F8F7FF;
            --game-secondary: #6B8AFD;
        }
        
        body {
            background: url('/images/game-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Ubuntu', sans-serif;
            height: 100vh;
            overflow: hidden;
            color: var(--game-light);
        }
        
        .game-container {
            background: rgba(42, 45, 52, 0.85);
            backdrop-filter: blur(10px);
            border: 4px solid var(--game-accent);
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(255, 107, 107, 0.3);
            padding: 2rem;
            max-width: 600px;
            margin: 5vh auto;
            text-align: center;
        }
        
        .game-title {
            font-family: 'Press Start 2P', cursive;
            color: var(--game-accent);
            text-shadow: 3px 3px 0 var(--game-dark);
            margin-bottom: 2rem;
            font-size: 2.5rem;
        }
        
        .game-btn {
            background: var(--game-secondary);
            border: none;
            color: white;
            padding: 15px 30px;
            margin: 10px;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(107, 138, 253, 0.4);
            display: inline-block;
        }
        
        .game-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(107, 138, 253, 0.6);
        }
        
        .game-btn-primary {
            background: var(--game-accent);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }
        
        .game-btn-primary:hover {
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.6);
        }
        
        .game-character {
            width: 150px;
            margin: -100px auto 20px;
            display: block;
        }
        
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="particles" id="particles-js"></div>
    
    <div class="game-container">
        <img src="/images/game-character.png" alt="Game Character" class="game-character">
        <h1 class="game-title">MEMORY MASTER CHALLENGE</h1>
        
        <p class="lead mb-4" style="font-size: 1.3rem;">Test your memory skills in this exciting card matching game!</p>
        
        @guest
            <a href="{{ route('login') }}" class="game-btn">Login</a>
            <a href="{{ route('register') }}" class="game-btn game-btn-primary">Register</a>
        @else
            <a href="{{ route('game') }}" class="game-btn game-btn-primary">Play Now</a>
            <a href="{{ route('leaderboard') }}" class="game-btn">Leaderboard</a>
        @endguest
    </div>

    
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 80, "density": { "enable": true, "value_area": 800 } },
                "color": { "value": "#FF6B6B" },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.5, "random": true },
                "size": { "value": 3, "random": true },
                "line_linked": { "enable": true, "distance": 150, "color": "#6B8AFD", "opacity": 0.4, "width": 1 },
                "move": { "enable": true, "speed": 2, "direction": "none", "random": true, "straight": false, "out_mode": "out" }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": { "enable": true, "mode": "repulse" },
                    "onclick": { "enable": true, "mode": "push" }
                }
            }
        });
    </script>
</body>
</html>