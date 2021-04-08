<?php

namespace Combindma\Carousel;

use Combindma\Carousel\Http\Controllers\CarouselController;
use Illuminate\Support\Facades\Route;

class Carousel
{
    public static function routes(string $prefix = 'dash')
    {
        Route::group(['prefix' => $prefix, 'as' => 'carousel::'], function () {
            Route::resource('carousels', CarouselController::class)->except(['show']);
        });
    }
}
