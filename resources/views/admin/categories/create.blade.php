@extends('admin.layouts.app')

@section('title', 'Nieuwe Categorie Toevoegen')

@section('actions')
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-1"></i> Terug naar Overzicht
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>Nieuwe Categorie</span>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Naam <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Beschrijving</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="color" class="form-label">Kleur</label>
                <div class="input-group">
                    <input type="color" class="form-control form-control-color" id="colorPicker" value="{{ old('color', '#3498db') }}">
                    <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color', '#3498db') }}">
                </div>
                <small class="form-text text-muted">Kies een kleur of geef een hexadecimale kleurcode op (bijv. #3498db)</small>
                @error('color')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Opslaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorPicker = document.getElementById('colorPicker');
        const colorInput = document.getElementById('color');
        
        // Sync color picker with text input
        colorPicker.addEventListener('input', function() {
            colorInput.value = this.value;
        });
        
        // Sync text input with color picker
        colorInput.addEventListener('input', function() {
            colorPicker.value = this.value;
        });
    });
</script>
@endsection 