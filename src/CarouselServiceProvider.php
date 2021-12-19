<?php

namespace Combindma\Carousel;

use Combindma\Carousel\Http\Controllers\CarouselController;
use Combindma\Carousel\Http\Livewire\OrderImages;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CarouselServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('carousel')
            ->hasViews()
            ->hasAssets()
            ->hasMigration('create_carousels_table');
    }

    public function packageBooted()
    {
        Livewire::component('carousel-order-images', OrderImages::class);
    }

    public function packageRegistered()
    {
        Route::macro('carousel', function (string $baseUrl = 'admin') {
            Route::group(['prefix' => $baseUrl, 'as' => 'carousel::'], function () {
                Route::resource('carousels', CarouselController::class)->except(['show']);
            });
        });
    }
}
