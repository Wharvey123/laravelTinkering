<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all(); // Fetch all cars
        return view('cars.index', compact('cars')); // Pass data to the view
    }

    public function create()
    {
        return view('cars.create'); // Render the create car form
    }

    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Car::create($request->all()); // Save the car data
        return redirect()->route('cars.index')->with('success', 'Car created successfully.');
    }

    public function show(string $id)
    {
        $car = Car::findOrFail($id); // Find the car or throw a 404 error
        return view('cars.show', compact('car')); // Pass the single car to the view
    }

    public function edit(string $id)
    {
        $car = Car::findOrFail($id); // Find the car for editing
        return view('cars.edit', compact('car')); // Pass the car data to the view
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $car = Car::findOrFail($id); // Find the car to update
        $car->update($request->all()); // Update car data
        return redirect()->route('cars.index')->with('success', 'Car updated successfully.');
    }

    public function confirmDelete(string $id)
    {
        $car = Car::findOrFail($id); // Find the car for deletion confirmation
        return view('cars.delete', compact('car')); // Pass the car data to the delete view
    }

    public function destroy(Request $request, string $id)
    {
        $car = Car::findOrFail($id); // Find the car to delete

        // Protect against CSRF and ensure it is a DELETE request
        if ($request->isMethod('delete')) {
            $car->delete(); // Delete the car
            return redirect()->route('cars.index')->with('success', 'Car deleted successfully.');
        }

        return redirect()->route('cars.index')->with('error', 'Invalid delete request.');
    }
}
