<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        <div class="grid gap-6">
                            <!-- Name -->
                            <div>
                                <x-label for="name" value="{{ __('Name') }}" />
                                <x-input id="name" type="text" name="name" :value="old('name')" required autofocus class="mt-1 block w-full" />
                                <x-input-error for="name" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" type="email" name="email" :value="old('email')" required class="mt-1 block w-full" />
                                <x-input-error for="email" class="mt-2" />
                            </div>

                            <!-- Subject -->
                            <div>
                                <x-label for="subject" value="{{ __('Subject') }}" />
                                <x-input id="subject" type="text" name="subject" :value="old('subject')" required class="mt-1 block w-full" />
                                <x-input-error for="subject" class="mt-2" />
                            </div>

                            <!-- Message -->
                            <div>
                                <x-label for="message" value="{{ __('Message') }}" />
                                <textarea id="message" name="message" required
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                                    rows="6">{{ old('message') }}</textarea>
                                <x-input-error for="message" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end">
                                <x-button>
                                    {{ __('Send Message') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>