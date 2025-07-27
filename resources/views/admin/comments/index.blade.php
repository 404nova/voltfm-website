@extends('admin.layouts.app')

@section('title', 'Reacties Beheer')

@section('actions')
<a href="{{ route('admin.comments.pending') }}" class="btn btn-warning">
    <i class="fas fa-clock me-1"></i> Wachtende Reacties
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Alle Reacties</span>
    </div>
    <div class="card-body p-0">
        @if($comments->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Artikel</th>
                            <th>Naam</th>
                            <th>E-mail</th>
                            <th>Reactie</th>
                            <th>Status</th>
                            <th>Datum</th>
                            <th width="120">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                            <tr>
                                <td>
                                    <a href="{{ route('news.show', $comment->news->slug) }}" target="_blank">
                                        {{ Str::limit($comment->news->title, 30) }}
                                    </a>
                                </td>
                                <td>{{ $comment->name }}</td>
                                <td>{{ $comment->email }}</td>
                                <td>{{ Str::limit($comment->content, 50) }}</td>
                                <td>
                                    @if($comment->approved)
                                        <span class="badge bg-success">Goedgekeurd</span>
                                    @else
                                        <span class="badge bg-warning">Wachtend</span>
                                    @endif
                                </td>
                                <td>{{ $comment->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if(!$comment->approved)
                                            <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $comment->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $comment->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $comment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $comment->id }}">Reactie verwijderen</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Weet je zeker dat je deze reactie wilt verwijderen?</p>
                                                    <p><strong>Naam:</strong> {{ $comment->name }}</p>
                                                    <p><strong>Reactie:</strong> {{ Str::limit($comment->content, 100) }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
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
            
            <div class="d-flex justify-content-center mt-4 mb-4">
                {{ $comments->links() }}
            </div>
        @else
            <div class="p-4 text-center">
                <p>Er zijn nog geen reacties.</p>
            </div>
        @endif
    </div>
</div>
@endsection 