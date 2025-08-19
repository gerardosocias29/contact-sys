
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
<div class="p-6" x-data="{ openModal: false, deleteUrl: '', deleteForm: null }">
                    <div class="flex justify-end">
                        <a href="{{ route('contacts.create') }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Add Contact
                        </a>
                    </div>
                    <form method="GET" action="{{ route('contacts.index') }}" class="mb-6" x-data="{ search: '{{ request('search') }}', loading: false, results: '', timeout: null }" @submit.prevent="">
                        <div class="flex flex-col sm:flex-row gap-2 mt-2">
                            <input type="text" name="search" x-model="search" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" placeholder="Search contacts..." @input.debounce.400ms="
                                clearTimeout(timeout);
                                loading = true;
                                timeout = setTimeout(() => {
                                    fetch('{{ route('contacts.index') }}?search=' + encodeURIComponent(search), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                                        .then(r => r.text())
                                        .then(html => {
                                            let parser = new DOMParser();
                                            let doc = parser.parseFromString(html, 'text/html');
                                            let tbody = doc.querySelector('#contacts-tbody');
                                            let pagination = doc.querySelector('#contacts-pagination');
                                            if (tbody && pagination) {
                                                document.getElementById('contacts-tbody').innerHTML = tbody.innerHTML;
                                                document.getElementById('contacts-pagination').innerHTML = pagination.innerHTML;
                                            }
                                            loading = false;
                                        });
                                }, 400);
                            ">
                            <button class="px-4 py-2 bg-blue-50 text-blue-700 border border-blue-600 rounded hover:bg-blue-100 transition" type="submit" @click.prevent="">
                                <span x-show="!loading">Search</span>
                                <span x-show="loading">Searching...</span>
                            </button>
                        </div>
                    </form>
                    @if(session('success'))
                        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-200">{{ session('success') }}</div>
                    @endif
                    <div class="overflow-x-auto bg-white rounded shadow">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="contacts-tbody" class="bg-white divide-y divide-gray-100">
                                @forelse($contacts as $contact)
                                    <tr>
                                        <td class="px-4 py-2">{{ $contact->name }}</td>
                                        <td class="px-4 py-2">{{ $contact->company }}</td>
                                        <td class="px-4 py-2">{{ $contact->phone }}</td>
                                        <td class="px-4 py-2">{{ $contact->email }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <a href="{{ route('contacts.edit', $contact) }}" class="inline-block px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500 transition mr-1">Edit</a>
                                            <button type="button"
                                                @click="openModal = true; deleteUrl = '{{ route('contacts.destroy', $contact) }}'; deleteForm = $event.target.closest('tr')"
                                                class="inline-block px-3 py-1 bg-red-500 rounded hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-4 py-4 text-center text-gray-500">No contacts found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6" id="contacts-pagination">
                        {{ $contacts->withQueryString()->links() }}
                    </div>

                    <!-- Global Delete Modal -->
                    <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
                            <h3 class="text-lg font-semibold mb-4">Confirm Delete</h3>
                            <p class="mb-6">Are you sure you want to delete this contact?</p>
                            <div class="flex justify-end gap-2">
                                <button @click="openModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Cancel</button>
                                <form :action="deleteUrl" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
