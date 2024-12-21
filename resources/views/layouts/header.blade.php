<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projecte Laravel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dat.gui@0.7.7/build/dat.gui.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    button {
        font-size: 1.2em; /* Slightly smaller font size */
        padding: 0.4em 0.6em; /* Reduced padding */
        border-radius: 0.4em; /* Adjusted border radius */
        border: none;
        background-color: #000;
        color: #fff;
        cursor: pointer;
        box-shadow: 1.5px 1.5px 2.5px #000000b4; /* Slightly smaller shadow */
    }

    .button-container {
        position: relative;
        padding: 1px; /* Reduce padding inside the button container */
        margin: 0 5px; /* Reduce spacing between buttons */
        background: linear-gradient(90deg, red, darkred);
        border-radius: 0.6em; /* Slightly smaller border radius */
        transition: all 0.4s ease;
    }

    .button-container a {
        font-size: 1em; /* Make text smaller */
        padding: 0.4em 0.8em; /* Adjust padding */
    }


    .button-container::before {
        content: "";
        position: absolute;
        inset: 0;
        margin: auto;
        border-radius: 0.8em;
        z-index: -10;
        filter: blur(0);
        transition: filter 0.4s ease;
    }

    .button-container:hover::before {
        background: linear-gradient(90deg, yellow, darkgoldenrod);
        filter: blur(1em); /* Slightly reduced blur */
    }
    .button-container:active::before {
        filter: blur(0.2em);
    }
</style>

<header class="bg-transparent">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <!-- Logo -->
        <div class="flex lg:flex-1">
            <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">Harvey</span>
                <img class="h-8 w-auto" src="https://pngimg.com/uploads/crown/crown_PNG16.png" alt="Logo">
            </a>
        </div>

        <!-- Desktop Links -->
        <div class="hidden lg:flex lg:gap-x-12">
            <div class="button-container">
                <a href="{{ route('home') }}" class="text-lg font-semibold text-white px-6 py-3">Home</a>
            </div>
            <div class="button-container">
                <a href="{{ route('films.index') }}" class="text-lg font-semibold text-white px-6 py-3">Films</a>
            </div>
            <div class="button-container">
                <a href="{{ route('cars.index') }}" class="text-lg font-semibold text-white px-6 py-3">Cars</a>
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <div class="lg:hidden">
            <button id="menuButton" type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                <span class="sr-only">Open main menu</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="lg:hidden fixed inset-0 z-10 bg-black bg-opacity-50 p-6 hidden">
        <div class="w-full max-w-sm bg-white rounded-lg shadow-lg p-4">
            <div class="flex items-center justify-between">
                <a href="/" class="-m-1.5 p-1.5">
                    <span class="sr-only">Harvey</span>
                    <img class="h-8 w-auto" src="https://pngimg.com/uploads/crown/crown_PNG16.png" alt="Logo">
                </a>
                <button id="closeMenu" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Close menu</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 space-y-2">
                <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 text-base font-semibold text-gray-900 hover:bg-gray-50" onclick="closeMobileMenu()">Home</a>
                <a href="{{ route('films.index') }}" class="block rounded-lg px-3 py-2 text-base font-semibold text-gray-900 hover:bg-gray-50" onclick="closeMobileMenu()">Films</a>
                <a href="{{ route('cars.index') }}" class="block rounded-lg px-3 py-2 text-base font-semibold text-gray-900 hover:bg-gray-50" onclick="closeMobileMenu()">Cars</a>
            </div>
        </div>
    </div>
</header>

<script>
    // Get the mobile menu and buttons
    const menuButton = document.getElementById('menuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const closeMenuButton = document.getElementById('closeMenu');

    // Show the mobile menu when the menu button is clicked
    menuButton.addEventListener('click', function() {
        mobileMenu.classList.remove('hidden');
    });

    // Close the mobile menu when the close button is clicked
    closeMenuButton.addEventListener('click', function() {
        mobileMenu.classList.add('hidden');
    });

    // Close the menu when clicking anywhere outside the menu
    window.addEventListener('click', function(event) {
        if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Function to close menu after selecting an option
    function closeMobileMenu() {
        mobileMenu.classList.add('hidden');
    }
</script>
