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
            <div class="mb-6 bg-green-500/10 border-l-4 border-green-500 text-green-400 p-4 rounded" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
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
<div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            {{ __('Comments') }}
        </h3>

        @auth
            <form action="{{ route('news.comments.store', $news) }}" method="POST" class="mb-6">
                @csrf
                <div>
                    <x-label for="content" value="{{ __('Add a comment') }}" />
                    <textarea
                        name="content"
                        id="content"
                        rows="3"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                        required
                    >{{ old('content') }}</textarea>
                    <x-input-error for="content" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-button>
                        {{ __('Post Comment') }}
                    </x-button>
                </div>
            </form>
        @else
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                    {{ __('Log in') }}
                </a>
                {{ __('to add a comment.') }}
            </p>
        @endauth

        <div class="space-y-6">
            @forelse ($news->comments as $comment)
                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <img src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}" class="h-10 w-10 rounded-full">
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $comment->user->name }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $comment->created_at->diffForHumans() }}
                                </div>
                            </div>
                            @if(Auth::user()?->isAdmin() || Auth::id() === $comment->user_id)
                                <form method="POST" action="{{ route('news.comments.destroy', [$news, $comment]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure?')">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                            {{ $comment->content }}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">
                    {{ __('No comments yet.') }}
                </p>
            @endforelse
        </div>
    </div>
</div>
    </div>
</x-app-layout>