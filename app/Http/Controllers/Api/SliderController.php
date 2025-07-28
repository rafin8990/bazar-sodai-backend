<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    public function viewSliders()
    {
        $sliders = Slider::all();
        return view('dashboard.Slider.index', compact('sliders'));
    }
    public function createSlider(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url|max:255',
            'status' => 'boolean',
        ]);

        $slider = new Slider();

        $slider->title = $validatedData['title'] ?? null;
        $slider->subtitle = $validatedData['subtitle'] ?? null;
        $slider->button_text = $validatedData['button_text'] ?? null;
        $slider->button_link = $validatedData['button_link'] ?? null;
        $slider->status = $validatedData['status'] ?? false;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sliders'), $imageName);
            $slider->image = 'uploads/sliders/' . $imageName;
        }

        $slider->save();

        return response()->json(['success' => true, 'message' => 'Slider created successfully', 'data' => $slider], 201);
    }

    public function getAllSliders()
    {
        $sliders = Slider::all();
        return response()->json([
            'success' => true,
            'message' => 'Sliders retrieved successfully',
            'data' => $sliders
        ], 200);
    }

    public function getActiveSliders()
    {
        $sliders = Slider::where('status', true)->get();
        return response()->json($sliders);
    }

  public function updateSlider(Request $request, $id)
{
    $slider = Slider::findOrFail($id);

    $validatedData = $request->validate([
        'title' => 'nullable|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'button_text' => 'nullable|string|max:255',
        'button_link' => 'nullable|url|max:255',
        'status' => 'boolean',
    ]);

    if ($request->hasFile('image')) {
        if ($slider->image && file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }

        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/sliders'), $imageName);
        $validatedData['image'] = 'uploads/sliders/' . $imageName;
    }
    $slider->update($validatedData);

    return response()->json(['message' => 'Slider updated successfully']);
}


    public function deleteSlider($id)
    {
        $slider = Slider::findOrFail($id);
        if ($slider->image && file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }

        $slider->delete();
        return response()->json(['message' => 'Slider deleted successfully']);
    }

}
