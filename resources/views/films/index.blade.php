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
        .table-header {
            background-color: darkred;
            color: white;
            cursor: pointer;
        }
        .table-header i {
            margin-left: 5px;
        }
        .table-row {
            transition: background-color 0.3s ease;
        }
        .table-row:hover {
            background-color: lightgray;
            color: black;
        }
        .glow-button {
            background-color: darkred;
            color: #fff;
            transition: box-shadow 0.3s ease;
        }
        .glow-button:hover {
            box-shadow: 0 0 8px 2px white;
        }
        tbody td {
            font-weight: bold;
        }
        /* Ensure consistent spacing between elements */
        .filter-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .filter-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        /* Ensure icon stays next to input fields on mobile */
        .filter-item input {
            flex: 1;
        }
        .filter-item i {
            font-size: 18px;
            color: white;
        }
        /* Add horizontal scrolling to the table container */
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
        }
        table {
            min-width: 100%; /* Ensure the table takes full width */
        }
    </style>
    <div class="max-w-4xl w-full mx-auto container shadow-lg rounded-lg p-6 fade-in flex-grow mt-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-5xl font-extrabold title">Films</h1>
            <div class="top-right">
                <a href="/" style="font-size: 36px;" class="text-white"> <i class="fa">&#xf137;</i></a>
            </div>
        </div>
        <div class="top-left mb-4">
            <a href="{{ route('films.create') }}" class="glow-button px-6 py-3 rounded hover:bg-black hover-animate w-full">Afegir Nova Pel·lícula</a>
        </div>
        <div class="filter-container mt-4 mb-4">
            <div class="filter-item">
                <input type="text" id="searchYear" placeholder="Cerca per any..." class="p-2 border border-gray-300 rounded w-full text-black" />
                <i class="fas fa-search"></i>
            </div>
            <div class="filter-item">
                <input type="text" id="searchDirector" placeholder="Cerca per director..." class="p-2 border border-gray-300 rounded w-full text-black" />
                <i class="fas fa-search"></i>
            </div>
        </div>
        <div class="table-container mt-12">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden" id="filmsTable">
                <thead>
                <tr class="table-header text-sm uppercase leading-normal">
                    <th class="py-3 px-6 text-left" onclick="sortTable(0)">ID <i class="fas fa-sort"></i></th>
                    <th class="py-3 px-6 text-left" onclick="sortTable(1)">Títol <i class="fas fa-sort"></i></th>
                    <th class="py-3 px-6 text-left" onclick="sortTable(2)">Director <i class="fas fa-sort"></i></th>
                    <th class="py-3 px-6 text-left" onclick="sortTable(3)">Any <i class="fas fa-sort"></i></th>
                    <th class="py-3 px-6 text-center">Accions</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse ($films as $film)
                    <tr class="table-row border-b border-gray-200">
                        <td class="py-3 px-6">{{ $film->id }}</td>
                        <td class="py-3 px-6">
                            <a href="{{ route('films.show', $film->id) }}" class="text-blue-500 hover:text-blue-700">
                                {{ $film->name }}
                            </a>
                        </td>
                        <td class="py-3 px-6">{{ $film->director }}</td>
                        <td class="py-3 px-6">{{ $film->year }}</td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('films.edit', $film->id) }}" class="text-blue-500 hover:text-blue-700 mr-4">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('films.confirmDelete', $film->id) }}" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-3 px-6 text-center">No hi ha pel·lícules disponibles.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const searchYearInput = document.getElementById('searchYear'); // Filtrar per any
        const searchDirectorInput = document.getElementById('searchDirector'); // Filtrar per director

        searchYearInput.addEventListener('input', function () {
            const filterYear = searchYearInput.value.toLowerCase();
            filterTableRows(filterYear, 'year');
        });

        searchDirectorInput.addEventListener('input', function () {
            const filterDirector = searchDirectorInput.value.toLowerCase();
            filterTableRows(filterDirector, 'director');
        });

        function filterTableRows(filterValue, column) {
            const rows = document.querySelectorAll('#filmsTable tbody tr');
            rows.forEach(row => {
                const cell = column === 'year' ? row.cells[3] : row.cells[2]; // Year or Director column
                const cellValue = cell.textContent.toLowerCase();
                row.style.display = cellValue.includes(filterValue) ? '' : 'none';
            });
        }

        let sortDirection = {
            0: true, // ID
            1: true, // Title
            2: true,  // Director
            3: true  // Year
        };

        function sortTable(colIndex) { // Ordenar la taula
            const table = document.getElementById('filmsTable');
            const rows = Array.from(table.rows).slice(1); // Ignore the header
            rows.sort((a, b) => {
                const aText = a.cells[colIndex].textContent.trim(); // Trim whitespace
                const bText = b.cells[colIndex].textContent.trim(); // Trim whitespace
                // Sort ID as numbers, other columns as strings
                if (colIndex === 0) { // If ID column
                    return sortDirection[colIndex]
                        ? parseInt(aText) - parseInt(bText)
                        : parseInt(bText) - parseInt(aText);
                } else if (colIndex === 1 || colIndex === 2 || colIndex === 3) { // If Title, Director, or Year
                    return sortDirection[colIndex]
                        ? aText.localeCompare(bText)
                        : bText.localeCompare(aText);
                }
                return 0; // Don't sort by other columns
            });

            const tbody = table.querySelector('tbody');
            tbody.innerHTML = ''; // Clear existing rows
            rows.forEach(row => {
                tbody.appendChild(row); // Re-add the row
            });

            // Toggle the sorting direction
            sortDirection[colIndex] = !sortDirection[colIndex];

            // Update the icon for sorting direction
            const headers = document.querySelectorAll('.table-header i');
            headers.forEach(icon => {
                icon.classList.remove('fa-sort-up', 'fa-sort-down');
                icon.classList.add('fa-sort');
            });

            const currentHeader = headers[colIndex];
            currentHeader.classList.remove('fa-sort');
            if (sortDirection[colIndex]) {
                currentHeader.classList.add('fa-sort-up');
            } else {
                currentHeader.classList.add('fa-sort-down');
            }
        }
    </script>
@endsection
