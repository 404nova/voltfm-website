@extends('admin.layouts.app')

@section('title', 'DJ Toewijzingen')

@section('actions')
    <div>
        <a href="{{ route('admin.schedule.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-calendar-alt"></i> Terug naar Planning
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Nieuw DJ Shift Toewijzen
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.schedule.assignments.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_id" class="form-label">DJ Selecteren</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">Selecteer een DJ...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">Datum</label>
                            <input type="date" class="form-control" id="date" name="date" 
                                   min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Starttijd</label>
                                <select name="start_time" id="start_time" class="form-select" required>
                                    @foreach($timeSlots as $time)
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">Eindtijd</label>
                                <select name="end_time" id="end_time" class="form-select" required>
                                    @foreach($timeSlots as $time)
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Opmerkingen</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                            <div class="form-text">Optionele opmerkingen over deze shift (programma, thema, etc.)</div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">DJ Inplannen</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    DJ Beschikbaarheid
                </div>
                <div class="card-body">
                    <div id="availability-info">
                        <div class="alert alert-info">
                            Selecteer een DJ om beschikbaarheid te zien.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Aankomende DJ Toewijzingen
                </div>
                <div class="card-body">
                    @if($currentAssignments->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Datum</th>
                                        <th>Tijd</th>
                                        <th>DJ</th>
                                        <th>Opmerkingen</th>
                                        <th>Acties</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($currentAssignments as $assignment)
                                        <tr class="{{ $assignment->date->isPast() ? 'text-muted' : '' }}">
                                            <td>{{ $assignment->formatted_date ?? $assignment->date->format('d-m-Y') }}</td>
                                            <td>{{ $assignment->time_range ?? ($assignment->start_time . ' - ' . $assignment->end_time) }}</td>
                                            <td>
                                                @if($assignment->user)
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($assignment->user->name) }}&background=c3f135&color=222" 
                                                         alt="{{ $assignment->user->name }}" class="avatar me-2" style="width: 24px; height: 24px;">
                                                    {{ $assignment->user->name }}
                                                </div>
                                                @else
                                                <span class="text-danger">Onbekende gebruiker</span>
                                                @endif
                                            </td>
                                            <td>{{ $assignment->notes ?? '-' }}</td>
                                            <td>
                                                <form action="{{ route('admin.schedule.assignments.destroy', $assignment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Weet je zeker dat je deze toewijzing wilt verwijderen?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Geen aankomende DJ toewijzingen gevonden.
                        </div>
                    @endif
                </div>
            </div>
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
        
        // Load availability for selected DJ
        const userSelector = document.getElementById('user_id');
        const availabilityInfo = document.getElementById('availability-info');
        
        if (userSelector && availabilityInfo) {
            userSelector.addEventListener('change', function() {
                const userId = this.value;
                
                if (!userId) {
                    availabilityInfo.innerHTML = '<div class="alert alert-info">Selecteer een DJ om beschikbaarheid te zien.</div>';
                    return;
                }
                
                // Mock display of availability - in a real app this would be an AJAX call
                const users = {!! json_encode($users) !!};
                const user = users.find(u => u.id == userId);
                
                if (!user || !user.availabilities || user.availabilities.length === 0) {
                    availabilityInfo.innerHTML = `
                        <div class="alert alert-warning">
                            Geen beschikbaarheid ingesteld voor deze DJ.
                            <a href="{{ route('admin.schedule.availability') }}?user_id=${userId}" class="alert-link">
                                Beschikbaarheid instellen
                            </a>
                        </div>
                    `;
                    return;
                }
                
                // Display availability
                let html = '<div class="list-group">';
                const dayNames = ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag'];
                
                // Group by day
                const byDay = {};
                user.availabilities.forEach(a => {
                    if (!byDay[a.day_of_week]) {
                        byDay[a.day_of_week] = [];
                    }
                    byDay[a.day_of_week].push(a);
                });
                
                // Create list items for each day
                for (let i = 0; i < 7; i++) {
                    if (byDay[i] && byDay[i].length > 0) {
                        html += `
                            <div class="list-group-item">
                                <div class="fw-bold">${dayNames[i]}</div>
                                <div>
                        `;
                        
                        byDay[i].forEach(a => {
                            html += `<span class="badge bg-success me-1">${a.start_time} - ${a.end_time}</span>`;
                        });
                        
                        html += `
                                </div>
                            </div>
                        `;
                    }
                }
                
                html += '</div>';
                availabilityInfo.innerHTML = html;
            });
        }
    });
</script>
@endsection 