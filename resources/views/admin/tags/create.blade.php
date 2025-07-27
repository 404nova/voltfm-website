@extends('admin.layouts.app')

@section('title', 'Nieuwe Tag Toevoegen')

@section('actions')
<a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-1"></i> Terug naar Overzicht
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>Nieuwe Tag</span>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.tags.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Naam <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">De slug wordt automatisch gegenereerd op basis van de naam.</small>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Beschrijving</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
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