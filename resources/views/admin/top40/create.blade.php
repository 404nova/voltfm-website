@extends('admin.layouts.app')

@section('title', 'Nieuw TOP40 Nummer')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nieuw TOP40 Nummer Toevoegen</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.top40.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="position">Positie</label>
                            <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}" required min="1" max="50">
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Titel</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="artist">Artiest</label>
                            <input type="text" class="form-control @error('artist') is-invalid @enderror" id="artist" name="artist" value="{{ old('artist') }}" required>
                            @error('artist')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="art_url">Album Art URL</label>
                            <input type="url" class="form-control @error('art_url') is-invalid @enderror" id="art_url" name="art_url" value="{{ old('art_url') }}" required>
                            @error('art_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="trend_direction">Trend Richting</label>
                            <select class="form-control @error('trend_direction') is-invalid @enderror" id="trend_direction" name="trend_direction" required>
                                <option value="none" {{ old('trend_direction') == 'none' ? 'selected' : '' }}>Geen</option>
                                <option value="up" {{ old('trend_direction') == 'up' ? 'selected' : '' }}>Omhoog</option>
                                <option value="down" {{ old('trend_direction') == 'down' ? 'selected' : '' }}>Omlaag</option>
                                <option value="new" {{ old('trend_direction') == 'new' ? 'selected' : '' }}>Nieuw</option>
                            </select>
                            @error('trend_direction')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="trend_value">Trend Waarde</label>
                            <input type="number" class="form-control @error('trend_value') is-invalid @enderror" id="trend_value" name="trend_value" value="{{ old('trend_value', 0) }}" required min="0">
                            @error('trend_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_new" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_new">Nieuw in de TOP40</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                            <a href="{{ route('admin.top40.index') }}" class="btn btn-secondary">Annuleren</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
