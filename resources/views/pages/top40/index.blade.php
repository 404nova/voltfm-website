@extends('layouts.app')

@section('title', 'TOP50 - VOLT!')

@section('content')
<div class="section dark-bg aximo-section-padding3">
    <div class="container">
        <div class="aximo-section-title center light">
            <h2>
                De TOP40 van
                <span class="aximo-title-animation">
                    VOLT!
                    <span class="aximo-title-icon">
                        <img src="{{ asset('assets/images/v1/star2.png') }}" alt="">
                    </span>
                </span>
            </h2>
            <p style="color: rgba(255,255,255,0.7); font-size: 16px; font-family: 'Inter', sans-serif; margin-top: 15px;">
                De 50 meest gedraaide nummers van deze week
            </p>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="top40-list" style="background: rgba(25, 25, 25, 0.6); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
                    @foreach($top40 as $song)
                        <div class="top40-item" style="display: flex; align-items: center; padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.08); {{ $song->position <= 3 ? 'background: rgba(195, 241, 53, 0.05);' : '' }}">
                            <div class="top40-rank" style="font-size: {{ $song->position <= 3 ? '32px' : '24px' }}; font-weight: 700; color: {{ $song->position <= 3 ? '#c3f135' : 'rgba(255,255,255,0.7)' }}; font-family: 'Syne', sans-serif; width: 60px; text-align: center;">
                                {{ $song->position }}
                            </div>
                            <div class="top40-album" style="width: 80px; height: 80px; margin-right: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.3); position: relative;">
                                <img src="{{ $song->art_url }}" alt="{{ $song->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @if($song->is_new)
                                    <div style="position: absolute; top: 0; right: 0; background: #c3f135; color: black; font-size: 10px; font-weight: 700; padding: 2px 6px; font-family: 'Inter', sans-serif;">NIEUW</div>
                                @endif
                            </div>
                            <div class="top40-info" style="flex-grow: 1;">
                                <h3 style="color: white; font-size: 20px; font-weight: 600; margin-bottom: 5px; font-family: 'Syne', sans-serif;">{{ $song->title }}</h3>
                                <p style="color: rgba(255,255,255,0.7); font-size: 14px; font-family: 'Inter', sans-serif; margin-bottom: 0;">{{ $song->artist }}</p>
                            </div>
                            <div class="top40-trend" style="color: {{ $song->trend_direction === 'up' ? '#c3f135' : ($song->trend_direction === 'down' ? '#ff4d4d' : 'rgba(255,255,255,0.7)') }}; font-size: 14px; font-weight: 600; padding: 5px 10px; border-radius: 4px; background: {{ $song->trend_direction === 'up' ? 'rgba(195, 241, 53, 0.1)' : ($song->trend_direction === 'down' ? 'rgba(255, 77, 77, 0.1)' : 'rgba(255, 255, 255, 0.1)') }};">
                                @if($song->trend_direction === 'up')
                                    OMHOOG
                                @elseif($song->trend_direction === 'down')
                                    OMLAAG
                                @elseif($song->trend_direction === 'new')
                                    NEW
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Binnenkomers sectie -->
                <div style="text-align: center; margin: 40px 0 30px;">
                    <h3 style="color: white; font-size: 24px; font-weight: 600; margin-bottom: 20px; font-family: 'Syne', sans-serif;">
                        Binnenkomers <span style="color: #c3f135; font-size: 28px;">•</span> Deze Week
                    </h3>
                </div>

                <div class="row">
                    @foreach($top40->where('is_new', true)->take(3) as $newSong)
                        <div class="col-md-4">
                            <div style="background: rgba(25, 25, 25, 0.4); border-radius: 10px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); position: relative;">
                                <div style="position: absolute; top: 10px; right: 10px; background: #c3f135; color: black; font-size: 12px; font-weight: 700; padding: 3px 8px; border-radius: 4px; font-family: 'Inter', sans-serif;">NIEUW</div>
                                <img src="{{ $newSong->art_url }}" alt="{{ $newSong->title }}" style="width: 100%; height: 180px; object-fit: cover;">
                                <div style="padding: 15px;">
                                    <h4 style="color: white; font-size: 16px; font-weight: 600; margin-bottom: 3px; font-family: 'Syne', sans-serif;">{{ $newSong->title }}</h4>
                                    <p style="color: rgba(255,255,255,0.7); font-size: 13px; font-family: 'Inter', sans-serif; margin-bottom: 0;">{{ $newSong->artist }}</p>
                                    <div style="color: #c3f135; font-size: 12px; font-weight: 600; margin-top: 10px; font-family: 'Inter', sans-serif;">Positie #{{ $newSong->position }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Update info -->
                <div style="text-align: center; margin-top: 30px; color: rgba(255,255,255,0.5); font-size: 14px; font-family: 'Inter', sans-serif;">
                    Laatst bijgewerkt: {{ now()->format('d M Y H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
