@extends('layouts.app')

@section('title', 'Programmering || VoltFM')

@section('content')
<div class="aximo-breadcrumb">
    <div class="container">
        <h1 class="post__title">Programma</h1>
        <nav class="breadcrumbs">
            <ul>
                <li><a href="/">Home</a></li>
                <li aria-current="page">Programmering</li>
            </ul>
        </nav>
    </div>
</div>
<!-- End breadcrumb -->

<div class="section aximo-section-padding2">
    <div class="container">
        <div class="aximo-section-title center title-description">
            <h2>
          <span class="aximo-title-animation">
          Onze wekelijkse
          <span class="aximo-title-icon">
            <img src="{{ asset('assets/images/v1/star2.png') }}" alt="">
          </span>
          </span>
                programmering
            </h2>
            <p>Bekijk onze uitzendtijden en programma's hieronder. Of je nu van pop, rock, jazz of klassiek houdt, bij VOLT! FM is er altijd iets voor jou.</p>
        </div>

        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="aximo-story-content">
                    <div class="row align-items-center mb-4">
                        <div class="col-lg-5 col-md-12 mb-3 mb-lg-0">
                            <div class="programming-dropdown">
                                <h3 id="programmingTitle">
                                    Programma's voor <span id="selectedDay">maandag</span>
                                    <span class="dropdown-arrow">
                                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </h3>
                                <div class="day-options">
                                    <div class="day-option" data-day="maandag">Maandag</div>
                                    <div class="day-option" data-day="dinsdag">Dinsdag</div>
                                    <div class="day-option" data-day="woensdag">Woensdag</div>
                                    <div class="day-option" data-day="donderdag">Donderdag</div>
                                    <div class="day-option" data-day="vrijdag">Vrijdag</div>
                                    <div class="day-option" data-day="zaterdag">Zaterdag</div>
                                    <div class="day-option" data-day="zondag">Zondag</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4" id="programsList">
                        @if(isset($programs) && $programs->count() > 0)
                            @foreach($programs as $program)
                            <div class="col-lg-4 program-item" data-days="{{ json_encode($program->days) }}">
                                <div class="aximo-show-card" data-wow-delay="0.1s" style="position: relative; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06); border: 1px solid rgba(0, 0, 0, 0.03); margin-bottom: 30px; transition: all 0.3s ease;">
                                    <!-- Show Header met afbeelding -->
                                    <div style="position: relative; height: 200px; overflow: hidden;">
                                        @if($program->image)
                                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                                        @else
                                            <img src="{{ asset('assets/images/team/team1.png') }}" alt="{{ $program->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                                        @endif
                                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.7));"></div>
                                        <div style="position: absolute; top: 15px; right: 15px; background-color: #c3f135; color: #000; padding: 6px 12px; border-radius: 30px; font-size: 12px; font-weight: 600; font-family: 'Inter', sans-serif;">
                                            {{ \Carbon\Carbon::parse($program->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($program->time_end)->format('H:i') }}
                                        </div>
                                        <div style="position: absolute; bottom: 20px; left: 20px; color: white; z-index: 2;">
                                            <h3 class="text-white" style="font-size: 26px; font-weight: 700; margin-bottom: 5px; font-family: 'Syne', sans-serif; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">{{ $program->title }}</h3>
                                        </div>
                                    </div>

                                    <!-- Show Content -->
                                    <div style="padding: 25px;">
                                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; margin-right: 15px; border: 3px solid #c3f135; box-shadow: 0 5px 15px rgba(195, 241, 53, 0.2);">
                                                @if($program->image)
                                                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->presenter }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets/images/team/team1.png') }}" alt="{{ $program->presenter }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @endif
                                            </div>
                                            <div>
                                                <span style="display: block; font-size: 13px; color: #777; font-family: 'Inter', sans-serif; margin-bottom: 3px; text-transform: uppercase; letter-spacing: 1px;">Gepresenteerd door</span>
                                                <h4 style="font-size: 18px; font-weight: 700; color: #222; font-family: 'Syne', sans-serif; margin: 0;">{{ $program->presenter }}</h4>
                                            </div>
                                        </div>
                                        <p style="color: #666; font-size: 15px; font-family: 'Inter', sans-serif; line-height: 1.6; margin-bottom: 20px;">{{ $program->description }}</p>
                                        <a href="#" style="display: inline-flex; align-items: center; color: #000; font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif; text-decoration: none; transition: all 0.3s ease; background-color: #f5f5f5; padding: 10px 20px; border-radius: 30px;">
                                            Meer informatie
                                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 6px;">
                                                <path d="M13.5303 6.53033C13.8232 6.23744 13.8232 5.76256 13.5303 5.46967L8.75736 0.696699C8.46447 0.403806 7.98959 0.403806 7.6967 0.696699C7.40381 0.989593 7.40381 1.46447 7.6967 1.75736L11.9393 6L7.6967 10.2426C7.40381 10.5355 7.40381 11.0104 7.6967 11.3033C7.98959 11.5962 8.46447 11.5962 8.75736 11.3033L13.5303 6.53033ZM0 6.75H13V5.25H0V6.75Z" fill="#222"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center">
                                <div class="alert alert-info">
                                    Geen programma's gevonden voor deze week.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End section -->

