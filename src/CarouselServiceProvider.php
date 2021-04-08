<?php

namespace Combindma\Carousel;

use Combindma\Carousel\Http\Livewire\OrderImages;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CarouselServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
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
}
