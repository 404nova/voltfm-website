@extends('admin.layouts.app')

@section('title', 'Vacature aanmaken')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Nieuwe vacature</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.vacancies.store') }}">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Titel</label>
                <input type="text" name="title" class="form-control" id="title" required value="{{ old('title') }}">
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Beschrijving</label>
                <textarea name="description" class="form-control" id="description" rows="6" required>{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" {{ old('is_active') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                    Actief
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Aanmaken</button>
        </form>
    </div>
</div>
@endsection

