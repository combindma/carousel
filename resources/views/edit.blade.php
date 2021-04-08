@extends('dashui::layouts.app')
@section('title', 'Modifier carousel')
@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
@endpush
@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <form id="form-action" action="{{ route('carousel::carousels.update', $carousel) }}" method="POST" enctype="multipart/form-data">
            <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
                <div class="flex items-center">
                    <a href="{{ route('carousel::carousels.index') }}" class="inline-flex items-center p-1.5 border border-gray-300 shadow-sm text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="ml-3 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                        Modifier carousel
                    </h1>
                </div>
                <div class="mt-3 flex sm:mt-0 sm:ml-4">
                    <a href="{{ route('carousel::carousels.index') }}" class="btn-subtle">
                        Annuler
                    </a>
                    <button type="submit" class="btn ml-3">
                        Enregistrer
                    </button>
                </div>
            </div>
            @include('dashui::components.alert')
            @csrf
            @method('PUT')
            @include('carousel::form', ['createForm' => false])
        </form>
    </div>
@endsection
@push('js')
    <script type="text/javascript" src="{{ asset('vendor/carousel/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            heading: {
                options: [
                    {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                    {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                    {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'},
                    {model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3'},
                    {model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4'}
                ]
            }
        });
    </script>
@endpush
