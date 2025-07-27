@extends('layouts.app')

@section('title', $vacancy->title . ' || VoltFM')

@section('content')
<div class="aximo-breadcrumb">
    <div class="container">
        <h1 class="post__title">{{ $vacancy->title }}</h1>
        <nav class="breadcrumbs" aria-label="breadcrumb">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('vacatures.index') }}">Vacatures</a></li>
                <li aria-current="page">{{ $vacancy->title }}</li>
            </ul>
        </nav>
    </div>
</div>

<div class="section aximo-section-padding2">
    <div class="container" style="max-width: 960px;">

        <div class="aximo-section-title center title-description" style="margin-bottom: 40px;">
            <h2 style="font-family: 'Syne', sans-serif; font-weight: 700; font-size: 28px; text-align: center;">
                {{ $vacancy->title }}
            </h2>
<p style="color: #222; font-family: 'Inter', sans-serif; font-size: 16px; max-width: 700px; margin: 10px auto 30px auto; white-space: pre-line;">
    {!! nl2br(e($vacancy->description)) !!}
</p>

        </div>

        @if(session('success'))
            <div style="background: rgba(195, 241, 53, 0.15); border-radius: 12px; padding: 20px; margin-bottom: 20px; color: #c3f135; font-family: 'Inter', sans-serif;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('vacatures.apply', $vacancy) }}" style="max-width: 600px; margin: 0 auto; font-family: 'Inter', sans-serif; color: #eee;">
            @csrf
            
            <input type="text" name="naam" placeholder="Naam" required value="{{ old('naam') }}">
            @error('naam') <small style="color: #222;">{{ $message }}</small> @enderror

            <input type="number" name="leeftijd" placeholder="Leeftijd" required value="{{ old('leeftijd') }}">
            @error('leeftijd') <small style="color: #222;">{{ $message }}</small> @enderror

            <input type="email" name="email" placeholder="E-mailadres" required value="{{ old('email') }}">
            @error('email') <small style="color: #222;">{{ $message }}</small> @enderror

            <input type="text" name="ervaring" placeholder="Ervaring" required value="{{ old('ervaring') }}">
            @error('ervaring') <small style="color: #222;">{{ $message }}</small> @enderror

            <textarea name="motivatie" placeholder="Motivatie" rows="4" required>{{ old('motivatie') }}</textarea>
            @error('motivatie') <small style="color: #222;">{{ $message }}</small> @enderror

            <input type="text" name="discord" placeholder="Discord" value="{{ old('discord') }}" required>

            <button type="submit" 
                    style="background-color: #c3f135; border: 2px solid #222; padding: 12px 28px; border-radius: 9999px; 
                           font-weight: 700; color: #222; cursor: pointer; font-family: 'Inter', sans-serif; 
                           transition: background-color 0.3s; margin-top: 1.8rem; display: block; width: 100%; max-width: 220px; margin-left: auto; margin-right: auto;">
                Solliciteer
            </button>
        </form>
    </div>
</div>

<style>
input[type="text"],
input[type="number"],
input[type="email"],
textarea {
  border: none;
  border-bottom: 1px solid #c3f135;
  background: transparent;
  color: #222;
  font-size: 16px;
  padding: 6px 2px;
  font-family: 'Inter', sans-serif;
  width: 100%;
  outline: none;
  transition: border-color 0.3s;
  margin-bottom: 1.2rem;
  border-radius: 0;
  resize: vertical;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="email"]:focus,
textarea:focus {
  border-bottom-color: #8fc31f;
}

label {
  display: none;
}

::placeholder {
  color: #bbb;
  font-style: italic;
}
</style>
@endsection
