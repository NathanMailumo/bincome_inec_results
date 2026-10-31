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
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Polling Unit Election Results</h1>
            <p class="text-gray-500 mt-2 text-sm">Select a polling unit from the dropdown below to view individual party tallies.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <form method="GET" class="w-full">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Select Polling Unit</label>
                    <select name="polling_unit_id" onchange="this.form.submit()"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Choose Polling Unit --</option>
                        @foreach ($polling_unit as $pu)
                            @if (!empty(trim($pu->polling_unit_name)))
                                <option value="{{ $pu->uniqueid }}"
                                    {{ $selected_polling_unit == $pu->uniqueid ? 'selected' : '' }}>
                                    {{ $pu->polling_unit_name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        @if (isset($selected_polling_unit) && $selected_polling_unit)
            <div class="mb-4">
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $unitDetail->polling_unit_name ?? 'Selected Polling Unit' }}
                </h2>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if (count($result) > 0)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                                <th scope="col" class="py-3 px-6">Political Party</th>
                                <th scope="col" class="py-3 px-6 text-right">Votes / Score</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @foreach ($result as $r)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">
                                        <span class="inline-block w-16 px-2 py-0.5 rounded text-center bg-gray-100 border border-gray-200 text-xs tracking-wide">
                                            {{ $r->party_abbreviation }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right font-semibold text-indigo-600 text-base">
                                        {{ number_format($r->party_score) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <p class="text-gray-500 text-sm">No results stored for this polling unit yet.</p>
                    </div>
                @endif
            </div>
        @else
            <div class="bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20">
                    </path>
                </svg>
                <p class="text-gray-600 font-medium text-sm">Please select a polling unit above to view party results.</p>
            </div>
        @endif
    </div>
</x-layout>