<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $news->title }}
            </h2>
            @if(Auth::user()?->isAdmin())
                <div class="flex space-x-12">
                    <a href="{{ route('news.edit', $news) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                        {{ __('Edit') }}
                    </a>
                    <form method="POST" action="{{ route('news.destroy', $news) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500"
                                onclick="return confirm('Are you sure?')">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-200 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <img src="{{ Storage::url($news->image_path) }}" 
                         alt="{{ $news->title }}" 
                         class="w-70 h-70 object-cover rounded mb-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        {{ __('Published on') }} {{ $news->publish_date->format('F j, Y') }}
                    </p>
                    <div class="prose dark:prose-invert max-w-none">
                        {{ $news->content }}
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('news.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
                            {{ __('Back to News') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>