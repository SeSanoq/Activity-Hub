<x-app-layout>
    <div style="max-width: 800px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; shadow: 0 4px 6px rgba(0,0,0,0.1); font-family: sans-serif;">
        
        <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 15px;">{{ $activity->title }}</h1>

        <img src="{{ asset('storage/'.$activity->image) }}" style="width: 100%; max-width: 400px; border-radius: 8px; margin-bottom: 15px;">

        <div style="margin-bottom: 20px; line-height: 1.6;">
            <p><strong>รายละเอียด:</strong> {{ $activity->description }}</p>
            <p>📅 <strong>วันจัดกิจกรรม:</strong> {{ $activity->date }}</p>
            <p style="color: #ef4444; font-weight: bold;">
                ⏳ <strong>ปิดรับสมัคร:</strong> {{ $activity->registration_deadline }}
            </p>
            <p>📍 <strong>สถานที่:</strong> {{ $activity->location }}</p>
            
            @php
                // นับจำนวนคนที่สถานะเป็น approved ในกิจกรรมนี้
                $currentParticipants = \App\Models\Registration::where('activity_id', $activity->id)
                    ->where('status', 'approved')
                    ->count();
                $max = $activity->max_participants;
                $isFull = $max > 0 && $currentParticipants >= $max;
            @endphp
            <p>👥 <strong>จำนวนผู้เข้าร่วม:</strong> 
                <span style="color: {{ $isFull ? 'red' : 'green' }}; font-weight: bold;">
                    {{ $currentParticipants }} / {{ $max ?: 'ไม่จำกัด' }} คน
                </span>
            </p>
        </div>

        <div style="margin-bottom: 25px;">
            <strong>หมวดหมู่:</strong> 
            @forelse($activity->tags as $tag)
                <span style="background: #dbeafe; color: #1e40af; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 50px; margin-right: 5px; border: 1px solid #bfdbfe;">
                    #{{ $tag->name }}
                </span>
            @empty
                <span style="color: #9ca3af; font-size: 14px;">(ไม่มีหมวดหมู่)</span>
            @endforelse
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">

        @php
            $registration = \App\Models\Registration::where('user_id', auth()->id())
                ->where('activity_id', $activity->id)
                ->first();

            $today = \Carbon\Carbon::now()->startOfDay();
            $deadline = \Carbon\Carbon::parse($activity->registration_deadline)->startOfDay();
            $isClosed = $today->gt($deadline);
        @endphp

        <div style="display: flex; gap: 10px; align-items: center;">
            @if($isClosed && !$registration) 
                <button disabled style="background:#9ca3af; color:white; padding: 10px 20px; border: none; border-radius: 5px; cursor:not-allowed;">
                    ❌ ปิดรับสมัครแล้ว (เลยกำหนดการ)
                </button>
            @elseif($registration)
                @if($registration->status == 'pending')
                    <button disabled style="background:#fbbf24; color:white; padding: 10px 20px; border: none; border-radius: 5px;">⏳ รออนุมัติ</button>
                @elseif($registration->status == 'approved')
                    <button disabled style="background:#10b981; color:white; padding: 10px 20px; border: none; border-radius: 5px;">✅ สมัครเรียบร้อย</button>
                @elseif($registration->status == 'rejected')
                    <button disabled style="background:#ef4444; color:white; padding: 10px 20px; border: none; border-radius: 5px;">❌ ถูกปฏิเสธ</button>
                @endif
            @else
                {{-- กรณีวันยังไม่เลย และยังไม่ได้สมัคร --}}
                <form method="POST" action="/activities/{{ $activity->id }}/register">
                    @csrf
                    @if($isFull)
                        {{-- ถ้าคนเต็ม เปลี่ยนสีและข้อความปุ่ม --}}
                        <button type="submit" style="background:#f97316; color:white; padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                            ⚠️ ส่งคำขอเข้าร่วมกิจกรรมที่เต็มแล้ว
                        </button>
                    @else
                        <button type="submit" style="background:#2563eb; color:white; padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                            สมัครกิจกรรม
                        </button>
                    @endif
                </form>
            @endif

            @if(auth()->user()->role === 'admin')
                <form method="POST" action="/admin/activities/{{ $activity->id }}" onsubmit="return confirm('ยืนยันการลบ?')">
                    @csrf
                    @method('DELETE')
                    <button style="background:#dc2626; color:white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">ลบกิจกรรม (Admin)</button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>