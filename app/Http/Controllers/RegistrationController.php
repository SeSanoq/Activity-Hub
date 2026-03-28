<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    // สมัครกิจกรรม (User) - ปรับปรุงใหม่
    public function register(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $userId = Auth::id();

        // 1. กันสมัครซ้ำ (ดึงมาจากของเดิม)
        $exists = Registration::where('user_id', $userId)
            ->where('activity_id', $id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'คุณสมัครกิจกรรมนี้แล้ว');
        }

        // 2. นับจำนวนคนที่ได้รับการ "Approved" แล้วในกิจกรรมนี้
        $currentCount = Registration::where('activity_id', $id)
            ->where('status', 'approved')
            ->count();

        // 3. เช็คว่าเต็มหรือยัง 
        if ($activity->max_participants > 0 && $currentCount >= $activity->max_participants) {
            // กรณีเต็ม: ตั้งสถานะเป็น 'pending' เพื่อให้ Staff พิจารณาเป็นกรณีพิเศษ
            $status = 'pending'; 
            $message = 'ขณะนี้กิจกรรมเต็มแล้ว คำขอของคุณถูกส่งไปยัง Staff เพื่อพิจารณาเป็นกรณีพิเศษ';
        } else {
            // กรณีไม่เต็ม: อนุมัติทันที 
            $status = 'approved'; 
            $message = 'คุณสมัครเข้าร่วมกิจกรรมสำเร็จ!';
        }

        // 4. บันทึกลงตาราง registrations
        Registration::create([
            'user_id' => $userId,
            'activity_id' => $activity->id,
            'status' => $status
        ]);

        return back()->with('success', $message);
    }

    // หน้ากิจกรรมของฉัน (User)
    public function myActivities()
    {
  
        $registrations = Registration::with('activity')
            ->where('user_id', Auth::id())
            ->get();

        return view('my-activities', compact('registrations'));
    }

    // --- ส่วนของ Admin / Staff ---

    // แสดงรายการสมัครทั้งหมด
    public function adminIndex()
    {
        $registrations = Registration::with(['user', 'activity'])->latest()->get();
        return view('admin.registrations', compact('registrations'));
    }

    // อนุมัติการสมัคร
    public function approve($id)
    {
        $reg = Registration::findOrFail($id);
        $reg->update(['status' => 'approved']);
        
        return back()->with('success', 'อนุมัติเรียบร้อยแล้ว');
    }

    // ปฏิเสธการสมัคร
    public function reject($id)
    {
        $reg = Registration::findOrFail($id);
        $reg->update(['status' => 'rejected']);
        
        return back()->with('success', 'ปฏิเสธการสมัครเรียบร้อยแล้ว');
    }
}