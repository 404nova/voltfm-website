@extends('admin.layouts.app')

@section('title', 'Tag Bewerken')

@section('actions')
<a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-1"></i> Terug naar Overzicht
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>Tag Bewerken: {{ $tag->name }}</span>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Naam <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tag->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">De slug wordt automatisch bijgewerkt als de naam wijzigt.</small>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Beschrijving</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $tag->description) }}</textarea>
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

@if($tag->news->count() > 0)
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
                    @foreach($tag->news as $article)
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