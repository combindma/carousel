<?php

namespace Combindma\Carousel\Http\Livewire;

use Combindma\Carousel\Models\Carousel;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class OrderImages extends Component
{
    public $images;
    public $carouselId;

    public function mount($images, $carouselId)
    {
        $this->images = $images;
        $this->carouselId = $carouselId;
    }

    public function updateImageOrder($reordered)
    {
        foreach ($reordered as $data)
        {
            $media = Media::find($data['value']);
            if ($media)
            {
                $media->order_column = $data['order'];
                $media->save();
            }
        }

        $this->reorderImages();
    }

    public function removeImage($id)
    {
        Media::find($id)->delete();
        $this->reorderImages();
    }

    public function reorderImages()
    {
        $this->images = Carousel::find($this->carouselId)->images();
    }

    public function render()
    {
        return view('carousel::carousels.order-images');
    }
}
