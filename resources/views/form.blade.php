<div class="mt-8 grid grid-cols-1 gap-6 lg:grid-flow-col-dense lg:grid-cols-3">
    <div class="lg:col-start-1 lg:col-span-2">
        <!-- Titre/Contenu -->
        <div class="mb-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="mb-6">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" id="title" name="title" placeholder="Ajoutez un titre à afficher" value="{{ old('title', ucfirst(optional($carousel)->title)) }}" class="form-control" required>
                </div>
                <div class="mb-6">
                    <label for="editor" class="form-label">Contenu</label>
                    <textarea name="content" id="editor">{!! old('content', optional($carousel)->content) !!}</textarea>
                </div>
                <div class="mb-6">
                    <label for="description" class="form-label">Description courte</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', optional($carousel)->description) }}</textarea>
                </div>
                <div class="mb-1">
                    <label for="meta-bg-class" class="form-label">Couleur Background</label>
                    <input type="text" name="meta[bg-class]" id="meta-bg-class" class="form-control" placeholder="bg-blue, bg-red, bg-yellow, bg-contrast-high..." value="{{ old('meta.bg-class', optional($carousel?->meta)['bg-class']) }}"/>
                </div>
            </div>
        </div>


        <!-- Images -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <p class="form-legend">Images carousel</p>
                <p class="mt-2 mb-4 text-sm text-gray-600">Ajoutez une galerie d'images que vous souhaitez afficher et classez-les selon un ordre.</p>
                @if (!$createForm && !$carousel->images()->isEmpty())
                    <livewire:carousel-order-images :images="$carousel->images()" :carouselId="$carousel->id"/>
                @endif
                <div class="mt-6">
                    <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-start-3 lg:col-span-1">
        <!-- Visibilité -->
        <div class="mb-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <p class="form-legend mb-4">Visibilité</p>
                <div class="mb-6">
                    <label class="form-label" for="published_at">Date publication</label>
                    <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', optional($carousel->published_at)->format('Y-m-d\TH:i')) }}" class="form-control" required>
                </div>

                <div class="mb-2">
                    <div class="flex items-center">
                        <input class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" type="checkbox" id="is_published" name="is_published" value="1" @if (old('is_published', optional($carousel)->is_published)) checked @endif>
                        <label for="is_published" class="ml-2 block text-sm text-gray-900">
                            Publier
                        </label>
                    </div>
                </div>

                <div class="mb-1">
                    <div class="flex items-center">
                        <input class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" type="checkbox" id="is_featured" name="is_featured" value="1"
                               @if (old('is_featured', optional($carousel)->is_featured)) checked @endif>
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                            Mettre en avant
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Vedette -->
        <div class="mb-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <p class="form-legend mb-4">Image vedette</p>
                <div class="p-4 border-4 border-dashed border-gray-200 rounded-lg">
                    <div class="mb-4">
                        @if (!$createForm && $carousel->featured_image())
                            {{ $carousel->featured_image() }}
                        @endif
                    </div>
                    <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
                </div>
            </div>
        </div>
    </div>
</div>
