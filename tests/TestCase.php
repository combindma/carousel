<?php

namespace Combindma\Carousel\Tests;

use Combindma\Carousel\CarouselServiceProvider;
use Combindma\Carousel\Http\Controllers\CarouselController;
use Elegant\Sanitizer\Laravel\SanitizerServiceProvider;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Combindma\\Carousel\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
        //$this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [
            CarouselServiceProvider::class,
            SanitizerServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('sluggable', [
            'source' => null,
            'method' => null,
            'onUpdate' => false,
            'separator' => '-',
            'unique' => true,
            'uniqueSuffix' => null,
            'firstUniqueSuffix' => 2,
            'includeTrashed' => false,
            'reserved' => null,
            'maxLength' => null,
            'maxLengthKeepWords' => true,
            'slugEngineOptions' => [],
        ]);

        include_once __DIR__.'/../database/migrations/create_carousels_table.php.stub';
        (new \CreateCarouselsTable())->up();
    }

    protected function defineRoutes($router)
    {
        Route::group(['as' => 'carousel::', 'middleware' => ['bindings']], function () {
            Route::resource('carousels', CarouselController::class)->except(['show']);
        });
    }
}
