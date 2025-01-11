<?php
namespace App\Imports;

use App\Models\Activity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ActivityImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $existingActivity = Activity::where('username', $row['username'])->orWhere('email', $row['email'])->first();
            if ($existingActivity) {
                Log::warning('تم العثور على إدخال مكرر لاسم المستخدم: ' . $row['username'] . ' أو البريد الإلكتروني: ' . $row['email']);
                return null; 
            }

            if (empty($row['name']) || empty($row['username']) || empty($row['email'])) {
                Log::warning('تخطي الصف بسبب حقل فارغ: ' . json_encode($row));
                return null;
            }

            return new Activity([
                'name'     => $row['name'],
                'username' => $row['username'],
                'email'    => $row['email'],
                'password' => Hash::make($row['username']),
            ]);
        } catch (\Exception $e) {
            Log::error('خطأ أثناء استيراد الصف: ' . json_encode($row) . ' - ' . $e->getMessage());
            return null;
        }
    }
}
