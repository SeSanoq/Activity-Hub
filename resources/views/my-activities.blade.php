<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-orange-600">
            My Activities
        </h2>
    </x-slot>

    <div class="py-10 bg-orange-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @forelse($registrations as $reg)

            <div class="bg-white rounded-2xl shadow-md p-6 mb-6 border border-orange-100 hover:shadow-lg transition">

                <!-- TITLE -->
                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    {{ $reg->activity->title }}
                </h3>

                <!-- INFO -->
                <p class="text-gray-600">
                    📅 {{ $reg->activity->date }}
                </p>

                <p class="text-gray-600 mt-1">
                    📍 {{ $reg->activity->location }}
                </p>

                <!-- STATUS -->
                <p class="mt-2 font-semibold
                    @if($reg->status === 'approved') text-green-500
                    @elseif($reg->status === 'rejected') text-red-500
                    @else text-yellow-500
                    @endif
                ">
                    Status: {{ $reg->status }}
                </p>

                <!-- BUTTON -->
                <a href="/activities/{{ $reg->activity->id }}">
                    <button class="mt-4 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition">
                        View Detail
                    </button>
                </a>

            </div>

            @empty
                <p class="text-gray-500 text-center">
                    ยังไม่มีกิจกรรมที่สมัคร
                </p>
            @endforelse

        </div>
    </div>

</x-app-layout>