@extends('admin.layouts.app')

@section('title', 'Nieuwscategorieën Beheer')

@section('actions')
<a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Nieuwe Categorie
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>Alle Nieuwscategorieën</span>
    </div>
    <div class="card-body p-0">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Slug</th>
                            <th>Beschrijving</th>
                            <th>Kleur</th>
                            <th>Aantal artikelen</th>
                            <th width="120">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>
                                    @if($category->color)
                                        <div class="d-flex align-items-center">
                                            <div style="width: 20px; height: 20px; border-radius: 4px; background-color: {{ $category->color }}; margin-right: 8px;"></div>
                                            <span>{{ $category->color }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $category->news->count() }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Bevestig verwijdering</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($category->news->count() > 0)
                                                        <div class="alert alert-warning">
                                                            Deze categorie is gekoppeld aan {{ $category->news->count() }} nieuwsartikel(en). Bij verwijdering wordt deze koppeling verbroken.
                                                        </div>
                                                    @endif
                                                    Weet je zeker dat je de categorie <strong>{{ $category->name }}</strong> wilt verwijderen?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
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
                {{ $categories->links() }}
            </div>
        @else
            <div class="p-4 text-center">
                <p class="mb-0">Geen categorieën gevonden</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-1"></i> Maak je eerste categorie aan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 