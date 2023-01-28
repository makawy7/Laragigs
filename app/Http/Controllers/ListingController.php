<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $listings = Listing::latest()->filter(['tag' => $request->tags, 'search' => $request->search])->paginate(8);
        return view('listings.index', ['listings' => $listings]);
    }
    public function show(Listing $listing)
    {
        return view('listings.show', ['listing' => $listing]);
    }
    public function create()
    {
        return view('listings.create');
    }
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required|unique:listings,company',
            'log' => 'sometimes|image|max:5000',
            'location' => 'required',
            'email' => 'required|email|unique:listings,email',
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required|min:25',
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        Listing::create($formFields);
        return redirect()->route('home')->with('success', 'Listing created sucessfully!');
    }
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }
    public function update(Listing $listing, Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required|unique:listings,company,' . $listing->id,
            'log' => 'sometimes|image|max:5000',
            'location' => 'required',
            'email' => 'required|email|unique:listings,email,' . $listing->id,
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required|min:25',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($listing->logo ?? false) {
            if (Storage::fileExists($listing->logo)) {
                Storage::delete($listing->logo);
            }
        }

        $listing->update($formFields);
        session()->flash('success', 'Listing has been updated successfully!');
        return redirect()->route('showListing', $listing->id);
    }
    public function destroy(Listing $listing)
    {
        if ($listing->logo ?? false) {
            if (Storage::fileExists($listing->logo)) {
                Storage::delete($listing->logo);
            }
        }
        $listing->delete();
        return redirect()->route('home')->with('success', 'Listing has been deleted successfully!');
    }
}