@endsection

@section('additional_scripts')
<style>
    /* Program card hover effects */
    .aximo-show-card {
        transition: all 0.3s ease;
    }

    .aximo-show-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .aximo-show-card:hover img {
        transform: scale(1.05);
    }

    .aximo-show-card a {
        transition: all 0.3s ease;
    }

    .aximo-show-card a:hover {
        background-color: #c3f135;
    }

    /* Custom styles for date picker */
    #datePicker {
        outline: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    #datePicker:focus {
        outline: none;
        border-color: #c3f135 !important;
        box-shadow: 0 0 0 3px rgba(195, 241, 53, 0.2) !important;
    }

    #datePicker:hover {
        border-color: rgba(0,0,0,0.15);
    }

    /* Button hover effect */
    #viewProgramming:hover {
        background-color: #b3e129 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 15px rgba(195, 241, 53, 0.4) !important;
    }

    /* Program filter container hover effect */
    .program-filter-container {
        transition: all 0.3s ease;
    }

    .program-filter-container:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.06) !important;
    }
</style>

<style>
    /* Program card hover effects */
    .aximo-show-card {
        transition: all 0.3s ease;
    }

    .aximo-show-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .aximo-show-card:hover img {
        transform: scale(1.05);
    }

    .aximo-show-card a {
        transition: all 0.3s ease;
    }

    .aximo-show-card a:hover {
        background-color: #c3f135;
    }

    /* Custom Date Picker Styles */
    .custom-date-picker {
        position: relative;
        transition: all 0.3s ease;
    }

    #dateDisplay {
        cursor: pointer;
        font-weight: 500;
        color: #333;
        transition: all 0.3s ease;
        user-select: none;
        background-color: #fff;
    }

    #dateDisplay:hover {
        border-color: rgba(0,0,0,0.15);
    }

    #dateDisplay:focus {
        outline: none;
        border-color: #c3f135;
        box-shadow: 0 0 0 3px rgba(195, 241, 53, 0.2);
    }

    .date-picker-icon {
        transition: all 0.3s ease;
    }

    .custom-date-picker:hover .date-picker-icon {
        color: #c3f135;
    }

    .date-selected {
        animation: pulse-border 0.3s ease;
    }

    .title-update {
        animation: fade-update 0.5s ease;
    }

    .btn-clicked {
        animation: btn-pulse 0.3s ease;
    }

    @keyframes pulse-border {
        0% { border-color: rgba(0,0,0,0.08); }
        50% { border-color: #c3f135; }
        100% { border-color: rgba(0,0,0,0.08); }
    }

    @keyframes fade-update {
        0% { opacity: 0.6; }
        100% { opacity: 1; }
    }

    @keyframes btn-pulse {
        0% { transform: scale(1); }
        50% { transform: scale(0.95); }
        100% { transform: scale(1); }
    }

    /* Button hover effect */
    #viewProgramming {
        transition: all 0.3s ease;
    }

    #viewProgramming:hover {
        background-color: #b3e129;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(195, 241, 53, 0.4);
    }

    /* Program filter container hover effect */
    .program-filter-container {
        transition: all 0.3s ease;
    }

    .program-filter-container:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }
</style>

