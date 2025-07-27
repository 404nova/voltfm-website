@extends('admin.layouts.app')

@section('title', 'DJ Beschikbaarheid')

@section('actions')
    <div>
        <a href="{{ route('admin.schedule.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-calendar-alt"></i> Terug naar Planning
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        @if($isAdmin || $isBeheer)
        <!-- Admin can select among all DJs -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Selecteer DJ
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($users as $user)
                            <a href="{{ route('admin.schedule.availability', ['user_id' => $user->id]) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
                                      {{ request()->input('user_id') == $user->id ? 'active' : '' }}">
                                <div>
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=c3f135&color=222" 
                                         alt="{{ $user->name }}" class="avatar" style="width: 32px; height: 32px;">
                                    {{ $user->name }}
                                </div>
                                <span class="badge bg-secondary rounded-pill">
                                    {{ $availabilities->has($user->id) ? count($availabilities[$user->id]) : 0 }} tijdslots
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
        @else
        <!-- DJs can only manage their own availability -->
        <div class="col-md-12">
        @endif
            @if(request()->has('user_id'))
                @php
                    $selectedUser = $users->firstWhere('id', request()->input('user_id'));
                    $userAvailabilities = $availabilities->has($selectedUser->id) ? $availabilities[$selectedUser->id] : collect([]);
                @endphp
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedUser->name) }}&background=c3f135&color=222" 
                                 alt="{{ $selectedUser->name }}" class="avatar me-2">
                            @if($isDj && !$isAdmin && !$isBeheer)
                                Mijn Beschikbaarheid
                            @else
                                Beschikbaarheid van {{ $selectedUser->name }}
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" 
                                data-bs-toggle="modal" data-bs-target="#addAvailabilityModal">
                            <i class="fas fa-plus"></i> Toevoegen
                        </button>
                    </div>
                    <div class="card-body">
                        @if($userAvailabilities->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Dag</th>
                                            <th>Tijd</th>
                                            <th>Acties</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($userAvailabilities->sortBy('day_of_week') as $availability)
                                            <tr>
                                                <td>{{ $availability->day_name }}</td>
                                                <td>{{ $availability->start_time }} - {{ $availability->end_time }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger delete-availability"
                                                            data-id="{{ $availability->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Geen beschikbaarheid ingesteld. Gebruik de knop hierboven om beschikbaarheid toe te voegen.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Add Availability Modal -->
                <div class="modal fade" id="addAvailabilityModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.schedule.availability.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                                <div class="modal-header">
                                    <h5 class="modal-title">Beschikbaarheid Toevoegen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="day_of_week" class="form-label">Dag</label>
                                        <select name="availabilities[0][day]" id="day_of_week" class="form-select" required>
                                            @foreach($daysOfWeek as $index => $day)
                                                <option value="{{ $index }}">{{ $day }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="start_time" class="form-label">Starttijd</label>
                                            <select name="availabilities[0][start]" id="start_time" class="form-select" required>
                                                @foreach($timeSlots as $time)
                                                    <option value="{{ $time }}">{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="end_time" class="form-label">Eindtijd</label>
                                            <select name="availabilities[0][end]" id="end_time" class="form-select" required>
                                                @foreach($timeSlots as $time)
                                                    <option value="{{ $time }}">{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                    <button type="submit" class="btn btn-primary">Opslaan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header">
                        <span>DJ Beschikbaarheid</span>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            @if($isAdmin || $isBeheer)
                                Selecteer een DJ aan de linkerkant om beschikbaarheid te beheren.
                            @else
                                Er is geen DJ geselecteerd. Ga terug naar het dashboard.
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Time validation - end time must be after start time
        const startTimeSelect = document.getElementById('start_time');
        const endTimeSelect = document.getElementById('end_time');
        
        if (startTimeSelect && endTimeSelect) {
            startTimeSelect.addEventListener('change', function() {
                const startIndex = this.selectedIndex;
                
                // Reset end time options
                for (let i = 0; i < endTimeSelect.options.length; i++) {
                    endTimeSelect.options[i].disabled = i <= startIndex;
                }
                
                // If current end time is now invalid, update it
                if (endTimeSelect.selectedIndex <= startIndex) {
                    endTimeSelect.selectedIndex = startIndex + 1;
                }
            });
            
            // Trigger on load
            startTimeSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection 