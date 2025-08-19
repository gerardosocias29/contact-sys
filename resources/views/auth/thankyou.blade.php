<x-guest-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto bg-white p-8 rounded text-center">
            <h1 class="text-2xl font-bold mb-4 text-green-700">Thank You for Registering!</h1>
            <p class="mb-6 text-gray-700">Your account has been created successfully.</p>
            <a href="{{ route('dashboard') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Go to Dashboard</a>
        </div>
    </div>
</x-guest-layout>