<style>
    /* Title dropdown styling */
    .programming-dropdown {
        position: relative;
        display: inline-block;
    }

    #programmingTitle {
        display: inline-block;
        cursor: pointer;
        transition: color 0.2s ease;
        position: relative;
        padding-right: 20px;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        font-family: 'Syne', sans-serif;
    }

    #programmingTitle:hover {
        color: #222;
    }

    #selectedDay {
        position: relative;
    }

    .dropdown-arrow {
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
    }

    .dropdown-arrow svg {
        transition: all 0.3s ease;
        margin-left: 6px;
    }

    .dropdown-arrow-active svg {
        transform: rotate(180deg);
    }

    #programmingTitle:hover .dropdown-arrow {
        transform: translateY(-50%);
    }

    #programmingTitle:hover .dropdown-arrow svg {
        transform: translateY(2px);
    }

    #programmingTitle:hover .dropdown-arrow.dropdown-arrow-active svg {
        transform: translateY(2px) rotate(180deg);
    }

    .day-options {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        padding: 8px 0;
        min-width: 200px;
        z-index: 100;
    }

    .day-options.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .day-option {
        border-left: 3px solid transparent;
        padding: 10px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .day-option:hover {
        background-color: #f9f9f9;
        border-left: 3px solid #c3f135;
        padding-left: 20px !important;
    }

    .day-option.selected {
        background-color: rgba(195, 241, 53, 0.1);
        border-left: 3px solid #c3f135;
        font-weight: 600;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements voor title dropdown
        const programmingTitle = document.getElementById('programmingTitle');
        const selectedDay = document.getElementById('selectedDay');
        const dropdownArrow = document.querySelector('.dropdown-arrow');
        const dayOptions = document.querySelector('.day-options');
        const dayOptionElements = document.querySelectorAll('.day-option');
        const programItems = document.querySelectorAll('.program-item');
        const programsList = document.getElementById('programsList');

        // Map Dutch day names to English (for API data)
        const dayMapReverse = {
            'maandag': 'monday',
            'dinsdag': 'tuesday',
            'woensdag': 'wednesday',
            'donderdag': 'thursday',
            'vrijdag': 'friday',
            'zaterdag': 'saturday',
            'zondag': 'sunday'
        };

        // Get current day name in Dutch
        function getCurrentDayName() {
            const days = ['zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag'];
            return days[new Date().getDay()];
        }

        // Remove existing no results message if it exists
        function removeNoResultsMessage() {
            const existingMessage = programsList.querySelector('.col-12.text-center .alert-info');
            if (existingMessage) {
                existingMessage.closest('.col-12.text-center').remove();
            }
        }

        // Filter programs based on selected day
        function filterProgramsByDay(selectedDayName) {
            // Convert Dutch day name to English for matching with API data
            const englishDayName = dayMapReverse[selectedDayName];

            // Remove any existing "no results" message before filtering
            removeNoResultsMessage();

            let visibleCount = 0;

            programItems.forEach(item => {
                const daysArray = JSON.parse(item.getAttribute('data-days'));

                if (daysArray.includes(englishDayName)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show message only if no programs are visible after filtering
            if (visibleCount === 0) {
                const noResults = document.createElement('div');
                noResults.className = 'col-12 text-center';
                noResults.innerHTML = '<div class="alert alert-info">Geen programma\'s gevonden voor deze dag.</div>';
                programsList.appendChild(noResults);
            }
        }

        // Set current day as selected option
        const currentDay = getCurrentDayName();
        const currentDayOption = document.querySelector(`.day-option[data-day="${currentDay}"]`);

        if (currentDayOption) {
            // Update selected day text
            selectedDay.textContent = currentDayOption.textContent.toLowerCase();

            // Mark as selected
            dayOptionElements.forEach(opt => opt.classList.remove('selected'));
            currentDayOption.classList.add('selected');

            // Filter programs
            filterProgramsByDay(currentDay);
        }

        // Toggle dropdown bij klikken op titel
        programmingTitle.addEventListener('click', function(e) {
            e.stopPropagation();
            dayOptions.classList.toggle('active');
            dropdownArrow.classList.toggle('dropdown-arrow-active');
        });

        // Selecteer een dag uit de dropdown
        dayOptionElements.forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();

                // Update geselecteerde dag
                const day = this.getAttribute('data-day');
                selectedDay.textContent = this.textContent.toLowerCase();

                // Update UI
                dayOptionElements.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');

                // Voeg animatie toe
                programmingTitle.classList.add('title-update');
                setTimeout(() => {
                    programmingTitle.classList.remove('title-update');
                }, 500);

                // Sluit dropdown
                dayOptions.classList.remove('active');
                dropdownArrow.classList.remove('dropdown-arrow-active');

                // Filter programs voor geselecteerde dag
                filterProgramsByDay(day);
            });
        });

        // Sluit dropdown als er ergens anders wordt geklikt
        document.addEventListener('click', function(e) {
            if (!programmingTitle.contains(e.target)) {
                dayOptions.classList.remove('active');
                dropdownArrow.classList.remove('dropdown-arrow-active');
            }
        });
    });
</script>
@endsection
