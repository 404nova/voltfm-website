@extends('admin.layouts.app')

@section('title', 'Vacatures Beheer')

@section('actions')
    <a href="{{ route('admin.vacancies.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nieuwe Vacature
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">Overzicht Vacatures</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Status</th>
                        <th>Aangemaakt</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vacancies as $vacancy)
                        <tr>
                            <td>{{ $vacancy->title }}</td>
                            <td>
                                <span class="badge bg-{{ $vacancy->is_active ? 'success' : 'secondary' }}">
                                    {{ $vacancy->is_active ? 'Actief' : 'Inactief' }}
                                </span>
                            </td>
                            <td>{{ $vacancy->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('admin.vacancies.edit', $vacancy) }}" class="btn btn-sm btn-warning">Bewerk</a>
                                <form action="{{ route('admin.vacancies.destroy', $vacancy) }}" method="POST" class="d-inline" onsubmit="return confirm('Weet je zeker dat je deze vacature wilt verwijderen?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Verwijder</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
