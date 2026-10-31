<x-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="mb-6">
            <a href="{{ route('welcome') }}"
                class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Home
            </a>
        </div>

        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Add New Polling Unit Results</h1>
            <p class="text-gray-500 mt-2 text-sm">Select LGA to load wards, then fill in polling unit details and party
                tallies.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-emerald-800 shadow-sm">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('pu.create') }}">
                <label for="lga_id" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                    Step 1: Select Local Government (LGA)
                </label>
                <select name="lga_id" id="lga_id" onchange="this.form.submit()"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-3">
                    <option value="">Choose an LGA to filter wards</option>
                    @foreach ($lgas as $lga)
                        <option value="{{ $lga->lga_id }}"
                            {{ isset($selected_lga) && $selected_lga == $lga->lga_id ? 'selected' : '' }}>
                            {{ $lga->lga_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <form action="{{ route('pu.store') }}" method="POST" class="space-y-6">
            @csrf

            <input type="hidden" name="lga_id" value="{{ $selected_lga }}">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Step 2: Polling Unit Details</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Ward</label>
                        <select name="ward_id"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-3"
                            required {{ !$selected_lga ? 'disabled' : '' }}>
                            <option value="">{{ $selected_lga ? 'Select Ward' : 'Select LGA First' }}</option>
                            @foreach ($wards as $ward)
                                <option value="{{ $ward->ward_id }}">{{ $ward->ward_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Polling
                            Unit Name</label>
                        <input type="text" name="polling_unit_name" placeholder="e.g. Primary School Unit 01"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-3"
                            required {{ !$selected_lga ? 'disabled' : '' }}>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Step 3: Enter Party Scores</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($parties as $party)
                        <div
                            class="flex items-center justify-between border border-gray-100 p-3 rounded-lg bg-gray-50/50">
                            <span class="font-bold text-sm text-gray-800">{{ $party->partyid }}</span>
                            <input type="number" name="scores[{{ substr($party->partyid, 0, 4) }}]" min="0"
                                value="0"
                                class="w-32 text-right bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required {{ !$selected_lga ? 'disabled' : '' }}>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit"
                class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition duration-150 {{ !$selected_lga ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ !$selected_lga ? 'disabled' : '' }}>
                Save Polling Unit Results
            </button>
        </form>
    </div>
</x-layout>
