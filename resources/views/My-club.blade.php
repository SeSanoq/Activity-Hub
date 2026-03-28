<x-app-layout>
    <div style="max-width: 1000px; margin: 30px auto; font-family: sans-serif;">
        <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 20px;">คลับของฉัน (My Club Activities)</h1>

        @foreach($activities as $act)
        <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 25px; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: start; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <div>
                    <h3 style="font-size: 20px; font-weight: bold; color: #1f2937; margin: 0;">{{ $act->title }}</h3>
                    <div style="margin-top: 5px;">
                        @if($act->status == 'pending')
                            <span style="background: #fef3c7; color: #92400e; padding: 3px 10px; border-radius: 50px; font-size: 12px;">⏳ รออนุมัติกิจกรรม</span>
                        @elseif($act->status == 'approved')
                            <span style="background: #d1fae5; color: #065f46; padding: 3px 10px; border-radius: 50px; font-size: 12px;">✅ อนุมัติแล้ว</span>
                        @else
                            <span style="background: #fee2e2; color: #991b1b; padding: 3px 10px; border-radius: 50px; font-size: 12px;">❌ ถูกปฏิเสธ</span>
                        @endif
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="/activities/{{ $act->id }}" style="background: #3b82f6; color: white; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-size: 14px;">View Detail</a>
                    
                    <a href="/activities/{{ $act->id }}/edit" style="background: #10b981; color: white; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-size: 14px;">Edit</a>
                </div>
            </div>

            <div style="margin-top: 15px;">
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">รายชื่อผู้สมัครเข้าร่วม:</h4>
                @php
                    $regs = \App\Models\Registration::where('activity_id', $act->id)->with('user')->get();
                @endphp

                @if($regs->isEmpty())
                    <p style="color: #9ca3af; font-size: 14px;">ยังไม่มีผู้สมัคร</p>
                @else
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <thead>
                            <tr style="background: #f9fafb; text-align: left;">
                                <th style="padding: 10px; border-bottom: 1px solid #eee;">ชื่อ</th>
                                <th style="padding: 10px; border-bottom: 1px solid #eee;">สถานะ</th>
                                <th style="padding: 10px; border-bottom: 1px solid #eee;">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($regs as $r)
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $r->user->name }}</td>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;">
                                    <span style="color: {{ $r->status == 'approved' ? 'green' : ($r->status == 'rejected' ? 'red' : 'orange') }}">
                                        {{ $r->status }}
                                    </span>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;">
                                    @if($r->status == 'pending')
                                        <form method="POST" action="/registrations/{{ $r->id }}/approve" style="display:inline;">
                                            @csrf
                                            <button style="color: green; border: none; background: none; cursor: pointer; font-weight: bold;">Approve</button>
                                        </form>
                                        |
                                        <form method="POST" action="/registrations/{{ $r->id }}/reject" style="display:inline;">
                                            @csrf
                                            <button style="color: red; border: none; background: none; cursor: pointer; font-weight: bold;">Reject</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>