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
    </style>
    <div class="max-w-4xl w-full mx-auto container shadow-lg rounded-lg p-6 fade-in flex-grow mt-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-5xl font-extrabold title">Films</h1>
            <div class="top-right">
                <a href="/" style="font-size: 36px;" class="text-white"> <i class="fa">&#xf137;</i></a>
            </div>
        </div>
        <div class="top-left">
            <a href="{{ route('films.create') }}" class="glow-button px-6 py-3 rounded hover:bg-black hover-animate w-full">Afegir Nova Pel·lícula</a>
        </div>
        <div class="mt-4">
            <input type="text" id="search" placeholder="Cerca per any..." class="p-2 border border-gray-300 rounded w-full text-black" />
        </div>
        <div class="overflow-x-auto mt-12">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden" id="filmsTable">
                <thead>
                <tr class="table-header text-sm uppercase leading-normal">
                    <th class="py-3 px-6 text-left" onclick="sortTable(0)">ID <i class="fas fa-sort"></i></th>
                    <th class="py-3 px-6 text-left" onclick="sortTable(1)">Títol <i class="fas fa-sort"></i></th>
                    <th class="py-3 px-6 text-left">Director</th>
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
        const searchInput = document.getElementById('search');     // Filtrar per any
        searchInput.addEventListener('input', function () {
            const filter = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('#filmsTable tbody tr');
            rows.forEach(row => {
                const yearCell = row.cells[3].textContent.toLowerCase();
                row.style.display = yearCell.includes(filter) ? '' : 'none'; // Filtra la fila
            });
        });

        let sortDirection = {
            0: true, // ID
            1: true, // Title
            3: true  // Year
        };

        function sortTable(colIndex) {     // Ordenar la taula
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
                } else if (colIndex === 1 || colIndex === 3) { // If Title or Year
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
