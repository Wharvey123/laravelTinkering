@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #111;
            color: #fff;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .fade-in {
            animation: fadeIn ease 1s;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }
        .film-container {
            position: relative;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1.5rem;
            border-radius: 1rem;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.8);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .film-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            filter: brightness(0.5); /* Consistent brightness from the start */
        }
        .film-content {
            flex: 1;
            z-index: 1;
            color: white;
            text-align: left;
        }
        .film-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }
        .film-details {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .film-poster {
            flex-shrink: 0;
            width: 300px;
            max-height: 450px;
            object-fit: cover;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);
        }
        .back-button {
            display: inline-block;
            margin-top: 1.5rem;
            font-size: 1.2rem;
            background-color: darkred;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: red;
        }
        @media (max-width: 768px) {
            .film-container {
                flex-direction: column;
                align-items: center;
            }
            .film-poster {
                width: 80%;
                max-height: auto;
            }
            .film-content {
                text-align: center;
            }
        }
    </style>

    <div class="film-container fade-in">
        @if (!empty($film))
            <img id="backgroundPoster" src="" alt="Movie Poster Background" class="film-background">
            <div class="film-content">
                <h1 class="film-title">{{ $film['name'] }}</h1>
                <p class="film-details"><strong>Director:</strong> {{ $film['director'] }}</p>
                <p class="film-details"><strong>Any:</strong> {{ $film['year'] }}</p>
                <p class="film-details"><strong>Descripció:</strong> {{ $film['description'] }}</p>
                <a href="/films" class="back-button">Back to Films</a>
            </div>
            <img id="posterImage" src="" alt="Movie Poster" class="film-poster">
        @else
            <div class="film-content">
                <h1 class="film-title">Film Not Found</h1>
                <p class="film-details">We couldn't find the details for this film. Please return to the films page.</p>
                <a href="/films" class="back-button">Back to Films</a>
            </div>
        @endif
    </div>

    <script>
        const movieTitle = @json($film['name'] ?? '');
        const movieYear = @json($film['year'] ?? '');
        const apiKey = "e897831c";
        if (movieTitle && movieYear) {
            const apiUrl = `http://www.omdbapi.com/?t=${encodeURIComponent(movieTitle)}&y=${movieYear}&apikey=${apiKey}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.Response === "True") {
                        document.getElementById('backgroundPoster').src = data.Poster;
                        document.getElementById('posterImage').src = data.Poster;
                    } else {
                        console.error("Poster not found:", data.Error);
                    }
                })
                .catch(error => console.error("Error fetching poster:", error));
        }
    </script>
@endsection
