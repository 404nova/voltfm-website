@extends('admin.layouts.app')

@section('title', 'Nieuwsartikelen Beheer')

@section('actions')
<a href="{{ route('admin.news.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Nieuw Artikel
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>Alle Nieuwsartikelen</span>
    </div>
    <div class="card-body p-0">
        @if($news->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="80">Afbeelding</th>
                            <th>Titel</th>
                            <th>Auteur</th>
                            <th>Publicatiedatum</th>
                            <th>Status</th>
                            <th width="120">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $article)
                            <tr>
                                <td>
                                    @if($article->image)
                                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="text-center text-muted" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->author->name }}</td>
                                <td>{{ $article->published_at ? $article->published_at->format('d-m-Y H:i') : 'Niet gepubliceerd' }}</td>
                                <td>
                                    @if($article->published_at && $article->published_at->isPast())
                                        <span class="badge bg-success">Gepubliceerd</span>
                                    @elseif($article->published_at && $article->published_at->isFuture())
                                        <span class="badge bg-info">Gepland</span>
                                    @else
                                        <span class="badge bg-secondary">Concept</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.news.edit', $article->id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $article->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $article->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $article->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $article->id }}">Bevestig verwijdering</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Weet je zeker dat je het artikel <strong>{{ $article->title }}</strong> wilt verwijderen?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                                    <form action="{{ route('admin.news.destroy', $article->id) }}" method="POST" class="d-inline">
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

            <div class="d-flex justify-content-center mt-4">
                {{ $news->links() }}
            </div>
        @else
            <div class="p-4 text-center">
                <p class="mb-0">Geen nieuwsartikelen gevonden</p>
                <a href="{{ route('admin.news.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-1"></i> Maak je eerste artikel aan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
