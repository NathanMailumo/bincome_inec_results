<x-layout>
    <div class="max-w-2xl mx-auto py-16 px-4">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900">INEC Election Results Portal</h1>
            <p class="text-gray-500 text-sm mt-2">Select a section below to get started.</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden divide-y divide-gray-200">
            <a href="{{ route('pollingresult') }}" class="block p-5 text-gray-800 font-medium hover:bg-gray-50 transition">
                Polling Unit Results
            </a>
        </div>
    </div>
</x-layout>