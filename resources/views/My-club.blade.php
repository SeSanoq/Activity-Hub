<x-app-layout>
<div class="max-w-6xl mx-auto px-4 py-10">

    <!-- TITLE -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">
            My Club Activities
        </h1>
        <p class="text-gray-500 text-sm">
            จัดการกิจกรรมและผู้เข้าร่วมของคุณ
        </p>
    </div>

    @foreach($activities as $act)

    @php
        $regs = \App\Models\Registration::where('activity_id', $act->id)
                    ->with('user')->get();

        $count = $regs->count();
    @endphp

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow hover:shadow-xl transition mb-10 overflow-hidden">

        <!-- HEADER -->
        <div class="p-6 border-b flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $act->title }}
                </h2>

                <!-- STATUS -->
                <div class="mt-2">
                    @if($act->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                            ⏳ Pending
                        </span>
                    @elseif($act->status == 'approved')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                            ✅ Approved
                        </span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                            ❌ Rejected
                        </span>
                    @endif
                </div>

                <!-- MEMBER COUNT -->
                <p class="text-sm text-gray-500 mt-2">
                    👥 <span class="font-semibold text-orange-600">{{ $count }}</span> Members Joined
                </p>
            </div>

            <!-- BUTTON -->
            <div class="flex gap-2">
                <a href="/activities/{{ $act->id }}"
                    class="bg-orange-600 text-white px-4 py-2 rounded-xl hover:bg-orange-500 transition">
                    View
                </a>

                <a href="/activities/{{ $act->id }}/edit"
                    class="border border-orange-600 text-orange-600 px-4 py-2 rounded-xl hover:bg-orange-600 hover:text-white transition">
                    Edit
                </a>
            </div>
        </div>

        <!-- TABLE -->
        <div class="p-6">

            @if($regs->isEmpty())
                <div class="text-center py-6 text-gray-400">
                    ยังไม่มีผู้สมัคร
                </div>
            @else

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="text-left border-b text-gray-600">
                            <th class="py-3">Name</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($regs as $r)
                        <tr class="border-b hover:bg-orange-50 transition">

                            <td class="py-3 font-medium text-gray-800">
                                {{ $r->user->name }}
                            </td>

                            <td>
                                <span class="
                                    {{ $r->status == 'approved' ? 'text-green-600' : '' }}
                                    {{ $r->status == 'rejected' ? 'text-red-600' : '' }}
                                    {{ $r->status == 'pending' ? 'text-yellow-600' : '' }}
                                ">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>

                            <td class="text-right">
                                @if($r->status == 'pending')

                                    <form method="POST" action="/registrations/{{ $r->id }}/approve" class="inline">
                                        @csrf
                                        <button class="text-green-600 font-semibold hover:underline">
                                            Approve
                                        </button>
                                    </form>

                                    <span class="mx-1 text-gray-300">|</span>

                                    <form method="POST" action="/registrations/{{ $r->id }}/reject" class="inline">
                                        @csrf
                                        <button class="text-red-600 font-semibold hover:underline">
                                            Reject
                                        </button>
                                    </form>

                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            @endif

        </div>

    </div>

    @endforeach

</div>
</x-app-layout>