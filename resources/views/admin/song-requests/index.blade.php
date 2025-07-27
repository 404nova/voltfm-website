@extends('admin.layouts.app')

@section('title', 'Verzoeknummers Beheer')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Verzoeknummers</span>
        <div>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.song-requests.index', ['status' => 'all']) }}" class="btn {{ $status === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Alle ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.song-requests.index', ['status' => 'pending']) }}" class="btn {{ $status === 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Wachtend ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('admin.song-requests.index', ['status' => 'approved']) }}" class="btn {{ $status === 'approved' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Goedgekeurd ({{ $counts['approved'] }})
                </a>
                <a href="{{ route('admin.song-requests.index', ['status' => 'played']) }}" class="btn {{ $status === 'played' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Gespeeld ({{ $counts['played'] }})
                </a>
                <a href="{{ route('admin.song-requests.index', ['status' => 'rejected']) }}" class="btn {{ $status === 'rejected' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Afgewezen ({{ $counts['rejected'] }})
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if($songRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Aanvrager</th>
                            <th>Artiest</th>
                            <th>Nummer</th>
                            <th>Bericht</th>
                            <th>Status</th>
                            <th>Aangevraagd op</th>
                            <th>Gespeeld op</th>
                            <th width="150">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($songRequests as $request)
                            <tr>
                                <td>
                                    {{ $request->name }}
                                    @if($request->email)
                                        <br><small class="text-muted">{{ $request->email }}</small>
                                    @endif
                                </td>
                                <td>{{ $request->artist }}</td>
                                <td>{{ $request->song_title }}</td>
                                <td>{{ Str::limit($request->message, 30) }}</td>
                                <td>
                                    @if($request->status === 'pending')
                                        <span class="badge bg-warning">Wachtend</span>
                                    @elseif($request->status === 'approved')
                                        <span class="badge bg-success">Goedgekeurd</span>
                                    @elseif($request->status === 'played')
                                        <span class="badge bg-primary">Gespeeld</span>
                                    @elseif($request->status === 'rejected')
                                        <span class="badge bg-danger">Afgewezen</span>
                                    @endif
                                </td>
                                <td>{{ $request->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $request->played_at ? $request->played_at->format('d-m-Y H:i') : '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $request->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $request->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Status Modal -->
                                    <div class="modal fade" id="statusModal{{ $request->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $request->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="statusModalLabel{{ $request->id }}">Status wijzigen</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.song-requests.update-status', $request->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <p><strong>Aanvrager:</strong> {{ $request->name }}</p>
                                                            <p><strong>Artiest:</strong> {{ $request->artist }}</p>
                                                            <p><strong>Nummer:</strong> {{ $request->song_title }}</p>
                                                            
                                                            @if($request->message)
                                                                <p><strong>Bericht:</strong> {{ $request->message }}</p>
                                                            @endif
                                                            
                                                            <label for="status{{ $request->id }}" class="form-label">Status</label>
                                                            <select class="form-select" id="status{{ $request->id }}" name="status">
                                                                <option value="pending" {{ $request->status === 'pending' ? 'selected' : '' }}>Wachtend</option>
                                                                <option value="approved" {{ $request->status === 'approved' ? 'selected' : '' }}>Goedgekeurd</option>
                                                                <option value="played" {{ $request->status === 'played' ? 'selected' : '' }}>Gespeeld</option>
                                                                <option value="rejected" {{ $request->status === 'rejected' ? 'selected' : '' }}>Afgewezen</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                                        <button type="submit" class="btn btn-primary">Opslaan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $request->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $request->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $request->id }}">Verzoeknummer verwijderen</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Weet je zeker dat je dit verzoeknummer wilt verwijderen?</p>
                                                    <p><strong>Aanvrager:</strong> {{ $request->name }}</p>
                                                    <p><strong>Artiest:</strong> {{ $request->artist }}</p>
                                                    <p><strong>Nummer:</strong> {{ $request->song_title }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                                    <form action="{{ route('admin.song-requests.destroy', $request->id) }}" method="POST">
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
            
            <div class="d-flex justify-content-center mt-4 mb-4">
                {{ $songRequests->appends(['status' => $status])->links() }}
            </div>
        @else
            <div class="p-4 text-center">
                <p>Er zijn geen verzoeknummers met de geselecteerde status.</p>
            </div>
        @endif
    </div>
</div>
@endsection 