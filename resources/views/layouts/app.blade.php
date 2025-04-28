<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memory-Card | @yield('title')</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Game Navbar Styles */
        .game-navbar {
            background: linear-gradient(135deg, #2A2D34 0%, #1A1C22 100%);
            border-bottom: 3px solid #FF6B6B;
            padding: 0.8rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }
        
        .game-nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .game-nav-brand {
            font-family: 'Press Start 2P', cursive;
            color: #FF6B6B;
            text-decoration: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .game-nav-links {
            display: flex;
            gap: 20px;
        }
        
        .game-nav-link {
            color: #6B8AFD;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 50px;
            transition: all 0.3s;
            text-decoration: none;
            border: 2px solid transparent;
        }
        
        .game-nav-link:hover {
            color: #FF6B6B;
            border-color: #FF6B6B;
        }
    </style>
</head>
<body>
<nav class="game-nav">
    <a href="{{ url('/') }}" class="game-logo">
        <i class="fas fa-cards"></i> MEMORY-CARD
    </a>
    
    <div class="game-nav-links">
        @auth
            <a href="{{ route('game') }}" class="game-nav-link">
                <i class="fas fa-play"></i> Play
            </a>
            <a href="{{ route('leaderboard') }}" class="game-nav-link">
                <i class="fas fa-trophy"></i> Leaderboard
            </a>
        @else
            <a href="{{ route('login') }}" class="game-nav-link">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="{{ route('register') }}" class="game-nav-link">
                <i class="fas fa-user-plus"></i> Register
            </a>
        @endauth
    </div>
</nav>

    <main>
        @yield('content')
    </main>
</body>
</html>