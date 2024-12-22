@extends('layouts.app')

@section('content')
    <style>
        .fade-in {
            animation: fadeIn ease 1s;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }
        body {
            background-color: #111;
            color: #fff;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .car-details {
            background-color: rgba(34, 34, 34, 0.8); /* Semi-transparent background */
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            z-index: 2;
            margin-top: 2rem; /* Ensure it appears below the images */
        }
        .car-details h2 {
            color: darkred;
            margin-bottom: 10px;
        }
        .image-gallery-container {
            padding: 1rem;
            display: flex;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }
        .image-gallery {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            justify-content: center;
            align-items: center;
        }
        .image-gallery-row {
            display: flex;
            gap: 1rem;
            justify-content: center;
            position: relative;
        }
        .poster-container {
            position: relative;
            width: 200px; /* Adjusted for rectangular size */
            height: 120px; /* Adjusted for rectangular size */
            object-fit: cover;
            border-radius: 8px;
        }
        .poster {
            width: 100%;
            height: 100%;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>

    <div class="max-w-4xl w-full mx-auto container shadow-lg rounded-lg p-6 fade-in flex-grow mt-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-5xl font-extrabold title">
                {{ $car ? $car->make . ' ' . $car->model : 'Cotxes' }}
            </h1>
            <div class="top-right">
                <a href="{{ route('cars.index') }}" style="font-size: 36px;" class="text-white">
                    <i class="fa">&#xf137;</i>
                </a>
            </div>
        </div>
        <div class="image-gallery-container" id="imageGalleryContainer">
            <div class="image-gallery" id="imageGallery"></div>
        </div>
        @if ($car)
            <div class="car-details" id="carDetails">
                <p><strong>Any:</strong> {{ $car->year }}</p>
                <p><strong>Preu:</strong> {{ $car->price }} €</p>
                <p><strong>Descripció:</strong> {{ $car->description }}</p>
            </div>
        @else
            <div class="car-details">
                <p>No hi ha cotxes disponibles.</p>
            </div>
        @endif
    </div>

    <script>
        const carMake = "{{ $car->make }}";
        const carModel = "{{ $car->model }}";
        const carYear = "{{ $car->year }}";
        const carPrice = "{{ $car->price }}";
        const carDescription = "{{ $car->description }}";
        const apiKey = "BZrzxWnJDomztVU6UQPQFbsjMb2btnIl9b_PpiPiWZs"; // Your Unsplash Access Key
        const apiUrl = `https://api.unsplash.com/search/photos?query=${encodeURIComponent(carMake + ' ' + carModel)}&client_id=${apiKey}`;
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                const imageGallery = document.getElementById('imageGallery');
                if (data.results && data.results.length > 0) {
                    const imagesToShow = data.results.slice(0, 9); // Limit to 9 images
                    let rowCount = 1; // Start with 1 image
                    let imageCount = 0;
                    while (imageCount < imagesToShow.length) {
                        const row = document.createElement('div');
                        row.classList.add('image-gallery-row');
                        for (let i = 0; i < rowCount && imageCount < imagesToShow.length; i++) {
                            const image = imagesToShow[imageCount];
                            const container = document.createElement('div');
                            container.classList.add('poster-container');

                            const imgElement = document.createElement('img');
                            imgElement.src = image.urls.regular;
                            imgElement.alt = "Car Image";
                            imgElement.classList.add('poster');

                            container.appendChild(imgElement);
                            row.appendChild(container);
                            imageCount++;
                        }
                        imageGallery.appendChild(row);
                        rowCount = rowCount < 5 ? rowCount + 2 : rowCount; // Increase row size for next row
                    }
                } else {
                    console.error("Car images not found.");
                }
            })
            .catch(error => console.error("Error fetching car images:", error));
    </script>

@endsection
