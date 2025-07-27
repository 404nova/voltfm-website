@extends('admin.layouts.app')

@section('title', 'Planning Overzicht')

@section('actions')
    @if($isAdmin)
    <div>
        <a href="{{ route('admin.schedule.assignments') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> DJ Toewijzen
        </a>
    </div>
    @else
    <div>
        <a href="{{ route('admin.schedule.availability', ['user_id' => Auth::id()]) }}" class="btn btn-primary">
            <i class="fas fa-clock"></i> Mijn Beschikbaarheid
        </a>
    </div>
    @endif
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Weekplanning: {{ $currentWeek->format('d-m-Y') }} t/m {{ $currentWeek->copy()->addDays(6)->format('d-m-Y') }}</div>
            <div>
                <a href="{{ route('admin.schedule.index', ['week' => $currentWeek->copy()->subDays(7)->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chevron-left"></i> Vorige Week
                </a>
                <a href="{{ route('admin.schedule.index', ['week' => $currentWeek->copy()->addDays(7)->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-secondary">
                    Volgende Week <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Tijd</th>
                            @foreach($daysOfWeek as $index => $day)
                                @php
                                    $currentDate = $currentWeek->copy()->addDays($index);
                                    $isToday = $currentDate->isToday();
                                @endphp
                                <th class="{{ $isToday ? 'table-primary' : '' }}">
                                    {{ $day }}<br>
                                    <small>{{ $currentDate->format('d-m') }}</small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $time)
                            <tr>
                                <td class="table-light">{{ $time }}</td>
                                @foreach($daysOfWeek as $index => $day)
                                    @php
                                        $currentDate = $currentWeek->copy()->addDays($index);
                                        $dayAssignments = $assignments->filter(function($assignment) use ($currentDate, $time) {
                                            return $assignment->date->isSameDay($currentDate) && 
                                                   $assignment->start_time <= $time && 
                                                   $assignment->end_time > $time;
                                        });
                                    @endphp
                                    <td class="{{ $currentDate->isToday() ? 'table-primary' : '' }} {{ count($dayAssignments) ? 'bg-light-success' : '' }}">
                                        @foreach($dayAssignments as $assignment)
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-success me-2">{{ $assignment->start_time }} - {{ $assignment->end_time }}</span>
                                                <strong>{{ $assignment->user->name }}</strong>
                                            </div>
                                            @if($assignment->notes)
                                                <small class="text-muted d-block">{{ $assignment->notes }}</small>
                                            @endif
                                        @endforeach
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .bg-light-success {
        background-color: rgba(195, 241, 53, 0.15);
    }
    .table td {
        height: 60px;
        vertical-align: middle;
    }
</style>
@endsection 