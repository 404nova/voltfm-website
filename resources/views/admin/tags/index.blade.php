@extends('admin.layouts.app')

@section('title', 'Nieuwstags Beheer')

@section('actions')
<a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Nieuwe Tag
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>Alle Nieuwstags</span>
    </div>
    <div class="card-body p-0">
        @if($tags->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Slug</th>
                            <th>Beschrijving</th>
                            <th>Aantal artikelen</th>
                            <th width="120">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $tag->name }}</td>
                                <td><code>{{ $tag->slug }}</code></td>
                                <td>{{ Str::limit($tag->description, 50) }}</td>
                                <td>{{ $tag->news->count() }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tag->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $tag->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tag->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $tag->id }}">Bevestig verwijdering</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($tag->news->count() > 0)
                                                        <div class="alert alert-warning">
                                                            Deze tag is gekoppeld aan {{ $tag->news->count() }} nieuwsartikel(en). Bij verwijdering wordt deze koppeling verbroken.
                                                        </div>
                                                    @endif
                                                    Weet je zeker dat je de tag <strong>{{ $tag->name }}</strong> wilt verwijderen?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                                    <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" class="d-inline">
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
                {{ $tags->links() }}
            </div>
        @else
            <div class="p-4 text-center">
                <p class="mb-0">Geen tags gevonden</p>
                <a href="{{ route('admin.tags.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-1"></i> Maak je eerste tag aan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 