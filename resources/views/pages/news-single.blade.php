@extends('layouts.app')

@section('title', $article->title . ' || VoltFM')

@section('content')
<div class="aximo-breadcrumb">
    <div class="container">
        <h1 class="post__title">{{ $article->title }}</h1>
        <nav class="breadcrumbs">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('news') }}">Laatste Nieuws</a></li>
                <li aria-current="page">Artikel bekijken</li>
            </ul>
        </nav>
    </div>
</div>
<!-- End breadcrumb -->
<div class="section post-details-page aximo-section-padding2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="post-thumbnail wow fadeInUpX" data-wow-delay="0.1s">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                    @else
                        <img src="{{ asset('assets/images/blog/blog3.png') }}" alt="{{ $article->title }}">
                    @endif
                </div>
                <div class="single-post-content-wrap">
                    <div class="post-meta">
                        <div class="post-category">
                            @if($article->category)
                                <a href="{{ route('news.category', $article->category->slug) }}">
                                    {{ $article->category->name }}
                                </a>
                            @else
                                <a href="{{ route('news') }}">Nieuws</a>
                            @endif
                        </div>
                        <div class="post-date">
                            {{ $article->published_at->format('d M, Y') }}
                        </div>
                        <div class="post-author">
                            <i class="icon-user" style="margin-right: 5px;"></i> Door {{ $article->author ? $article->author->name : 'VOLT! Team' }}
                        </div>
                    </div>
                    <div class="entry-content">
                        <h3>{{ $article->title }}</h3>

                        {!! $article->content !!}

                        <div class="post-tag-wrap">
                            <div class="post-tag">
                                <h3>Tags:</h3>
                                <div class="wp-block-tag-cloud">
                                    @if($article->tags->count() > 0)
                                        @foreach($article->tags as $tag)
                                            <a href="{{ route('news.tag', $tag->slug) }}">{{ $tag->name }}</a>
                                        @endforeach
                                    @else
                                        <span>Geen tags</span>
                                    @endif
                                </div>
                            </div>
                            <div class="post-like-comment">
                                <ul>
                                    <li><a href="#comments"><img src="{{ asset('assets/images/icon/comment.svg') }}" alt="">{{ $comments->count() }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="post-comment" id="comments">
                            <h3>Reacties:</h3>
                            @if($comments->count() > 0)
                                <div class="comments-list">
                                    @foreach($comments as $comment)
                                        <div class="comment-item wow fadeInUpX" data-wow-delay="0.{{ $loop->iteration }}s">
                                            <div class="comment-avatar">
                                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($comment->email))) }}?s=50&d=mp" alt="{{ $comment->name }}">
                                            </div>
                                            <div class="comment-content">
                                                <div class="comment-meta">
                                                    <h4>{{ $comment->name }}</h4>
                                                    <span class="comment-date">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $comment->created_at->format('d M, Y H:i') }}
                                                    </span>
                                                </div>
                                                <div class="comment-text">
                                                    <p>{{ $comment->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="no-comments wow fadeInUpX" data-wow-delay="0.1s">
                                    <div class="alert alert-light text-center">
                                        <i class="fas fa-comment-slash fa-2x mb-3"></i>
                                        <p>Er zijn nog geen reacties op dit artikel.</p>
                                        <p class="small">Wees de eerste om een reactie te plaatsen!</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="comment-box wow fadeInUpX" data-wow-delay="0.1s">
                            <h3>Laat een reactie achter:</h3>
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{ route('news.comments.store', $article->slug) }}" method="POST">
                                @csrf
                                <div class="comment-box-form">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="comment-form">
                                                <input type="text" name="name" placeholder="Uw Naam*" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="comment-form">
                                                <input type="email" name="email" placeholder="Email Adres*" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment-form">
                                        <textarea name="content" placeholder="Schrijf uw reactie" required>{{ old('content') }}</textarea>
                                        @error('content')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button id="comment-btn" type="submit">Verstuur Bericht</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-sidebar">
                    <div class="widget">
                        <div class="wp-block-search__inside-wrapper">
                            <input type="search" placeholder="Zoeken..." class="wp-block-search__input">
                            <button id="wp-block-search__button" type="submit">
                                <img src="{{ asset('assets/images/icon/search.svg') }}" alt="">
                            </button>
                        </div>
                    </div>
                    <div class="widget">
                        <h3 class="wp-block-heading">Categorieën:</h3>
                        <ul>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('news.category', $category->slug) }}">
                                        {{ $category->name }} ({{ $category->news_count }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget aximo_recent_posts_Widget">
                        <h3 class="wp-block-heading">Recente Berichten:</h3>
                        @if(count($recentNews) > 0)
                            @foreach($recentNews as $recentArticle)
                                <div class="post-item">
                                    <div class="post-thumb">
                                        <a href="{{ route('news.show', $recentArticle->slug) }}">
                                            @if($recentArticle->image)
                                                <img src="{{ asset('storage/' . $recentArticle->image) }}" alt="{{ $recentArticle->title }}">
                                            @else
                                                <img src="{{ asset('assets/images/blog/blog' . ($loop->iteration % 3 + 1) . '.png') }}" alt="{{ $recentArticle->title }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="post-text">
                                        <div class="post-date">
                                            {{ $recentArticle->published_at->format('d M, Y') }}
                                        </div>
                                        <a class="post-title" href="{{ route('news.show', $recentArticle->slug) }}">{{ $recentArticle->title }}</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Geen recente berichten gevonden</p>
                        @endif
                    </div>
                    <div class="widget">
                        <h3 class="wp-block-heading">Tags:</h3>
                        <div class="wp-block-tag-cloud">
                            @foreach($tags as $tag)
                                <a href="{{ route('news.tag', $tag->slug) }}">{{ $tag->name }}</a>
                            @endforeach
                        </div>
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
    /* Kleinere titel voor lange titels */
    .aximo-breadcrumb .post__title {
        font-size: 32px;
        line-height: 1.3;
        word-wrap: break-word;
    }

    @media (max-width: 768px) {
        .aximo-breadcrumb .post__title {
            font-size: 28px;
        }
    }

    @media (max-width: 576px) {
        .aximo-breadcrumb .post__title {
            font-size: 24px;
        }
    }

    /* Kleinere breadcrumb tekst */
    .breadcrumbs li {
        font-size: 14px;
    }

    /* Comment styling */
    .comments-list {
        margin-top: 25px;
    }

    /* Styling voor de auteur in post meta */
    .post-author {
        font-size: 16px;
        letter-spacing: 0.5px;
        margin-left: 20px;
    }

    /* Post meta sectie als flexbox */
    .post-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 20px;
    }

    .comment-item {
        display: flex;
        margin-bottom: 25px;
        padding: 0 0 25px 0;
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0,0,0,0.08);
    }

    .comment-item:last-child {
        border-bottom: none;
    }

    .comment-item:hover {
        transform: translateY(-3px);
    }

    .comment-avatar {
        margin-right: 15px;
        flex-shrink: 0;
    }

    .comment-avatar img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .comment-content {
        flex-grow: 1;
    }

    .comment-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .comment-meta h4 {
        margin: 0;
        font-weight: 600;
        color: #333;
        font-size: 16px;
    }

    .comment-date {
        color: #777;
        font-size: 14px;
    }

    .comment-text p {
        margin: 0;
        line-height: 1.6;
        color: #444;
    }

    .no-comments {
        margin: 20px 0;
    }

    .no-comments .alert {
        padding: 20px;
        border-radius: 0;
        border: none;
        background-color: transparent;
        border-left: 3px solid #c3f135;
    }

    .comment-box {
        padding: 0;
        margin-top: 40px;
        background-color: transparent;
    }

    /* Headers styling */
    .post-comment h3,
    .comment-box h3 {
        display: flex;
        align-items: center;
        color: #333;
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 25px;
        border-bottom: 1px solid rgba(0,0,0,0.08);
    }

    .post-comment h3::after,
    .comment-box h3::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 50px;
        height: 3px;
    }

    /* Verwijder comment form styling om terug te keren naar de basis stijl */
    .text-danger {
        color: #dc3545;
        display: block;
        margin-top: 5px;
        font-size: 14px;
    }

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

        console.log('Programming title element:', programmingTitle);
        console.log('Day options element:', dayOptions);

        // Zet de huidige dag als geselecteerde optie
        const todayOption = document.querySelector('.day-option[data-day="vandaag"]');
        if (todayOption) {
            todayOption.classList.add('selected');
        }

        // Toggle dropdown bij klikken op titel
        programmingTitle.addEventListener('click', function(e) {
            e.stopPropagation();
            console.log('Title clicked, toggling dropdown');
            dayOptions.classList.toggle('active');
            dropdownArrow.classList.toggle('dropdown-arrow-active');
        });

        // Selecteer een dag uit de dropdown
        dayOptionElements.forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                console.log('Day option clicked:', this.textContent);

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

                // Laad programma voor geselecteerde dag (hier kan je een AJAX call toevoegen)
                console.log(`Programma laden voor: ${day}`);
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
