<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Car::create($request->all());
        return redirect()->route('cars.index')->with('success', 'Car created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::findOrFail($id);
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = Car::findOrFail($id);
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1800|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $car = Car::findOrFail($id);
        $car->update($request->all());
        return redirect()->route('cars.index')->with('success', 'Car updated successfully.');
    }

    /**
     * Show the confirmation form for deleting the specified resource.
     */
    public function confirmDelete(string $id)
    {
        $car = Car::findOrFail($id);
        return view('cars.delete', compact('car'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $car = Car::findOrFail($id);

        // Protect against CSRF and ensure it is a DELETE request
        if ($request->isMethod('delete')) {
            $car->delete();
            return redirect()->route('cars.index')->with('success', 'Car deleted successfully.');
        }

        return redirect()->route('cars.index')->with('error', 'Invalid delete request.');
    }
}
