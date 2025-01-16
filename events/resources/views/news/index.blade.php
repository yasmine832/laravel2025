<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('News') }}
            </h2>
            @if(Auth::user()?->isAdmin())
                <a href="{{ route('news.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                    {{ __('Create News Item') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
            <div class="mb-6 bg-green-500/10 border-l-4 border-green-500 text-green-400 p-4 rounded" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @foreach($news as $newsItem)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <img src="{{ Storage::url($newsItem->image_path) }}" 
                                     alt="{{ $newsItem->title }}" 
                                     class="w-48 h-32 object-cover rounded">
                            </div>
                            <div class="ml-12 flex-1">
                              <div class="flex justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $newsItem->title }}
                                    </h3>
                                    @if(Auth::user()?->isAdmin())
                                        <div class="flex space-x-12">
                                            <a href="{{ route('news.edit', $newsItem) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ __('Edit') }}
                                            </a>
                                            <form method="POST" action="{{ route('news.destroy', $newsItem) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('Are you sure?')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Published on') }} {{ $newsItem->publish_date->format('F j, Y') }}
                                </p>
                                <p class="mt-2 text-gray-600 dark:text-gray-300">
                                    {{ Str::limit($newsItem->content, 200) }}
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('news.show', $newsItem) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
                                        {{ __('Read More') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $news->links() }}
        </div>
    </div>
</x-app-layout>