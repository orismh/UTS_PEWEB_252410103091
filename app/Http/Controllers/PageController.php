<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function login()
    {
        return view('login', [
            'title' => 'Login',
            'username' => 'Tamu',
            'features' => [
                ['title' => 'Dashboard', 'description' => 'Lihat ringkasan tugas dan progres tim.'],
                ['title' => 'Pengelolaan', 'description' => 'Kelola proyek dan anggota tim.'],
                ['title' => 'Profile', 'description' => 'Lihat data pengguna dan aktivitas.'],
            ],
        ]);
    }

    public function dashboard(Request $request)
    {
        $username = $request->query('username', 'Tamu');

        $stats = [
            ['label' => 'Total Tugas', 'value' => '12'],
            ['label' => 'Selesai', 'value' => '8'],
            ['label' => 'Berlangsung', 'value' => '4'],
            ['label' => 'Rata-rata Progres', 'value' => '82%'],
        ];

        $projects = [];

        return view('dashboard', compact('username', 'stats', 'projects') + ['title' => 'Dashboard']);
    }

    public function pengelolaan(Request $request)
    {
        $username = $request->query('username', 'Tamu');

        $modules = [];

        $projects = [];

        return view('pengelolaan', compact('username', 'modules', 'projects') + ['title' => 'Pengelolaan Tim']);
    }

    public function profile(Request $request)
    {
        $username = $request->query('username', 'Tamu');

        $profile = [
            'name' => 'Oris',
            'program' => 'Informatika',
            'semester' => 'Semester 3',
            'focus' => 'Jack Of All Trade',
            'email' => 'orismaulana@gmail.com',
        ];

        $skills = ['Laravel', 'Blade', 'PHP', 'Database', 'Git'];

        $activities = [
            ['label' => 'Menyelesaikan tugas ERD', 'time' => 'Hari ini'],
            ['label' => 'Mengulas komponen Navbar', 'time' => 'Kemarin'],
            ['label' => 'Membuat diagram arsitektur MVC', 'time' => '2 hari lalu'],
        ];

        return view('profile', compact('username', 'profile', 'skills', 'activities') + ['title' => 'Profile']);
    }
}
