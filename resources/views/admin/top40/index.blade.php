@extends('admin.layouts.app')

@section('title', 'TOP40 Beheren')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">TOP40 Beheren</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('admin.top40.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nieuw Nummer Toevoegen
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="top40-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">Positie</th>
                                    <th style="width: 100px;">Album Art</th>
                                    <th>Titel</th>
                                    <th>Artiest</th>
                                    <th>Trend</th>
                                    <th>Nieuw</th>
                                    <th style="width: 150px;">Acties</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @foreach($songs as $song)
                                    <tr data-id="{{ $song->id }}">
                                        <td>{{ $song->position }}</td>
                                        <td>
                                            <img src="{{ $song->art_url }}" alt="{{ $song->title }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        </td>
                                        <td>{{ $song->title }}</td>
                                        <td>{{ $song->artist }}</td>
                                        <td>
                                            @if($song->trend_direction === 'up')
                                                <span class="badge badge-success">
                                                    <i class="fas fa-arrow-up"></i> +{{ $song->trend_value }}
                                                </span>
                                            @elseif($song->trend_direction === 'down')
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-arrow-down"></i> -{{ $song->trend_value }}
                                                </span>
                                            @elseif($song->trend_direction === 'new')
                                                <span class="badge badge-info">NEW</span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-minus"></i> 0
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($song->is_new)
                                                <span class="badge badge-warning">NIEUW</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.top40.edit', $song) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.top40.destroy', $song) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Weet je zeker dat je dit nummer wilt verwijderen?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    $("#sortable").sortable({
        handle: "td:first",
        update: function(event, ui) {
            var positions = [];
            $("#sortable tr").each(function(index) {
                positions.push($(this).data('id'));
            });

            $.ajax({
                url: "{{ route('admin.top40.reorder') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    positions: positions
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Posities succesvol bijgewerkt');
                    } else {
                        toastr.error('Er is een fout opgetreden bij het bijwerken van de posities');
                    }
                },
                error: function() {
                    toastr.error('Er is een fout opgetreden bij het bijwerken van de posities');
                }
            });
        }
    });
});
</script>
@endpush
@endsection
