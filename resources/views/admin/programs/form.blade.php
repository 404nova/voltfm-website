@extends('admin.layouts.app')

@section('title', isset($program) ? 'Programma Bewerken' : 'Nieuw Programma')

@section('actions')
    <a href="{{ route('admin.programs.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Terug naar overzicht
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>{{ isset($program) ? 'Programma Bewerken: ' . $program->title : 'Nieuw Programma' }}</span>
    </div>
    <div class="card-body">
        <form action="{{ isset($program) ? route('admin.programs.update', $program->id) : route('admin.programs.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($program))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-8">
                    <!-- Basic Info -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Titel</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" 
                               value="{{ old('title', isset($program) ? $program->title : '') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Beschrijving</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" 
                                  rows="5">{{ old('description', isset($program) ? $program->description : '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="presenter" class="form-label">Presentator</label>
                        <input type="text" class="form-control @error('presenter') is-invalid @enderror" 
                               id="presenter" name="presenter" 
                               value="{{ old('presenter', isset($program) ? $program->presenter : '') }}">
                        @error('presenter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Schedule -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Planning</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="time_start" class="form-label">Starttijd</label>
                                        <input type="time" class="form-control @error('time_start') is-invalid @enderror" 
                                               id="time_start" name="time_start" 
                                               value="{{ old('time_start', isset($program) ? \Carbon\Carbon::parse($program->time_start)->format('H:i') : '') }}">
                                        @error('time_start')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="time_end" class="form-label">Eindtijd</label>
                                        <input type="time" class="form-control @error('time_end') is-invalid @enderror" 
                                               id="time_end" name="time_end" 
                                               value="{{ old('time_end', isset($program) ? \Carbon\Carbon::parse($program->time_end)->format('H:i') : '') }}">
                                        @error('time_end')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="week_number" class="form-label">Weeknummer</label>
                                <select class="form-select @error('week_number') is-invalid @enderror" id="week_number" name="week_number" required>
                                    @php
                                        $currentWeek = now()->week;
                                        $startWeek = $currentWeek - 2;
                                        $endWeek = $currentWeek + 8;
                                        if ($startWeek < 1) $startWeek = 1;
                                        if ($endWeek > 53) $endWeek = 53;
                                    @endphp
                                    
                                    <option value="{{ $currentWeek }}" {{ old('week_number', isset($program) ? $program->week_number : $currentWeek) == $currentWeek ? 'selected' : '' }}>
                                        Huidige week ({{ $currentWeek }})
                                    </option>
                                    
                                    <optgroup label="Vorige weken">
                                        @for ($i = $startWeek; $i < $currentWeek; $i++)
                                            <option value="{{ $i }}" {{ old('week_number', isset($program) ? $program->week_number : null) == $i ? 'selected' : '' }}>
                                                Week {{ $i }}
                                            </option>
                                        @endfor
                                    </optgroup>
                                    
                                    <optgroup label="Komende weken">
                                        @for ($i = $currentWeek + 1; $i <= $endWeek; $i++)
                                            <option value="{{ $i }}" {{ old('week_number', isset($program) ? $program->week_number : null) == $i ? 'selected' : '' }}>
                                                Week {{ $i }}
                                            </option>
                                        @endfor
                                    </optgroup>
                                </select>
                                <div class="form-text">
                                    Selecteer de week waarvoor dit programma gepland staat. Iedere week heeft een unieke programmering.
                                </div>
                                @error('week_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block">Dagen</label>
                                <div class="btn-group d-flex flex-wrap" role="group">
                                    @php
                                        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                        $dayLabels = [
                                            'monday' => 'Maandag',
                                            'tuesday' => 'Dinsdag',
                                            'wednesday' => 'Woensdag',
                                            'thursday' => 'Donderdag',
                                            'friday' => 'Vrijdag',
                                            'saturday' => 'Zaterdag',
                                            'sunday' => 'Zondag'
                                        ];
                                        $selectedDays = old('days', isset($program) ? $program->days : []);
                                    @endphp
                                    
                                    @foreach($days as $day)
                                        <div class="form-check form-check-inline mb-2">
                                            <input class="form-check-input" type="checkbox" 
                                                   id="day_{{ $day }}" name="days[]" value="{{ $day }}"
                                                   {{ is_array($selectedDays) && in_array($day, $selectedDays) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="day_{{ $day }}">{{ $dayLabels[$day] }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('days')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Image Upload -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Afbeelding</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($program) && $program->image)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('storage/' . $program->image) }}" 
                                             alt="{{ $program->title }}" 
                                             class="img-fluid img-thumbnail rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">{{ isset($program) && $program->image ? 'Vervang afbeelding' : 'Upload afbeelding' }}</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Aanbevolen formaat: 400x400 pixels, Vierkant.</div>
                            </div>
                            
                            @if(isset($program) && $program->image)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                    <label class="form-check-label" for="remove_image">
                                        Verwijder huidige afbeelding
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Status Toggle -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1"
                                       {{ old('active', isset($program) && $program->active ? true : false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Actief</label>
                            </div>
                            <div class="form-text">Inactieve programma's worden niet weergegeven op de website.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.programs.index') }}" class="btn btn-outline-secondary me-2">Annuleren</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> {{ isset($program) ? 'Bijwerken' : 'Opslaan' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 