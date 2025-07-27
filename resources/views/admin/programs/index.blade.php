@extends('admin.layouts.app')

@section('title', 'Programma\'s Beheer')

@section('actions')
<a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Nieuw Programma
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Programmering{{ $weekFilter == 'all' ? '' : ': Week ' . $weekFilter }}</span>
        <div class="d-flex align-items-center">
            <form action="{{ route('admin.programs.index') }}" method="GET" class="d-flex align-items-center">
                <label for="weekFilter" class="me-2">Selecteer week:</label>
                <select name="week" id="weekFilter" class="form-select form-select-sm" style="width: auto" onchange="this.form.submit()">
                    <option value="all" {{ $weekFilter == 'all' ? 'selected' : '' }}>Alle weken</option>
                    <option value="{{ $currentWeek }}" {{ $weekFilter == $currentWeek ? 'selected' : '' }} class="fw-bold">
                        Huidige week ({{ $currentWeek }})
                    </option>
                    
                    @foreach($weekNumbers as $weekNumber)
                        @if($weekNumber != $currentWeek)
                            <option value="{{ $weekNumber }}" {{ $weekFilter == $weekNumber ? 'selected' : '' }}>
                                Week {{ $weekNumber }}{{ $weekNumber < $currentWeek ? ' (Voorbij)' : '' }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    
    <div class="card-body p-0">
        @if($programs->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="80">Afbeelding</th>
                            <th>Titel</th>
                            <th>Presentator</th>
                            <th>Tijd</th>
                            <th>Dagen</th>
                            <th>Week</th>
                            <th>Status</th>
                            <th width="120">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $program)
                            <tr>
                                <td>
                                    @if($program->image)
                                        <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="text-center text-muted" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $program->title }}</td>
                                <td>{{ $program->presenter }}</td>
                                <td>{{ \Carbon\Carbon::parse($program->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($program->time_end)->format('H:i') }}</td>
                                <td>
                                    @foreach($program->days as $day)
                                        <span class="badge bg-light text-dark me-1">{{ ucfirst($day) }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if($program->week_number == $currentWeek)
                                        <span class="badge bg-success">Week {{ $program->week_number }} (Huidige)</span>
                                    @elseif($program->week_number < $currentWeek)
                                        <span class="badge bg-secondary">Week {{ $program->week_number }} (Voorbij)</span>
                                    @else
                                        <span class="badge bg-primary">Week {{ $program->week_number }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($program->active)
                                        <span class="badge bg-success">Actief</span>
                                    @else
                                        <span class="badge bg-secondary">Inactief</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.programs.edit', $program->id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $program->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $program->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $program->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $program->id }}">Bevestig verwijdering</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Weet je zeker dat je het programma <strong>{{ $program->title }}</strong> wilt verwijderen?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                                    <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Verwijderen</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center">
                @if($weekFilter != 'all')
                    <p class="mb-0">Geen programma's gevonden voor week {{ $weekFilter }}</p>
                @else
                    <p class="mb-0">Geen programma's gevonden</p>
                @endif
                <a href="{{ route('admin.programs.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-1"></i> Maak een nieuw programma aan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 