@extends('admin.layouts.app')

@section('title', 'Nieuwe Vacature')

@section('content')
    <div class="card">
        <div class="card-header">Vacature Aanmaken</div>
        <div class="card-body">
            <form action="{{ route('admin.vacancies.store') }}" method="POST">
                @csrf
                @include('admin.vacancies.partials.form')
                <button class="btn btn-success">Opslaan</button>
            </form>
        </div>
    </div>
@endsection
