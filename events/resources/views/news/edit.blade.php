<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit News Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('news.update', $news) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-label for="title" value="{{ __('Title') }}" />
                            <x-input id="title" type="text" name="title" class="mt-1 block w-full" :value="old('title', $news->title)" required autofocus />
                            <x-input-error for="title" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="content" value="{{ __('Content') }}" />
                            <textarea id="content" name="content" rows="6" 
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" 
                                required>{{ old('content', $news->content) }}</textarea>
                            <x-input-error for="content" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label for="image" value="{{ __('Image') }}" />
                            <input type="file" id="image" name="image" class="mt-1 block w-full" />
                            <x-input-error for="image" class="mt-2" />
                            @if($news->image_path)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($news->image_path) }}" alt="Current image" class="w-48 h-32 object-cover rounded">
                                </div>
                            @endif
                        </div>

                        <!--<div class="mb-4">
                            <x-label for="publish_date" value="{{ __('Publish Date') }}" />
                            <x-input id="publish_date" type="datetime-local" name="publish_date" class="mt-1 block w-full" 
                                :value="old('publish_date', $news->publish_date->format('Y-m-d\TH:i'))" required />
                            <x-input-error for="publish_date" class="mt-2" />
                        </div> -->

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('news.show', $news) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 me-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Update News Item') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>