@extends('admin.layouts.app')

@section('title', 'Categorie Bewerken')

@section('actions')
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-1"></i> Terug naar Overzicht
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>Categorie Bewerken: {{ $category->name }}</span>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Naam <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Beschrijving</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="color" class="form-label">Kleur</label>
                <div class="input-group">
                    <input type="color" class="form-control form-control-color" id="colorPicker" value="{{ old('color', $category->color ?? '#3498db') }}">
                    <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color', $category->color ?? '#3498db') }}">
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

@if($category->news->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <span>Gekoppelde Nieuwsartikelen</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Publicatiedatum</th>
                        <th width="80">Actie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->news as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->published_at ? $article->published_at->format('d-m-Y H:i') : 'Niet gepubliceerd' }}</td>
                        <td>
                            <a href="{{ route('admin.news.edit', $article->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
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