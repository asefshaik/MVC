@extends('layouts.app')

@section('content')
<div class="leaderboard-wrapper py-5">
    <div class="container-fluid px-4 px-lg-5">
        <div class="leaderboard-header text-center mb-5">
            <h1 class="display-3 fw-bold text-gradient">
                <i class="fas fa-trophy me-3"></i>Memory Master
                <span class="d-block display-4 mt-2">Global Leaderboard</span>
            </h1>
            <div class="header-actions mt-4">
                <a href="{{ route('game') }}" class="btn btn-primary btn-3d btn-lg px-5 py-3 me-3">
                    <i class="fas fa-gamepad me-2"></i>Play Now
                </a>
                <button class="btn btn-outline-secondary btn-3d btn-lg px-5 py-3">
                    <i class="fas fa-info-circle me-2"></i>How To Play
                </button>
            </div>
        </div>

        @if($scores->isEmpty())
        <div class="empty-leaderboard text-center py-5 my-5 rounded-5">
            <div class="empty-icon mb-4">
                <i class="fas fa-clipboard-list fa-5x text-muted"></i>
            </div>
            <h2 class="fw-bold mb-3">Leaderboard is Empty</h2>
            <p class="text-muted fs-4 mb-4">Be the pioneer! Play now and claim the top spot.</p>
            <a href="{{ route('game') }}" class="btn btn-primary btn-3d btn-lg px-5 py-3">
                <i class="fas fa-gamepad me-2"></i>Start Your Journey
            </a>
        </div>
        @else
        <div class="leaderboard-container">
            <div class="row g-0">
                <div class="col-12 mb-5">
                    <div class="podium-wrapper">
                        <div class="row justify-content-center">
                            @foreach($scores->take(3) as $score)
                            <div class="col-md-4 podium-col podium-{{ $loop->iteration }}">
                                <div class="podium-position">
                                    <div class="podium-rank">
                                        <span class="medal-number">{{ $loop->iteration }}</span>
                                        <div class="medal-icon">
                                            <i class="fas fa-medal"></i>
                                        </div>
                                    </div>
                                    <div class="podium-player">
                                        <div class="player-avatar">
                                            {{ substr($score['player'], 0, 1) }}
                                        </div>
                                        <h3 class="player-name">{{ $score['player'] }}</h3>
                                        <div class="player-stats">
                                            <span class="stat-badge moves">{{ $score['moves'] }} moves</span>
                                            <span class="stat-badge time">{{ $score['time'] }}s</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr class="table-header">
                                    <th scope="col" class="rank-col">Rank</th>
                                    <th scope="col" class="player-col">Player</th>
                                    <th scope="col" class="text-center">Moves</th>
                                    <th scope="col" class="text-center">Time</th>
                                    <th scope="col" class="text-center">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scores as $score)
                                <tr class="{{ $loop->iteration <= 3 ? 'd-none' : '' }} {{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
                                    <td class="rank-col fw-bold">
                                        #{{ $score['rank'] }}
                                        @if($loop->iteration <= 3)
                                            <span class="medal-small medal-{{ $loop->iteration }}">
                                                <i class="fas fa-medal"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="player-col">
                                        <div class="d-flex align-items-center">
                                            <div class="player-avatar-sm me-3">
                                                {{ substr($score['player'], 0, 1) }}
                                            </div>
                                            <div class="player-info">
                                                <div class="player-name">{{ $score['player'] }}</div>
                                                @if($loop->iteration <= 3)
                                                    <small class="player-title">Top {{ $loop->iteration }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $score['moves'] }}</td>
                                    <td class="text-center">{{ $score['time'] }}s</td>
                                    <td class="text-center">Today</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .leaderboard-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .text-gradient {
        background: linear-gradient(90deg, #6B8AFD 0%, #FF6B6B 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-3d {
        position: relative;
        transition: all 0.3s;
        box-shadow: 0 4px 0 rgba(0,0,0,0.2);
        transform: translateY(0);
    }

    .btn-3d:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 rgba(0,0,0,0.2);
    }

    .btn-3d:active {
        transform: translateY(2px);
        box-shadow: 0 2px 0 rgba(0,0,0,0.2);
    }

    .empty-leaderboard {
        background: white;
        padding: 4rem !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        max-width: 800px;
        margin: 0 auto;
    }

    .podium-wrapper {
        margin: 0 auto;
        max-width: 900px;
    }

    .podium-col {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .podium-1 {
        order: 2;
    }

    .podium-2 {
        order: 1;
    }

    .podium-3 {
        order: 3;
    }

    .podium-position {
        width: 100%;
        text-align: center;
        position: relative;
    }

    .podium-rank {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        position: relative;
    }

    .podium-1 .podium-rank {
        background: linear-gradient(135deg, #FFD700 0%, #FFC107 100%);
        transform: scale(1.2);
    }

    .podium-2 .podium-rank {
        background: linear-gradient(135deg, #C0C0C0 0%, #D3D3D3 100%);
    }

    .podium-3 .podium-rank {
        background: linear-gradient(135deg, #CD7F32 0%, #D79D6B 100%);
    }

    .medal-icon {
        position: absolute;
        font-size: 3rem;
        opacity: 0.2;
    }

    .podium-player {
        background: white;
        padding: 2rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .player-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6B8AFD 0%, #4A6CF7 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .player-name {
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .player-stats {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
    }

    .stat-badge {
        background: #f8f9fa;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .table-header {
        background: linear-gradient(90deg, #2A2D34 0%, #4A4F5B 100%);
        color: white;
    }

    .table-header th {
        padding: 1.2rem 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
    }

    .rank-col {
        width: 100px;
        text-align: center;
    }

    .player-col {
        min-width: 250px;
    }

    .table tbody tr {
        transition: all 0.2s;
    }

    .table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .even-row {
        background-color: rgba(255,255,255,0.7);
    }

    .odd-row {
        background-color: rgba(248,249,250,0.7);
    }

    .player-avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6B8AFD 0%, #4A6CF7 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .medal-small {
        margin-left: 0.5rem;
    }

    .medal-1 {
        color: #FFD700;
    }

    .medal-2 {
        color: #C0C0C0;
    }

    .medal-3 {
        color: #CD7F32;
    }

    .player-title {
        color: #6B8AFD;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    @media (max-width: 768px) {
        .podium-wrapper .row {
            flex-direction: column;
            gap: 2rem;
        }
        
        .podium-col {
            order: initial !important;
        }
        
        .header-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .header-actions .btn {
            width: 100%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
});
</script>
@endsection