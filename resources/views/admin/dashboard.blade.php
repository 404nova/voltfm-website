@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-0">
    <!-- Flash message voor info -->
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Dashboard Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard</h1>
        <div>
            @if(isset($lastLogin))
                <span class="text-muted"><i class="fas fa-clock me-1"></i> Laatste login: {{ $lastLogin }}</span>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Stats Summary Row -->
        @if($isAdmin || $isBeheer || $isRedactie)
        <div class="col-12 mb-4">
            <div class="row g-3">
                <div class="col-xl-3 col-md-6">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title text-muted mb-1">Programma's</h5>
                                    <h2 class="mb-0 fw-bold">{{ $programCount }}</h2>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="fas fa-broadcast-tower fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                @if($isAdmin || $isBeheer)
                                <a href="{{ route('admin.programs.index') }}" class="text-decoration-none">Beheer programma's <i class="fas fa-arrow-right ms-1"></i></a>
                                @else
                                <span class="text-muted">Totaal aantal programma's</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title text-muted mb-1">Nieuwsartikelen</h5>
                                    <h2 class="mb-0 fw-bold">{{ $newsCount }}</h2>
                                </div>
                                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                    <i class="fas fa-newspaper fa-2x text-info"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.news.index') }}" class="text-decoration-none">Beheer nieuws <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                @if($isDj || $isAdmin || $isBeheer)
                <div class="col-xl-3 col-md-6">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title text-muted mb-1">DJ Shifts</h5>
                                    <h2 class="mb-0 fw-bold">{{ isset($upcomingShifts) ? $upcomingShifts->count() : 0 }}</h2>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                    <i class="fas fa-calendar-alt fa-2x text-success"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.schedule.index') }}" class="text-decoration-none">Bekijk planning <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title text-muted mb-1">Beschikbaarheid</h5>
                                    <h2 class="mb-0 fw-bold">{{ isset($availabilityCount) ? $availabilityCount : 0 }}</h2>
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                    <i class="fas fa-clock fa-2x text-warning"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.schedule.availability', $isDj && !($isAdmin || $isBeheer) ? ['user_id' => Auth::id()] : []) }}" class="text-decoration-none">Beheer beschikbaarheid <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- DJ Content Row -->
        @if($isDj || $isAdmin || $isBeheer)
        <div class="col-12 mb-4">
            <div class="row g-4">
                <!-- Next Live Show Countdown -->
                <div class="col-lg-5 col-md-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-danger bg-opacity-10 border-0">
                            <h5 class="mb-0 py-2"><i class="fas fa-microphone me-2"></i> {{ isset($timeToNextShow) ? $timeToNextShow['countdown_title'] : 'Volgende Live Uitzending' }}</h5>
                        </div>
                        <div class="card-body p-4 text-center">
                            @if(isset($nextShow) && isset($timeToNextShow))
                                <div id="live-countdown">
                                    <div class="row g-3 mb-3">
                                        <div class="col-4">
                                            <div class="bg-light rounded p-3">
                                                <h2 class="mb-0 fw-bold text-danger" id="days-count">{{ $timeToNextShow['days'] }}</h2>
                                                <small class="text-muted">dagen</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bg-light rounded p-3">
                                                <h2 class="mb-0 fw-bold text-danger" id="hours-count">{{ $timeToNextShow['hours'] }}</h2>
                                                <small class="text-muted">uur</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bg-light rounded p-3">
                                                <h2 class="mb-0 fw-bold text-danger" id="minutes-count">{{ $timeToNextShow['minutes'] }}</h2>
                                                <small class="text-muted">min</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mb-3">
                                        <h5 class="mb-2">{{ $nextShow->formatted_date }}</h5>
                                        <h3 class="mb-0 text-danger">{{ $nextShow->start_time }} - {{ $nextShow->end_time }}</h3>
                                    </div>
                                    <input type="hidden" id="next-show-time" value="{{ $timeToNextShow['next_show_datetime'] }}">
                                    <input type="hidden" id="total-seconds" value="{{ $timeToNextShow['total_seconds'] }}">

                                    <a href="{{ route('admin.schedule.index') }}" class="btn btn-outline-danger mt-2">
                                        <i class="fas fa-calendar-alt me-1"></i> Bekijk planning
                                    </a>
                                </div>
                            @else
                                <div class="py-5">
                                    <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
                                    <h5>Geen volgende uitzending gepland</h5>
                                    <p class="text-muted">Stel je beschikbaarheid in om shifts te krijgen</p>
                                    <a href="{{ route('admin.schedule.availability', $isDj && !($isAdmin || $isBeheer) ? ['user_id' => Auth::id()] : []) }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-clock me-1"></i> Beschikbaarheid beheren
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- DJ Planning -->
                <div class="col-lg-7 col-md-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-success bg-opacity-10 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 py-2"><i class="fas fa-calendar-alt me-2"></i> Mijn DJ Shifts <small class="text-muted ms-2">(alle statussen)</small></h5>
                            <a href="{{ route('admin.schedule.index') }}" class="btn btn-sm btn-outline-success">
                                Volledige planning
                            </a>
                        </div>
                        <div class="card-body p-0">
                            @if(isset($todayShift))
                                <div class="alert alert-success m-3 mb-0 border-0 shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success bg-opacity-25 p-2 me-3">
                                            <i class="fas fa-star fa-lg text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Jouw shift vandaag:</h6>
                                            <p class="mb-0 h5">{{ $todayShift->start_time }} - {{ $todayShift->end_time }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($upcomingShifts) && $upcomingShifts->count() > 0)
                                <!-- Filter Options -->
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Shift filters">
                                        <button type="button" class="btn btn-outline-primary active" id="filter-all">Alle shifts</button>
                                        <button type="button" class="btn btn-outline-primary" id="filter-upcoming">Alleen toekomstig</button>
                                    </div>
                                    <small class="text-muted">{{ $upcomingShifts->count() }} shifts gevonden</small>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Datum</th>
                                                <th>Tijd</th>
                                                <th>Status</th>
                                                <th>Notities</th>
                                            </tr>
                                        </thead>
                                        <tbody id="shifts-table-body">
                                            @foreach($upcomingShifts as $shift)
                                                @php
                                                    $now = \Carbon\Carbon::now();
                                                    $shiftStartDateTime = \Carbon\Carbon::parse($shift->date->format('Y-m-d') . ' ' . $shift->start_time);
                                                    $shiftEndDateTime = \Carbon\Carbon::parse($shift->date->format('Y-m-d') . ' ' . $shift->end_time);

                                                    // Determine shift status
                                                    $statusClass = 'secondary';
                                                    $statusLabel = $shift->date->diffForHumans();
                                                    $isPast = false;

                                                    if ($shift->date->isToday()) {
                                                        if ($now->between($shiftStartDateTime, $shiftEndDateTime)) {
                                                            $statusClass = 'danger';
                                                            $statusLabel = 'Nu live!';
                                                            $isPast = false;
                                                        } elseif ($now->lt($shiftStartDateTime)) {
                                                            $statusClass = 'success';
                                                            $statusLabel = 'Vandaag';
                                                            $isPast = false;
                                                        } elseif ($now->gt($shiftEndDateTime)) {
                                                            $statusClass = 'warning';
                                                            $statusLabel = 'Geweest (vandaag)';
                                                            $isPast = true;
                                                        }
                                                    } elseif ($shift->date->isPast() && $shiftEndDateTime->isPast()) {
                                                        $statusClass = 'secondary';
                                                        $statusLabel = 'Geweest';
                                                        $isPast = true;
                                                    } elseif ($shift->date->isFuture()) {
                                                        $statusClass = 'info';
                                                        $statusLabel = $shift->date->diffForHumans();
                                                        $isPast = false;
                                                    }
                                                @endphp
                                                <tr class="{{ $now->between($shiftStartDateTime, $shiftEndDateTime) ? 'table-danger' : '' }} shift-row {{ $isPast ? 'past-shift' : 'upcoming-shift' }}">
                                                    <td>{{ $shift->formatted_date }}</td>
                                                    <td><span class="text-{{ $now->between($shiftStartDateTime, $shiftEndDateTime) ? 'danger' : 'success' }} fw-bold">{{ $shift->start_time }} - {{ $shift->end_time }}</span></td>
                                                    <td>
                                                        <span class="badge bg-{{ $statusClass }}">
                                                            {{ $statusLabel }}
                                                        </span>
                                                    </td>
                                                    <td><small class="text-muted">{{ $shift->notes ?? 'Geen notities' }}</small></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            i@else
                                <div class="p-5 text-center">
                                    <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                                    <h5>Je hebt geen aankomende shifts ingepland</h5>
                                    <p class="text-muted">Controleer de planning voor beschikbare shifts</p>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-light border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">Beschikbaarheid: </span>
                                    @if(isset($availabilityCount) && $availabilityCount > 0)
                                        <span class="badge bg-success">{{ $availabilityCount }} tijdslots ingesteld</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Nog niet ingesteld</span>
                                    @endif
                                </div>
                                <a href="{{ route('admin.schedule.availability', $isDj && !($isAdmin || $isBeheer) ? ['user_id' => Auth::id()] : []) }}" class="btn btn-primary">
                                    <i class="fas fa-clock me-1"></i> Beschikbaarheid beheren
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Content Row -->
        <div class="col-12">
            <div class="row g-4">
                <!-- Recent news articles -->
                @if($isRedactie || $isAdmin || $isBeheer)
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header border-0 bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 py-2"><i class="fas fa-newspaper me-2"></i> Recente nieuwsartikelen</h5>
                            <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Nieuw artikel
                            </a>
                        </div>
                        <div class="card-body p-0">
                            @if(isset($recentNews) && $recentNews->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <tbody>
                                            @foreach($recentNews as $news)
                                                <tr>
                                                    <td class="ps-3">
                                                        <h6 class="mb-1">{{ $news->title }}</h6>
                                                        <small class="text-muted">{{ $news->published_at ? $news->published_at->format('d-m-Y') : 'Niet gepubliceerd' }}</small>
                                                    </td>
                                                    <td class="text-end pe-3">
                                                        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit me-1"></i> Bewerken
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-5 text-center">
                                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                    <h5>Geen nieuwsartikelen gevonden</h5>
                                    <p class="text-muted">Maak je eerste nieuwsartikel aan</p>
                                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Nieuw artikel
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quick actions -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header border-0 bg-primary bg-opacity-10">
                            <h5 class="mb-0 py-2"><i class="fas fa-bolt me-2"></i> Snelle acties</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @if($isAdmin || $isBeheer)
                                <div class="col-md-6">
                                    <a href="{{ route('admin.programs.create') }}" class="card text-decoration-none h-100 shadow-sm">
                                        <div class="card-body p-4 text-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 mx-auto mb-3" style="width: fit-content;">
                                                <i class="fas fa-broadcast-tower fa-2x text-primary"></i>
                                            </div>
                                            <h5 class="mb-0">Nieuw programma</h5>
                                        </div>
                                    </a>
                                </div>
                                @endif

                                @if($isRedactie || $isAdmin || $isBeheer)
                                <div class="col-md-6">
                                    <a href="{{ route('admin.news.create') }}" class="card text-decoration-none h-100 shadow-sm">
                                        <div class="card-body p-4 text-center">
                                            <div class="rounded-circle bg-info bg-opacity-10 p-3 mx-auto mb-3" style="width: fit-content;">
                                                <i class="fas fa-newspaper fa-2x text-info"></i>
                                            </div>
                                            <h5 class="mb-0">Nieuw artikel</h5>
                                        </div>
                                    </a>
                                </div>
                                @endif

                                @if($isDj || $isAdmin || $isBeheer)
                                <div class="col-md-6">
                                    <a href="{{ route('admin.schedule.availability', $isDj && !($isAdmin || $isBeheer) ? ['user_id' => Auth::id()] : []) }}" class="card text-decoration-none h-100 shadow-sm">
                                        <div class="card-body p-4 text-center">
                                            <div class="rounded-circle bg-warning bg-opacity-10 p-3 mx-auto mb-3" style="width: fit-content;">
                                                <i class="fas fa-clock fa-2x text-warning"></i>
                                            </div>
                                            <h5 class="mb-0">Beschikbaarheid</h5>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('admin.schedule.index') }}" class="card text-decoration-none h-100 shadow-sm">
                                        <div class="card-body p-4 text-center">
                                            <div class="rounded-circle bg-success bg-opacity-10 p-3 mx-auto mb-3" style="width: fit-content;">
                                                <i class="fas fa-calendar-alt fa-2x text-success"></i>
                                            </div>
                                            <h5 class="mb-0">Planning bekijken</h5>
                                        </div>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Song Requests -->
                @if($isDj || $isAdmin || $isBeheer)
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header border-0 bg-danger bg-opacity-10 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 py-2"><i class="fas fa-music me-2"></i> Verzoeknummers <small class="text-muted ms-2">(live updates)</small></h5>
                            <div class="d-flex align-items-center">
                                <div class="badge bg-danger me-2" id="songRequestCount">{{ $pendingSongRequestsCount }}</div>
                                <a href="{{ route('admin.song-requests.index') }}" class="btn btn-sm btn-outline-danger">
                                    Beheer verzoeknummers
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="song-requests-container">
                                @if(isset($recentSongRequests) && $recentSongRequests->count() > 0)
                                    <div class="list-group list-group-flush" id="song-requests-list">
                                        @foreach($recentSongRequests as $request)
                                            <div class="list-group-item border-0 song-request-item" data-id="{{ $request->id }}">
                                                <div class="d-flex w-100 justify-content-between mb-1">
                                                    <h6 class="mb-1 fw-bold">{{ $request->artist }} - {{ $request->song_title }}</h6>
                                                    <small class="text-muted">{{ $request->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-1">Aanvrager: {{ $request->name }}</p>
                                                @if($request->message)
                                                    <p class="mb-1 text-muted small">{{ Str::limit($request->message, 60) }}</p>
                                                @endif
                                                <div class="d-flex justify-content-end mt-2">
                                                    <form action="{{ route('admin.song-requests.update-status', $request->id) }}" method="POST" class="song-request-form me-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check me-1"></i> Goedkeuren
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.song-requests.update-status', $request->id) }}" method="POST" class="song-request-form me-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="played">
                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-play me-1"></i> Markeer als gespeeld
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.song-requests.update-status', $request->id) }}" method="POST" class="song-request-form">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-times me-1"></i> Afwijzen
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center p-5" id="no-song-requests">
                                        <i class="fas fa-music fa-3x text-muted mb-3"></i>
                                        <h5>Geen verzoeknummers</h5>
                                        <p class="text-muted">Hier verschijnen nieuwe verzoeknummers in real-time</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
@if(isset($nextShow) && isset($timeToNextShow))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nextShowTime = new Date(document.getElementById('next-show-time').value);

        function updateCountdown() {
            const now = new Date();
            const diff = Math.floor((nextShowTime - now) / 1000);

            if (diff <= 0) {
                document.getElementById('days-count').textContent = '0';
                document.getElementById('hours-count').textContent = '0';
                document.getElementById('minutes-count').textContent = '0';
                return;
            }

            const days = Math.floor(diff / 86400);
            const hours = Math.floor((diff % 86400) / 3600);
            const minutes = Math.floor((diff % 3600) / 60);

            document.getElementById('days-count').textContent = days;
            document.getElementById('hours-count').textContent = hours;
            document.getElementById('minutes-count').textContent = minutes;
        }

        // Update every minute
        updateCountdown();
        setInterval(updateCountdown, 60000);
    });
