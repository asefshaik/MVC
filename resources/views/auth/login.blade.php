<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Master - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #FF6B6B;
            --secondary: #6B8AFD;
            --dark: #2A2D34;
            --light: #F8F7FF;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Ubuntu', sans-serif;
            background: url('/images/game-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--light);
        }
        
        .game-nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(42, 45, 52, 0.9);
            border-bottom: 3px solid var(--primary);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        
        .game-logo {
            font-family: 'Press Start 2P', cursive;
            color: var(--primary);
            font-size: 1.2rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .game-container {
            background: rgba(42, 45, 52, 0.9);
            border: 3px solid var(--primary);
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.7);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .game-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,107,107,0.1) 0%, rgba(255,107,107,0) 70%);
            animation: pulse 6s infinite linear;
            z-index: -1;
        }
        
        .game-title {
            font-family: 'Press Start 2P', cursive;
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 30px;
            text-shadow: 3px 3px 0 var(--dark);
        }
        
        .game-input-group {
            position: relative;
            margin-bottom: 25px;
        }
        
        .game-input-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid var(--secondary);
            border-radius: 8px;
            background: rgba(248, 247, 255, 0.9);
            color: var(--dark);
            font-size: 1rem;
            font-weight: bold;
        }
        
        .game-input-group input::placeholder {
            color: #666;
            font-weight: normal;
        }
        
        .game-input-group i {
            position: absolute;
            left: 15px;
            top: 15px;
            color: var(--secondary);
        }
        
        .game-remember {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
            color: var(--light);
        }
        
        .game-remember input {
            margin-right: 10px;
        }
        
        .game-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            width: 100%;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
            text-shadow: 1px 1px 0 var(--dark);
        }
        
        .game-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(107, 138, 253, 0.6);
        }
        
        .game-links {
            display: flex;
            justify-content: space-between;
        }
        
        .game-link {
            color: var(--secondary);
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .game-link:hover {
            color: var(--primary);
        }
        
        @keyframes pulse {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @media (max-width: 576px) {
            .game-container {
                padding: 30px 20px;
                margin: 0 15px;
            }
            
            .game-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <nav class="game-nav">
        <a href="{{ url('/') }}" class="game-logo">
            <i class="fas fa-cards"></i> MEMORY-CARD
        </a>
    </nav>
    
    <div class="game-container">
        <h1 class="game-title">PLAYER LOGIN</h1>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="game-input-group">
                <input id="email" type="email" placeholder="Email" name="email" required autofocus>
                <i class="fas fa-envelope"></i>
            </div>

            <div class="game-input-group">
                <input id="password" type="password" placeholder="Password" name="password" required>
                <i class="fas fa-lock"></i>
            </div>

            <div class="game-remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit" class="game-btn">
                START GAME <i class="fas fa-arrow-right"></i>
            </button>

            <div class="game-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="game-link">Forgot Password?</a>
                @endif
                <a href="{{ route('register') }}" class="game-link">Create Account</a>
            </div>
        </form>
    </div>
</body>
</html>