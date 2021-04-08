<?php

namespace Combindma\Carousel\Tests\Feature;

use Combindma\Carousel\Models\Carousel;
use Combindma\Carousel\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarouselTest extends TestCase
{
    use RefreshDatabase;

    protected function setData($data = [])
    {
        return array_merge([
            'title' => strtolower($this->faker->sentence(10)),
            'content' => strtolower($this->faker->text),
            'description' => strtolower($this->faker->sentence(20)),
            'published_at' => date('Y-m-d\TH:i'),
            'is_published' => 1,
            'is_featured' => 1,
            'meta' => ['field' => 'value'],
        ], $data);
    }

    /** @test */
    public function user_can_create_a_carousel()
    {
        $data = $this->setData();
        $response = $this->from(route('carousel::carousels.create'))->post(route('carousel::carousels.store'), $data);
        $response->assertSessionHasNoErrors();
        $this->assertCount(1, $carousels = Carousel::all());
        $carousel = $carousels->first();
        $response->assertRedirect(route('carousel::carousels.index'));
        $this->assertEquals($data['title'], $carousel->title);
        $this->assertEquals($data['content'], $carousel->content);
        $this->assertEquals($data['description'], $carousel->description);
        $this->assertEquals($data['published_at'], $carousel->published_at->format('Y-m-d\TH:i'));
        $this->assertEquals($data['is_published'], $carousel->is_published);
        $this->assertEquals($data['is_featured'], $carousel->is_featured);
        $this->assertEquals($data['meta']['field'], $carousel->meta['field']);
    }

    /** @test */
    public function user_can_update_a_carousel()
    {
        $carousel = Carousel::factory()->create();
        $data = $this->setData();
        $response = $this->from(route('carousel::carousels.edit', $carousel))->put(route('carousel::carousels.update', $carousel), $data);
        $response->assertRedirect(route('carousel::carousels.edit', $carousel));
        $response->assertSessionHasNoErrors();
        $carousel->refresh();
        $this->assertEquals($data['title'], $carousel->title);
        $this->assertEquals($data['content'], $carousel->content);
        $this->assertEquals($data['description'], $carousel->description);
        $this->assertEquals($data['published_at'], $carousel->published_at->format('Y-m-d\TH:i'));
        $this->assertEquals($data['is_published'], $carousel->is_published);
        $this->assertEquals($data['is_featured'], $carousel->is_featured);
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function user_cannot_create_a_carousel_with_invalid_data($formInput, $formInputValue)
    {
        $data = $this->setData([
            $formInput => $formInputValue,
        ]);
        $response = $response = $this->from(route('carousel::carousels.create'))->post(route('carousel::carousels.store'), $data);
        $response->assertRedirect(route('carousel::carousels.create'));
        $response->assertSessionHasErrors($formInput);
        $this->assertCount(0, Carousel::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function user_cannot_update_a_carousel_with_invalid_data($formInput, $formInputValue)
    {
        $carousel = Carousel::factory()->create();
        $data = $this->setData([
            $formInput => $formInputValue,
        ]);
        $response = $this->from(route('carousel::carousels.edit', $carousel))->put(route('carousel::carousels.update', $carousel), $data);
        $response->assertRedirect(route('carousel::carousels.edit', $carousel));
        $response->assertSessionHasErrors($formInput);
    }

    public function postFormValidationProvider()
    {
        return[
            'title_is_required' => ['title', ''],
            'publish_date_is_required' => ['published_at', ''],
        ];
    }
}
