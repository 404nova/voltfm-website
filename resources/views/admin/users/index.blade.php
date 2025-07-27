@extends('admin.layouts.app')

@section('title', 'Gebruikersbeheer')

@section('actions')
<a href="{{ route('admin.users.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Nieuwe Gebruiker
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>Alle Gebruikers</span>
    </div>
    <div class="card-body p-0">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Naam</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Aangemaakt</th>
                            <th width="120">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role)
                                        <span class="badge bg-primary">{{ ucfirst($user->role->name) }}</span>
                                    @else
                                        <span class="badge bg-secondary">Geen rol</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        @else
            <div class="p-4 text-center">
                <p class="mb-0">Geen gebruikers gevonden</p>
            </div>
        @endif
    </div>
</div>
@endsection
