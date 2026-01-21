<?php

namespace App\Models;

use CodeIgniter\Model;

class BookmarkModel extends Model
{
    protected $table            = 'bookmarks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'modul_id'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all bookmarks for a user with modul details
     */
    public function getUserBookmarks($userId)
    {
        return $this->select('bookmarks.*, moduls.*')
                    ->join('moduls', 'moduls.id = bookmarks.modul_id')
                    ->where('bookmarks.user_id', $userId)
                    ->orderBy('bookmarks.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Check if a modul is bookmarked by user
     */
    public function isBookmarked($userId, $modulId)
    {
        return $this->where('user_id', $userId)
                    ->where('modul_id', $modulId)
                    ->first() !== null;
    }

    /**
     * Toggle bookmark
     */
    public function toggleBookmark($userId, $modulId)
    {
        $existing = $this->where('user_id', $userId)
                         ->where('modul_id', $modulId)
                         ->first();
        
        if ($existing) {
            $this->delete($existing['id']);
            return false; // Removed
        }
        
        $this->insert([
            'user_id'  => $userId,
            'modul_id' => $modulId,
        ]);
        return true; // Added
    }

    /**
     * Get bookmark IDs for a user (for quick lookup)
     */
    public function getUserBookmarkIds($userId)
    {
        $bookmarks = $this->where('user_id', $userId)->findAll();
        return array_column($bookmarks, 'modul_id');
    }
}
