@extends('admin.layouts.app')

@section('title', isset($news) ? 'Artikel Bewerken' : 'Nieuw Artikel')

@section('actions')
    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Terug naar overzicht
    </a>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#content').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            
            // Published at datetime picker
            $('#published_at_date').on('change', function() {
                updatePublishedAtValue();
            });
            
            $('#published_at_time').on('change', function() {
                updatePublishedAtValue();
            });
            
            function updatePublishedAtValue() {
                const date = $('#published_at_date').val();
                const time = $('#published_at_time').val() || '00:00';
                
                if (date) {
                    $('#published_at').val(`${date} ${time}`);
                } else {
                    $('#published_at').val('');
                }
            }
            
            // Initialize values from existing
            @if(old('published_at', isset($news) ? $news->published_at : null))
                const publishedAt = new Date('{{ old('published_at', isset($news) ? $news->published_at : '') }}');
                const formattedDate = publishedAt.toISOString().split('T')[0];
                const hours = publishedAt.getHours().toString().padStart(2, '0');
                const minutes = publishedAt.getMinutes().toString().padStart(2, '0');
                
                $('#published_at_date').val(formattedDate);
                $('#published_at_time').val(`${hours}:${minutes}`);
            @endif
        });
    </script>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>{{ isset($news) ? 'Artikel Bewerken: ' . $news->title : 'Nieuw Artikel' }}</span>
    </div>
    <div class="card-body">
        <form action="{{ isset($news) ? route('admin.news.update', $news->id) : route('admin.news.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($news))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-8">
                    <!-- Basic Info -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Titel</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" 
                               value="{{ old('title', isset($news) ? $news->title : '') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Samenvatting</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" name="excerpt" 
                                  rows="3">{{ old('excerpt', isset($news) ? $news->excerpt : '') }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Een korte samenvatting van het artikel. Dit wordt getoond in overzichten.</div>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Categorie</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id">
                            <option value="">Selecteer categorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ (old('category_id', isset($news) ? $news->category_id : '')) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <select class="form-select @error('tags') is-invalid @enderror" 
                                id="tags" name="tags[]" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" 
                                    {{ (in_array($tag->id, old('tags', isset($selectedTags) ? $selectedTags : []))) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Houd Ctrl ingedrukt om meerdere tags te selecteren.</div>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Inhoud</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content">{{ old('content', isset($news) ? $news->content : '') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Publication Settings -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Publicatie</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="author" class="form-label">Auteur</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                       id="author" name="author" 
                                       value="{{ old('author', isset($news) ? $news->author : auth()->user()->name) }}">
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <input type="hidden" id="published_at" name="published_at" value="{{ old('published_at', isset($news) ? $news->published_at : '') }}">
                            
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="published_at_date" class="form-label">Publicatiedatum</label>
                                        <input type="date" class="form-control @error('published_at') is-invalid @enderror" 
                                               id="published_at_date">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="published_at_time" class="form-label">Tijd</label>
                                        <input type="time" class="form-control" 
                                               id="published_at_time">
                                    </div>
                                </div>
                            </div>
                            @error('published_at')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-text mb-3">Laat leeg om het artikel als concept op te slaan.</div>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1"
                                       {{ old('active', isset($news) && $news->active ? true : false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Actief</label>
                            </div>
                            <div class="form-text">Inactieve artikelen worden niet weergegeven op de website.</div>
                        </div>
                    </div>
                    
                    <!-- Image Upload -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Afbeelding</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($news) && $news->image)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('storage/' . $news->image) }}" 
                                             alt="{{ $news->title }}" 
                                             class="img-fluid img-thumbnail rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">{{ isset($news) && $news->image ? 'Vervang afbeelding' : 'Upload afbeelding' }}</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Aanbevolen formaat: 1200x630 pixels.</div>
                            </div>
                            
                            @if(isset($news) && $news->image)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                    <label class="form-check-label" for="remove_image">
                                        Verwijder huidige afbeelding
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary me-2">Annuleren</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> {{ isset($news) ? 'Bijwerken' : 'Opslaan' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 