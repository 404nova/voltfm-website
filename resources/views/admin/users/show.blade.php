@extends('admin.layouts.app')

@section('title', 'Gebruiker Details')

@section('actions')
<a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-1"></i> Terug
</a>
<a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary ms-2">
    <i class="fas fa-edit me-1"></i> Bewerken
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span>Gebruiker Details</span>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3 text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=c3f135&color=222&size=200" alt="{{ $user->name }}" class="rounded-circle img-fluid mb-3" style="max-width: 200px;">
                
                <h4 class="mb-1">{{ $user->name }}</h4>
                @if($user->role)
                    <span class="badge bg-primary">{{ ucfirst($user->role->name) }}</span>
                @else
                    <span class="badge bg-secondary">Geen rol</span>
                @endif
            </div>
            <div class="col-md-9">
                <h5 class="border-bottom pb-2 mb-3">Gebruikersinformatie</h5>
                
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">ID:</div>
                    <div class="col-md-9">{{ $user->id }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Email:</div>
                    <div class="col-md-9">{{ $user->email }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Rol:</div>
                    <div class="col-md-9">
                        @if($user->role)
                            {{ ucfirst($user->role->name) }} - {{ $user->role->description }}
                        @else
                            Geen rol toegewezen
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Aangemaakt op:</div>
                    <div class="col-md-9">{{ $user->created_at->format('d-m-Y H:i') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Laatst bijgewerkt:</div>
                    <div class="col-md-9">{{ $user->updated_at->format('d-m-Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
