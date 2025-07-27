@extends('admin.layouts.app')

@section('title', 'Vacature Bewerken')

@section('content')
    <div class="card">
        <div class="card-header">Vacature Bewerken</div>
        <div class="card-body">
            <form action="{{ route('admin.vacancies.update', $vacancy) }}" method="POST">
                @csrf @method('PUT')
                @include('admin.vacancies.partials.editform', ['vacancy' => $vacancy])
                <button class="btn btn-primary">Bijwerken</button>
            </form>
        </div>
    </div>
@endsection
