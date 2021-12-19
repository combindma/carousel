<?php

use Combindma\Carousel\Http\Controllers\CarouselController;
use Combindma\Carousel\Models\Carousel;
use function Pest\Faker\faker;
use function Pest\Laravel\from;
use function PHPUnit\Framework\assertCount;

/**
 * Set default data
 *
 * @return array
 */
function setData(array $data = [])
{
    return array_merge([
        'title' => strtolower(faker()->sentence(10)),
        'content' => strtolower(faker()->text),
        'description' => strtolower(faker()->sentence(20)),
        'published_at' => date('Y-m-d\TH:i'),
        'is_published' => 1,
        'is_featured' => 1,
        'meta' => ['field' => 'value'],
    ], $data);
}

test('user can create a carousel', function () {
    $data = setData();
    from(action([CarouselController::class, 'create']))
        ->post(action([CarouselController::class, 'store']), $data)
        ->assertSessionHasNoErrors()
        ->assertRedirect(action([CarouselController::class, 'index']));
    assertCount(1, $carousels = Carousel::all());
    $carousel = $carousels->first();
    expect($carousel->title)->toBe($data['title']);
    expect($carousel->content)->toBe($data['content']);
    expect($carousel->description)->toBe($data['description']);
    expect($carousel->published_at->format('Y-m-d\TH:i'))->toBe($data['published_at']);
    expect($carousel->is_published)->toBe($data['is_published']);
    expect($carousel->is_featured)->toBe($data['is_featured']);
    expect($carousel->meta['field'])->toBe($data['meta']['field']);
});

test('user can update a carousel', function () {
    $carousel = Carousel::factory()->create();
    $data = setData();
    from(action([CarouselController::class, 'edit'], ['carousel' => $carousel]))
        ->put(action([CarouselController::class, 'update'], ['carousel' => $carousel]), $data)
        ->assertRedirect(action([CarouselController::class, 'edit'], ['carousel' => $carousel]))
        ->assertSessionHasNoErrors();
    $carousel->refresh();
    expect($carousel->title)->toBe($data['title']);
    expect($carousel->content)->toBe($data['content']);
    expect($carousel->description)->toBe($data['description']);
    expect($carousel->published_at->format('Y-m-d\TH:i'))->toBe($data['published_at']);
    expect($carousel->is_published)->toBe($data['is_published']);
    expect($carousel->is_featured)->toBe($data['is_featured']);
});
