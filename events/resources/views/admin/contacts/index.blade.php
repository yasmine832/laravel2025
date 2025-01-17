<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-black">
            {{ __('Contact Messages') }}
        </h2>
    </x-slot>

    <!-- Search and Filter Section -->
    <div class="my-4 flex items-center space-x-4">
        <form action="{{ route('admin.contacts.index') }}" method="GET" class="flex items-center space-x-2">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="By name/email" 
                   class="px-4 py-2 w-80 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 border-gray-300">
            <select name="replied" 
                    class="px-4 py-2 w-48 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 border-gray-300">
                <option value="1" {{ request('replied') === '1' ? 'selected' : '' }}>Replied</option>
                <option value="0" {{ request('replied') === '0' ? 'selected' : '' }}>Not Replied</option>
            </select>
            <button type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Search & Filter
            </button>
        </form>
    </div>

    <!-- Messages Table -->
    <div class="bg-slate-900 rounded-lg shadow-lg overflow-hidden">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="px-6 py-4 bg-slate-800 text-left">
                        <span class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Name</span>
                    </th>
                    <th class="px-6 py-4 bg-slate-800 text-left">
                        <span class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Email</span>
                    </th>
                    <th class="px-6 py-4 bg-slate-800 text-left">
                        <span class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Subject</span>
                    </th>
                    <th class="px-6 py-4 bg-slate-800 text-left">
                        <span class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Status</span>
                    </th>
                    <th class="px-6 py-4 bg-slate-800 text-left">
                        <span class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Message</span>
                    </th>
                    <th class="px-6 py-4 bg-slate-800"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @foreach ($contacts as $contact)
                    <tr class="hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 text-slate-200">{{ $contact->name }}</td>
                        <td class="px-6 py-4 text-slate-200">{{ $contact->email }}</td>
                        <td class="px-6 py-4 text-slate-200">{{ $contact->subject }}</td>
                        <td class="px-6 py-4">
                            <span class="{{ $contact->replied ? 'bg-indigo-600' : 'bg-red-600' }} px-3 py-1 rounded-full text-sm text-white">
                                {{ $contact->replied ? 'Replied' : 'Pending' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-200">
                            <div class="max-w-xl">
                                {{ $contact->message }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                @if(!$contact->replied)
                                    <button onclick="document.getElementById('reply-{{ $contact->id }}').classList.toggle('hidden')"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors duration-200">
                                        Reply
                                    </button>
                                @endif
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition-colors duration-200">
                                        Delete
                                    </button>
                                </form>
                            </div>

                            <div id="reply-{{ $contact->id }}" class="hidden mt-4">
                                <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}">
                                    @csrf
                                    <textarea name="reply_message" 
                                              rows="3" 
                                              class="block w-full rounded-md border-gray-300 bg-slate-800 text-slate-200 focus:border-indigo-500 focus:ring-indigo-500" 
                                              placeholder="Write your reply"></textarea>
                                    <button type="submit" 
                                            class="mt-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors duration-200">
                                        Send Reply
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 bg-slate-800">
            {{ $contacts->appends(request()->query())->links() }}
        </div>
    </div>
</x-admin-layout>



<!-- this code was adapted from https://chatgpt.com/share/678a7c56-a698-8007-bfa7-4713a61b9b0d -->