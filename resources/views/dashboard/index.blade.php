@extends('layouts.app')

@section('title', 'Mijn VOLT! - Dashboard')

@section('content')
<!-- Banner Section -->
<div class="aximo-hero-section dark-bg" style="background-image: url('https://images.unsplash.com/photo-1741800459656-4116dcb230ae?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center; position: relative; padding-top: 150px;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7);"></div>
    <div class="container position-relative">
        <!-- Breadcrumbs -->
        <div class="breadcrumb-wrapper">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mijn VOLT!</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="aximo-hero-content">
                    <h1>Mijn VOLT!</h1>
                    <div class="welcome-message">
                        <p>Welkom terug, {{ Auth::user()->name }}!</p>
                        <p class="subtitle">Jouw persoonlijke VOLT! FM dashboard waar je kunt stemmen, favorieten beheren en punten verdienen.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Content -->
<div class="dashboard-wrapper">
    <div class="container">
        <div class="row">
            <!-- Quick Stats -->
            <div class="col-md-4 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="icon-vote"></i>
                    </div>
                    <div class="card-content">
                        <h3>Jouw stemmen</h3>
                        <p class="number">{{ $userVotes ?? 0 }}</p>
                        <span>stemmen deze week</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="icon-favorite"></i>
                    </div>
                    <div class="card-content">
                        <h3>Favorieten</h3>
                        <p class="number">{{ $userFavorites ?? 0 }}</p>
                        <span>nummers</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="icon-badge"></i>
                    </div>
                    <div class="card-content">
                        <h3>Punten</h3>
                        <p class="number">{{ $userPoints ?? 0 }}</p>
                        <span>VOLT! punten</span>
                    </div>
                </div>
            </div>

            <!-- Top 40 Voting Section -->
            <div class="col-lg-8 mb-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Top 40 Stemmen</h2>
                        <p class="text-muted">Stem op je favoriete nummers voor de VOLT! Top 40</p>
                    </div>
                    <div class="voting-list">
                        @forelse($top40Songs ?? [] as $song)
                        <div class="voting-item">
                            <div class="song-info">
                                <span class="rank">{{ $loop->iteration }}</span>
                                <div class="song-details">
                                    <h4>{{ $song->title }}</h4>
                                    <p>{{ $song->artist }}</p>
                                </div>
                            </div>
                            <button class="vote-btn {{ $song->voted ? 'voted' : '' }}" data-song-id="{{ $song->id }}">
                                {{ $song->voted ? 'Gestemd' : 'Stem' }}
                            </button>
                        </div>
                        @empty
                        <div class="no-votes">
                            <p>Er zijn nog geen nummers beschikbaar om op te stemmen.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Favorites Section -->
            <div class="col-lg-4 mb-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Jouw Favorieten</h2>
                        <p class="text-muted">Je favoriete nummers van VOLT! FM</p>
                    </div>
                    <div class="favorites-list">
                        @forelse($favoriteSongs ?? [] as $song)
                        <div class="favorite-item">
                            <div class="song-info">
                                <div class="song-details">
                                    <h4>{{ $song->title }}</h4>
                                    <p>{{ $song->artist }}</p>
                                </div>
                            </div>
                            <button class="remove-favorite" data-song-id="{{ $song->id }}">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        @empty
                        <div class="no-favorites">
                            <p>Je hebt nog geen favoriete nummers.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Recente Activiteit</h2>
                        <p class="text-muted">Je laatste acties op VOLT! FM</p>
                    </div>
                    <div class="activity-list">
                        @forelse($recentActivity ?? [] as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="icon-{{ $activity->type }}"></i>
                            </div>
                            <div class="activity-content">
                                <p>{{ $activity->description }}</p>
                                <span>{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="no-activity">
                            <p>Nog geen recente activiteit.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.breadcrumb-wrapper {
    margin-bottom: 30px;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item {
    color: rgba(255,255,255,0.7);
    font-size: 14px;
    font-family: 'Inter', sans-serif;
}

.breadcrumb-item a {
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-item a:hover {
    color: #c3f135;
}

.breadcrumb-item.active {
    color: #c3f135;
}

.aximo-hero-content h1 {
    font-size: 3.5rem;
    margin-bottom: 20px;
    color: white;
    font-family: 'Syne', sans-serif;
}

.welcome-message {
    max-width: 600px;
}

.welcome-message p {
    color: rgba(255,255,255,0.9);
    font-size: 1.2rem;
    margin-bottom: 10px;
    font-family: 'Inter', sans-serif;
}

.welcome-message .subtitle {
    color: rgba(255,255,255,0.7);
    font-size: 1rem;
}

.dashboard-wrapper {
    padding: 80px 0;
    background: #f8f9fa;
}

.dashboard-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    height: 100%;
}

.card-header {
    margin-bottom: 20px;
}

.card-header h2 {
    font-size: 1.5rem;
    margin-bottom: 5px;
    font-family: 'Syne', sans-serif;
}

.card-header p {
    margin: 0;
    font-size: 0.9rem;
}

.card-icon {
    font-size: 2rem;
    color: #007bff;
    margin-bottom: 15px;
}

.card-content h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
    font-family: 'Syne', sans-serif;
}

.card-content .number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
    color: #007bff;
}

.voting-item, .favorite-item, .activity-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.voting-item:last-child, .favorite-item:last-child, .activity-item:last-child {
    border-bottom: none;
}

.song-info {
    display: flex;
    align-items: center;
}

.rank {
    width: 30px;
    height: 30px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-weight: 600;
    color: #007bff;
}

.song-details h4 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
}

.song-details p {
    margin: 0;
    font-size: 0.9rem;
    color: #6c757d;
}

.vote-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.vote-btn:hover {
    background: #0056b3;
}

.vote-btn.voted {
    background: #28a745;
    cursor: default;
}

.remove-favorite {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    padding: 5px;
    transition: color 0.2s;
}

.remove-favorite:hover {
    color: #c82333;
}

.activity-icon {
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: #007bff;
}

.activity-content {
    flex-grow: 1;
}

.activity-content p {
    margin: 0;
    font-size: 0.95rem;
}

.activity-content span {
    color: #6c757d;
    font-size: 0.85rem;
}

.no-votes, .no-favorites, .no-activity {
    text-align: center;
    padding: 30px 0;
    color: #6c757d;
}
</style>
@endsection

