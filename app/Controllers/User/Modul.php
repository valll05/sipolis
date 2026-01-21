<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ModulModel;
use App\Models\ProgressModel;
use App\Models\BookmarkModel;

class Modul extends BaseController
{
    protected $modulModel;
    protected $progressModel;
    protected $bookmarkModel;
    
    public function __construct()
    {
        $this->modulModel = new ModulModel();
        $this->progressModel = new ProgressModel();
        $this->bookmarkModel = new BookmarkModel();
    }
    
    public function index()
    {
        $kategori = $this->request->getGet('kategori');
        $search = $this->request->getGet('search');
        $filter = $this->request->getGet('filter'); // 'all' or 'bookmark'
        $userId = session()->get('user_id');
        
        // Build query
        $builder = $this->modulModel;
        
        // Search filter
        if ($search) {
            $builder = $builder->like('judul', $search)
                               ->orLike('deskripsi', $search);
        }
        
        // Category filter
        if ($kategori && $kategori !== 'all') {
            $builder = $builder->where('kategori', $kategori);
        }
        
        $moduls = $builder->findAll();
        
        // Get user progress for each modul
        $userProgress = $this->progressModel->getUserProgress($userId);
        $progressMap = [];
        foreach ($userProgress as $p) {
            $progressMap[$p['modul_id']] = $p;
        }
        
        // Get user bookmarks
        $bookmarkIds = $this->bookmarkModel->getUserBookmarkIds($userId);
        
        // Filter by bookmark if requested
        if ($filter === 'bookmark') {
            $moduls = array_filter($moduls, function($m) use ($bookmarkIds) {
                return in_array($m['id'], $bookmarkIds);
            });
        }
        
        $data = [
            'title'            => 'Modul Literasi',
            'moduls'           => $moduls,
            'kategori_counts'  => $this->modulModel->getKategoriCounts(),
            'current_kategori' => $kategori ?: 'all',
            'current_search'   => $search ?: '',
            'current_filter'   => $filter ?: 'all',
            'progress_map'     => $progressMap,
            'bookmark_ids'     => $bookmarkIds,
        ];
        
        return view('user/modul/index', $data);
    }
    
    public function download($id)
    {
        $modul = $this->modulModel->find($id);
        
        if (!$modul) {
            return redirect()->back()->with('error', 'Modul tidak ditemukan.');
        }
        
        $userId = session()->get('user_id');
        
        // Record progress
        $this->progressModel->markDownloaded($userId, $id);
        
        $filePath = ROOTPATH . 'public/uploads/modul/' . $modul['file_pdf'];
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
        
        return $this->response->download($filePath, null)->setFileName($modul['judul'] . '.pdf');
    }
    
    public function markComplete($id)
    {
        $userId = session()->get('user_id');
        
        if ($this->progressModel->markCompleted($userId, $id)) {
            return redirect()->back()->with('success', 'Modul ditandai selesai! 🎉');
        }
        
        return redirect()->back()->with('error', 'Terjadi kesalahan.');
    }
    
    /**
     * Toggle bookmark (AJAX)
     */
    public function toggleBookmark($id)
    {
        $userId = session()->get('user_id');
        $modul = $this->modulModel->find($id);
        
        if (!$modul) {
            return $this->response->setJSON(['success' => false, 'message' => 'Modul tidak ditemukan.']);
        }
        
        $isBookmarked = $this->bookmarkModel->toggleBookmark($userId, $id);
        
        return $this->response->setJSON([
            'success' => true,
            'bookmarked' => $isBookmarked,
            'message' => $isBookmarked ? 'Modul ditambahkan ke bookmark!' : 'Modul dihapus dari bookmark.'
        ]);
    }
}
