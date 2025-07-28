<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{

    public function index()
    {
        $advertisements = Advertise::all();
        return view('dashboard.Advertise.index', compact('advertisements'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'btn_text' => 'nullable|string|max:255',
            'btn_link' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $advertise = new Advertise();

        $advertise->title = $validatedData['title'] ?? null;
        $advertise->description = $validatedData['description'] ?? null;
        $advertise->btn_text = $validatedData['btn_text'] ?? null;
        $advertise->btn_link = $validatedData['btn_link'] ?? null;
        $advertise->status = $validatedData['status'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/advertise'), $imageName);
            $advertise->image = 'uploads/advertise/' . $imageName;
        }

        $advertise->save();

        return redirect()->route('advertise.index')->with('success', 'Advertise created successfully.');
    }
    public function edit($id)
    {
        $editAdvertise = Advertise::findOrFail($id);
        $advertisements = Advertise::latest()->get();
        return view('dashboard.advertise.index', compact('advertisements', 'editAdvertise'));
    }

    public function update(Request $request, $id)
    {
        $advertise = Advertise::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'btn_text' => 'nullable|string|max:255',
            'btn_link' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($advertise->image && file_exists(public_path($advertise->image))) {
                unlink(public_path($advertise->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/advertise'), $imageName);
            $validatedData['image'] = 'uploads/advertise/' . $imageName;
        }

        $advertise->update($validatedData);

        return redirect()->route('advertise.index')->with('success', 'Advertise updated successfully.');
    }


    public function destroy($id)
    {
        $advertise = Advertise::findOrFail($id);
        if ($advertise->image && file_exists(public_path('uploads/advertise/' . $advertise->image))) {
            unlink(public_path('uploads/advertise/' . $advertise->image));
        }

        $advertise->delete();

        return redirect()->back()->with('success', 'Advertise deleted successfully.');
    }

    public function getActiveAdvertises()
    {
        $advertisements = Advertise::where('status', 'active')
            ->latest()
            ->get(['id', 'title', 'description', 'image', 'btn_text', 'btn_link']);

        return response()->json([
            'success' => true,
            'message' => 'Active advertisements retrieved successfully.',
            'data' => $advertisements,
        ], 200);
    }
}
