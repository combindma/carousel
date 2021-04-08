<?php

namespace Combindma\Carousel\Http\Controllers;


use Combindma\Carousel\Http\Requests\CarouselRequest;
use Combindma\Carousel\Models\Carousel;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::with(['media'])
            ->latest('id')
            ->paginate(10);
        return view('carousel::carousels.index', compact('carousels'));
    }

    public function create()
    {
        $carousel = new Carousel();
        return view('carousel::carousels.create', compact('carousel'));
    }

    public function edit(Carousel $carousel)
    {
        $carousel->load('media');
        return view('carousel::carousels.edit', compact('carousel'));
    }

    public function store(CarouselRequest $request)
    {
        $carousel = Carousel::create($request->validated());

        if ($request->hasFile('featured_image'))
        {
            // Add Featured Media
            $carousel->addFeaturedImage($request->file('featured_image'));
        }

        if ($request->hasFile('images')) {
            // Add Media
            foreach ($request->images as $image) {
                $carousel->addImage($image);
            }
        }

        flash('Ajout effectué avec succès');
        return redirect(route('carousel::carousels.index'));
    }

    public function update(CarouselRequest $request, Carousel $carousel)
    {
        $carousel->update($request->validated());

        if ($request->hasFile('featured_image'))
        {
            // Add Featured Media
            $carousel->addFeaturedImage($request->file('featured_image'));
        }

        if ($request->hasFile('images')) {
            // Add Media
            foreach ($request->images as $image) {
                $carousel->addImage($image);
            }
        }

        flash('Enregistrement effectué avec succès');
        return back();
    }

    public function destroy(Carousel $carousel)
    {
        dd($carousel->delete());
        $carousel->delete();
        flash('Carousel supprimée avec succès');
        return back();
    }
}
