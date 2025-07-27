@extends('admin.layouts.app')

@section('title', 'Sollicitatie Details')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            Sollicitatie van {{ $vacature->naam }}
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Naam</dt>
                <dd class="col-sm-9">{{ $vacature->naam }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $vacature->email }}</dd>

                <dt class="col-sm-3">Leeftijd</dt>
                <dd class="col-sm-9">{{ $vacature->leeftijd }}</dd>

                <dt class="col-sm-3">Discord</dt>
                <dd class="col-sm-9">{{ $vacature->discord ?? '-' }}</dd>

                <dt class="col-sm-3">Ervaring</dt>
                <dd class="col-sm-9">{{ $vacature->ervaring }}</dd>

                <dt class="col-sm-3">Motivatie</dt>
                <dd class="col-sm-9">{{ $vacature->motivatie }}</dd>

                <dt class="col-sm-3">Ingediend op</dt>
                <dd class="col-sm-9">{{ $vacature->applied_at ? $vacature->applied_at->format('d-m-Y H:i') : '-' }}</dd>
				<dt class="col-sm-3">Vacature</dt>
<dd class="col-sm-9">
    @if($vacature->vacancy)
        <a href="{{ route('admin.vacancies.edit', $vacature->vacancy) }}">
            {{ $vacature->vacancy->title }}
        </a>
    @else
        <span class="text-muted">Geen gekoppelde vacature</span>
    @endif
</dd>

            </dl>

            <a href="{{ route('admin.sollicitaties.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Terug naar overzicht
            </a>
        </div>
    </div>
@endsection
