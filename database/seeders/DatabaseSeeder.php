<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole   = Role::firstOrCreate(['name' => 'admin',   'guard_name' => 'web']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);

        // Create default admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@babyjesusfamily.com'],
            [
                'name'     => 'المسؤول الرئيسي',
                'phone'    => '01000000000',
                'password' => Hash::make('Admin@1234'),
                'status'   => 'active',
            ]
        );
        $admin->assignRole('admin');

        // Create sample teacher
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@babyjesusfamily.com'],
            [
                'name'     => 'معلم تجريبي',
                'phone'    => '01011111111',
                'password' => Hash::make('Teacher@1234'),
                'status'   => 'active',
            ]
        );
        $teacher->assignRole('teacher');

        // Create classes - proper Egyptian church grade levels
        $classNames = [
            'الصف الأول الابتدائي'   => 'المرحلة الابتدائية - الأول',
            'الصف الثاني الابتدائي'  => 'المرحلة الابتدائية - الثاني',
            'الصف الثالث الابتدائي'  => 'المرحلة الابتدائية - الثالث',
            'الصف الرابع الابتدائي'  => 'المرحلة الابتدائية - الرابع',
            'الصف الخامس الابتدائي'  => 'المرحلة الابتدائية - الخامس',
            'الصف السادس الابتدائي'  => 'المرحلة الابتدائية - السادس',
            'الصف الأول الإعدادي'    => 'المرحلة الإعدادية - الأول',
            'الصف الثاني الإعدادي'   => 'المرحلة الإعدادية - الثاني',
            'الصف الثالث الإعدادي'   => 'المرحلة الإعدادية - الثالث',
            'الصف الأول الثانوي'     => 'المرحلة الثانوية - الأول',
            'الصف الثاني الثانوي'    => 'المرحلة الثانوية - الثاني',
            'الصف الثالث الثانوي'    => 'المرحلة الثانوية - الثالث',
            'المرحلة الجامعية'       => 'طلاب الجامعات والمعاهد',
            'الخريجون'               => 'خريجو الجامعات والكبار',
            'الحضانة والروضة'        => 'أطفال ما قبل المدرسة',
        ];

        $classes = [];
        foreach ($classNames as $name => $description) {
            $classes[$name] = SchoolClass::firstOrCreate(
                ['name' => $name],
                ['description' => $description]
            );
        }

        // Assign teacher to first two classes
        $firstTwo = array_slice(array_values($classes), 0, 2);
        $teacher->classes()->syncWithoutDetaching(collect($firstTwo)->pluck('id')->toArray());

        // Create activities - comprehensive church activities
        $activityNames = [
            'الكورال'                    => 'فريق الترنيم والكورال الكنسي',
            'الكشافة'                    => 'نشاط الكشافة والمرشدات',
            'المسرح'                     => 'الفرقة المسرحية والتمثيل',
            'الرياضة'                    => 'النشاط الرياضي والألعاب',
            'دراسة الكتاب المقدس'        => 'مجموعة دراسة وحفظ الكتاب المقدس',
            'الرسم والفنون'              => 'نشاط الرسم والفنون التشكيلية',
            'الموسيقى'                   => 'تعليم العزف على الآلات الموسيقية',
            'الخدمة الاجتماعية'          => 'مجموعة الخدمة الاجتماعية والمجتمعية',
            'نادي القراءة'               => 'نادي القراءة والكتب الدينية',
            'التصوير والإعلام'           => 'فريق التصوير والإعلام الكنسي',
            'الأشغال اليدوية'            => 'نشاط الحرف اليدوية والأشغال',
            'الرياضة الروحية'            => 'الخلوات والرياضات الروحية',
            'فريق الخدمة'               => 'فريق خدمة القداس والطقوس',
            'لجنة الأعياد'              => 'تنظيم وإعداد الأعياد والمناسبات',
            'المخيمات الصيفية'           => 'برنامج المخيمات والرحلات الصيفية',
        ];

        foreach ($activityNames as $name => $description) {
            Activity::firstOrCreate(
                ['name' => $name],
                ['description' => $description]
            );
        }
    }
}
