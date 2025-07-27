@extends('admin.layouts.app')

@section('title', 'Sollicitaties Beheer')

@section('actions')
    {{-- Bijvoorbeeld een knop om een sollicitatie handmatig toe te voegen, als je dat zou willen --}}
    {{-- <a href="{{ route('admin.sollicitaties.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nieuwe Sollicitatie
    </a> --}}
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">Overzicht Sollicitaties</div>
        <div class="card-body">
            @if($sollicitaties->isEmpty())
                <p>Er zijn nog geen sollicitaties binnengekomen.</p>
            @else
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Email</th>
                            <th>Leeftijd</th>
                            <th>Discord</th>
                            <th>Ingediend op</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sollicitaties as $sollicitatie)
                            <tr>
                                <td>{{ $sollicitatie->naam }}</td>
                                <td>{{ $sollicitatie->email }}</td>
                                <td>{{ $sollicitatie->leeftijd }}</td>
                                <td>{{ $sollicitatie->discord ?? '-' }}</td>
                                <td>{{ $sollicitatie->applied_at ? $sollicitatie->applied_at->format('d-m-Y H:i') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.sollicitaties.show', $sollicitatie) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Bekijk
                                    </a>
                                    <form action="{{ route('admin.sollicitaties.destroy', $sollicitatie) }}" method="POST" class="d-inline" onsubmit="return confirm('Weet je zeker dat je deze sollicitatie wilt verwijderen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Verwijder
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $sollicitaties->links() }}
            @endif
        </div>
    </div>
@endsection
