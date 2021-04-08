<div>
    <div wire:sortable="updateImageOrder" class="grid grid-cols-2 gap-5 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8">
        @foreach($images as $image)
            <div class="group relative border border-gray-200" wire:sortable.item="{{ $image->id }}" wire:key="image-{{ $image->id }}">
                <figure wire:sortable.handle class="cursor-move relative">
                    <img src="{{ $image->getUrl('thumb') }}">
                </figure>
                <div class="absolute -top-0.5 -right-0.5 p-1 opacity-0 group-hover:opacity-100">
                    <button type="button" wire:click="removeImage({{ $image->id }})">
                        <svg class="h-4 w-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
