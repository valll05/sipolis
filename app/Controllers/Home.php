<?php

namespace App\Controllers;

use App\Models\ModulModel;

class Home extends BaseController
{
    public function index()
    {
        // Hanya Admin yang redirect ke dashboard
        if (session()->get('logged_in')) {
            $role = session()->get('role');
            if ($role === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
            // User dan Pengajar tetap di halaman home (tidak redirect)
        }
        
        // Show public landing page (termasuk untuk user yang sudah login)
        $modulModel = new ModulModel();
        $data = [
            'title' => 'Beranda',
            'moduls' => $modulModel->orderBy('created_at', 'DESC')->limit(6)->findAll(),
            'total_modul' => $modulModel->countAll(),
            'bookmark_ids' => [],
        ];
        
        // Get bookmark IDs if user is logged in
        if (session()->get('logged_in') && session()->get('role') === 'user') {
            $bookmarkModel = new \App\Models\BookmarkModel();
            $bookmarks = $bookmarkModel->where('user_id', session()->get('user_id'))->findAll();
            $data['bookmark_ids'] = array_column($bookmarks, 'modul_id');
        }
        
        return view('home', $data);
    }
}