</script>
@endif

@if(isset($upcomingShifts) && $upcomingShifts->count() > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterAll = document.getElementById('filter-all');
        const filterUpcoming = document.getElementById('filter-upcoming');
        const pastShifts = document.querySelectorAll('.past-shift');

        // Filter functionality
        filterAll.addEventListener('click', function() {
            filterAll.classList.add('active');
            filterUpcoming.classList.remove('active');
            pastShifts.forEach(shift => shift.style.display = '');
        });

        filterUpcoming.addEventListener('click', function() {
            filterUpcoming.classList.add('active');
            filterAll.classList.remove('active');
            pastShifts.forEach(shift => shift.style.display = 'none');
        });
    });
</script>
@endif

@if($isDj || $isAdmin || $isBeheer)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Song request notification when new ones arrive
        let currentSongRequestIds = [];
        const songRequestsList = document.getElementById('song-requests-list');
        const noSongRequests = document.getElementById('no-song-requests');
        const songRequestContainer = document.getElementById('song-requests-container');
        const songRequestCount = document.getElementById('songRequestCount');

        // Initialize current song request IDs
        document.querySelectorAll('.song-request-item').forEach(item => {
            currentSongRequestIds.push(parseInt(item.dataset.id));
        });

        // Track form submissions to prevent duplicate requests
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('song-request-form')) {
                e.preventDefault();
                const form = e.target;
                const requestItem = form.closest('.song-request-item');
                const requestId = requestItem.dataset.id;
                const formData = new FormData(form);
                const url = form.getAttribute('action');

                // Disable buttons in this request item
                const buttons = requestItem.querySelectorAll('button');
                buttons.forEach(button => button.disabled = true);

                // Add loading spinner
                buttons.forEach(button => {
                    const icon = button.querySelector('i');
                    icon.className = 'fas fa-spinner fa-spin';
                });

                // Send the form data
                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Remove the request item with a fade out effect
                        requestItem.style.opacity = '0';
                        setTimeout(() => {
                            requestItem.remove();

                            // Remove from tracking array
                            const index = currentSongRequestIds.indexOf(parseInt(requestId));
                            if (index > -1) {
                                currentSongRequestIds.splice(index, 1);
                            }

                            // Check if we need to show the "no requests" message
                            if (songRequestsList && songRequestsList.children.length === 0) {
                                if (noSongRequests) {
                                    noSongRequests.style.display = 'block';
                                } else {
                                    // Create the "no requests" message if it doesn't exist
                                    const noRequestsDiv = document.createElement('div');
                                    noRequestsDiv.id = 'no-song-requests';
                                    noRequestsDiv.className = 'text-center p-5';
                                    noRequestsDiv.innerHTML = `
                                        <i class="fas fa-music fa-3x text-muted mb-3"></i>
                                        <h5>Geen verzoeknummers</h5>
                                        <p class="text-muted">Hier verschijnen nieuwe verzoeknummers in real-time</p>
                                    `;
                                    songRequestContainer.appendChild(noRequestsDiv);
                                }
                            }

                            // Update the counter
                            updateSongRequestCount();
                        }, 300);
                    } else {
                        // Re-enable buttons
                        buttons.forEach(button => button.disabled = false);

                        // Restore icons
                        const approveButton = requestItem.querySelector('button.btn-success i');
                        if (approveButton) approveButton.className = 'fas fa-check me-1';

                        const playButton = requestItem.querySelector('button.btn-primary i');
                        if (playButton) playButton.className = 'fas fa-play me-1';

                        const rejectButton = requestItem.querySelector('button.btn-outline-danger i');
                        if (rejectButton) rejectButton.className = 'fas fa-times me-1';

                        alert('Er is een fout opgetreden bij het verwerken van het verzoeknummer.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Re-enable buttons
                    buttons.forEach(button => button.disabled = false);

                    // Restore icons
                    const approveButton = requestItem.querySelector('button.btn-success i');
                    if (approveButton) approveButton.className = 'fas fa-check me-1';

                    const playButton = requestItem.querySelector('button.btn-primary i');
                    if (playButton) playButton.className = 'fas fa-play me-1';

                    const rejectButton = requestItem.querySelector('button.btn-outline-danger i');
                    if (rejectButton) rejectButton.className = 'fas fa-times me-1';
                });
            }
        });

        // Poll for new song requests every 10 seconds
        function updateSongRequests() {
            fetch('{{ route('admin.song-requests.recent') }}')
                .then(response => response.json())
                .then(data => {
                    // Update the count
                    if (songRequestCount) {
                        songRequestCount.textContent = data.count;
                    }

                    // Check if we have any requests
                    if (data.requests && data.requests.length > 0) {
                        // Hide the "no requests" message if it exists
                        if (noSongRequests) {
                            noSongRequests.style.display = 'none';
                        }

                        // Create the list if it doesn't exist
                        if (!songRequestsList) {
                            const newList = document.createElement('div');
                            newList.id = 'song-requests-list';
                            newList.className = 'list-group list-group-flush';
                            songRequestContainer.innerHTML = '';
                            songRequestContainer.appendChild(newList);
                        }

                        // Add new requests
                        data.requests.forEach(request => {
                            if (!currentSongRequestIds.includes(request.id)) {
                                // Add to tracking array
                                currentSongRequestIds.push(request.id);

                                // Create new request item
                                const newRequestItem = document.createElement('div');
                                newRequestItem.className = 'list-group-item border-0 song-request-item';
                                newRequestItem.dataset.id = request.id;
                                newRequestItem.style.opacity = '0'; // Start transparent for fade-in

                                // Construct the content
                                newRequestItem.innerHTML = `
                                    <div class="d-flex w-100 justify-content-between mb-1">
                                        <h6 class="mb-1 fw-bold">${request.artist} - ${request.song_title}</h6>
                                        <small class="text-muted">${request.created_at}</small>
                                    </div>
                                    <p class="mb-1">Aanvrager: ${request.name}</p>
                                    ${request.message ? `<p class="mb-1 text-muted small">${request.message.length > 60 ? request.message.substring(0, 60) + '...' : request.message}</p>` : ''}
                                    <div class="d-flex justify-content-end mt-2">
                                        <form action="${request.status_url}" method="POST" class="song-request-form me-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check me-1"></i> Goedkeuren
                                            </button>
                                        </form>
                                        <form action="${request.status_url}" method="POST" class="song-request-form me-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="played">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fas fa-play me-1"></i> Markeer als gespeeld
                                            </button>
                                        </form>
                                        <form action="${request.status_url}" method="POST" class="song-request-form">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times me-1"></i> Afwijzen
                                            </button>
                                        </form>
                                    </div>
                                `;

                                // Add to the DOM at the beginning of the list
                                if (songRequestsList) {
                                    if (songRequestsList.firstChild) {
                                        songRequestsList.insertBefore(newRequestItem, songRequestsList.firstChild);
                                    } else {
                                        songRequestsList.appendChild(newRequestItem);
                                    }
                                } else {
                                    // If the list doesn't exist, create it
                                    const newList = document.createElement('div');
                                    newList.id = 'song-requests-list';
                                    newList.className = 'list-group list-group-flush';
                                    newList.appendChild(newRequestItem);

                                    songRequestContainer.innerHTML = '';
                                    songRequestContainer.appendChild(newList);
                                }

                                // Fade in the new item
                                setTimeout(() => {
                                    newRequestItem.style.transition = 'opacity 0.3s ease-in-out';
                                    newRequestItem.style.opacity = '1';
                                }, 10);

                                // Play a notification sound (optional)
                                playNotificationSound();
                            }
                        });
                    } else if (songRequestsList && songRequestsList.children.length === 0) {
                        // No requests and empty list, show the "no requests" message
                        if (noSongRequests) {
                            noSongRequests.style.display = 'block';
                        } else {
                            // Create the message if it doesn't exist
                            const noRequestsDiv = document.createElement('div');
                            noRequestsDiv.id = 'no-song-requests';
                            noRequestsDiv.className = 'text-center p-5';
                            noRequestsDiv.innerHTML = `
                                <i class="fas fa-music fa-3x text-muted mb-3"></i>
                                <h5>Geen verzoeknummers</h5>
                                <p class="text-muted">Hier verschijnen nieuwe verzoeknummers in real-time</p>
                            `;
                            songRequestContainer.innerHTML = '';
                            songRequestContainer.appendChild(noRequestsDiv);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error fetching song requests:', error);
                });
        }

        // Update the count when a request is processed
        function updateSongRequestCount() {
            fetch('{{ route('admin.song-requests.recent') }}')
                .then(response => response.json())
                .then(data => {
                    if (songRequestCount) {
                        songRequestCount.textContent = data.count;
                    }
                })
                .catch(error => {
                    console.error('Error updating song request count:', error);
                });
        }

        // Optional: Play a notification sound for new requests
        function playNotificationSound() {
            // Create audio element if one doesn't exist
            let audio = document.getElementById('notification-sound');
            if (!audio) {
                audio = document.createElement('audio');
                audio.id = 'notification-sound';
                audio.src = 'https://assets.mixkit.co/sfx/preview/mixkit-correct-answer-tone-2870.mp3'; // Replace with your own sound file
                audio.style.display = 'none';
                document.body.appendChild(audio);
            }

            // Play the sound
            audio.play().catch(e => {
                console.log('Could not play notification sound (browser may require user interaction first):', e);
            });
        }

        // Initial update
        updateSongRequests();

        // Set up polling interval for real-time updates
        setInterval(updateSongRequests, 10000); // Every 10 seconds
    });
</script>
@endif
@endpush
@endsection
