<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('FAQ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-green-500/10 border-l-4 border-green-500 text-green-400 p-4 rounded" role="alert">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(auth()->user()?->is_admin)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="max-w-xl">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 mb-4">
                                {{ __('Add New FAQ Category') }}
                            </h2>

                            <form method="POST" action="{{ route('faq.categories.store') }}">
                                @csrf
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <input type="text" 
                                            name="name" 
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                                            placeholder="{{ __('Enter category name') }}" 
                                            required 
                                            autocomplete="off">
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        {{ __('Add Category') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-6">
                @forelse ($categories as $category)
                    <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <!-- Category Header -->
                            @if(auth()->user()?->is_admin)
                                <div class="flex items-center gap-4 mb-6">
                                    <form method="POST" action="{{ route('faq.categories.update', $category) }}" class="flex-1 flex gap-4">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <button type="button" @click="open = !open" class="mr-2">
                                                    <svg :class="{'rotate-90': open}" class="transform transition-transform duration-200 w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </button>
                                                <input type="text" 
                                                    name="name" 
                                                    value="{{ $category->name }}" 
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                {{ __('Update') }}
                                            </button>
                                            <form method="POST" action="{{ route('faq.categories.destroy', $category) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this category and all its questions?') }}')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="flex items-center cursor-pointer" @click="open = !open">
                                    <svg :class="{'rotate-90': open}" class="transform transition-transform duration-200 w-5 h-5 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $category->name }}
                                    </h2>
                                </div>
                            @endif

                            <!-- Questions (Collapsible) -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-2"
                                class="mt-4 space-y-6">
                                
                                @foreach($category->faqItems as $item)
                                    <div class="border-l-4 border-indigo-500 pl-4 py-1">
                                        @if(auth()->user()?->is_admin)
                                            <form method="POST" action="{{ route('faq.items.update', $item) }}" class="space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Question') }}</label>
                                                    <input type="text" 
                                                        name="question" 
                                                        value="{{ $item->question }}" 
                                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                        required>
                                                </div>
                                                <div>
                                                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Answer') }}</label>
                                                    <textarea name="answer" 
                                                        rows="3" 
                                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                        required>{{ $item->answer }}</textarea>
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                        {{ __('Update') }}
                                                    </button>
                                                    <form method="POST" action="{{ route('faq.items.destroy', $item) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this question?') }}')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </form>
                                        @else
                                            <div class="mb-4">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $item->question }}
                                                </h3>
                                                <p class="mt-2 text-gray-600 dark:text-gray-400">
                                                    {{ $item->answer }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                @if(auth()->user()?->is_admin)
                                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                            {{ __('Add New Question') }}
                                        </h3>
                                        <form method="POST" action="{{ route('faq.items.store', $category) }}" class="space-y-4">
                                            @csrf
                                            <div>
                                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Question') }}</label>
                                                <input type="text" 
                                                    name="question" 
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                                                    placeholder="{{ __('Enter your question') }}"
                                                    required>
                                            </div>
                                            <div>
                                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Answer') }}</label>
                                                <textarea name="answer" 
                                                    rows="3" 
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                                                    placeholder="{{ __('Enter your answer') }}"
                                                    required></textarea>
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    {{ __('Add Question') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No FAQ categories available yet.') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>