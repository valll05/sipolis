<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('sidebar') ?>
<a href="<?= base_url('/') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-home w-5"></i>
    <span>Beranda</span>
</a>
<a href="<?= base_url('user/dashboard') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span>Dashboard</span>
</a>
<a href="<?= base_url('user/modul') ?>" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-book w-5"></i>
    <span>Modul Literasi</span>
</a>
<a href="<?= base_url('user/presensi') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Kalender Aktivitas</span>
</a>
<a href="<?= base_url('profile') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-cog w-5"></i>
    <span>Pengaturan</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<!-- Header with Title -->
<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Modul Literasi Statistik</h2>
    
    <!-- Search & Filters - All in one row -->
    <div class="flex items-center gap-2">
        <!-- Search Input -->
        <div class="relative flex-1 min-w-0">
            <input type="text" id="searchInput" value="<?= $current_search ?? '' ?>" 
                   placeholder="Cari modul..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-accent focus:border-accent"
                   onkeyup="if(event.key==='Enter') applyFilters()">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        
        <!-- Category Filter -->
        <select id="kategoriFilter" onchange="applyFilters()" 
                class="px-2 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-accent focus:border-accent cursor-pointer flex-shrink-0 text-sm">
            <option value="all" <?= ($current_kategori ?? 'all') == 'all' ? 'selected' : '' ?>>Semua Kategori</option>
            <option value="sosial" <?= ($current_kategori ?? '') == 'sosial' ? 'selected' : '' ?>>Statistik Sosial</option>
            <option value="produksi" <?= ($current_kategori ?? '') == 'produksi' ? 'selected' : '' ?>>Statistik Produksi</option>
            <option value="distribusi" <?= ($current_kategori ?? '') == 'distribusi' ? 'selected' : '' ?>>Statistik Distribusi</option>
            <option value="neraca" <?= ($current_kategori ?? '') == 'neraca' ? 'selected' : '' ?>>Neraca & Analisis</option>
        </select>
        
        <!-- Bookmark Toggle Button -->
        <input type="hidden" id="filterType" value="<?= ($current_filter ?? 'all') ?>">
        <button onclick="toggleBookmarkFilter()" 
                class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 transition <?= ($current_filter ?? '') == 'bookmark' ? 'bg-yellow-400 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-300 hover:bg-yellow-400 hover:text-white' ?>"
                title="<?= ($current_filter ?? '') == 'bookmark' ? 'Lihat Semua Modul' : 'Lihat Bookmark Saja' ?>">
            <i class="fas fa-star text-lg"></i>
        </button>
    </div>
</div>

<!-- Modules Grid -->
<?php if (empty($moduls)): ?>
<div class="bg-white rounded-xl shadow-sm p-12 text-center">
    <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
    <p class="text-gray-500">
        <?php if (($current_filter ?? '') === 'bookmark'): ?>
            Belum ada modul yang di-bookmark
        <?php elseif (!empty($current_search)): ?>
            Tidak ditemukan modul dengan kata kunci "<?= esc($current_search) ?>"
        <?php else: ?>
            Belum ada modul dalam kategori ini
        <?php endif; ?>
    </p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($moduls as $modul): ?>
    <?php 
        $progress = isset($progress_map[$modul['id']]) ? $progress_map[$modul['id']] : null;
        $isDownloaded = $progress && $progress['is_downloaded'];
        $isCompleted = $progress && $progress['is_completed'];
        $isBookmarked = in_array($modul['id'], $bookmark_ids ?? []);
    ?>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition group <?= $isCompleted ? 'ring-2 ring-green-500' : '' ?>">
        <div class="h-32 bg-gradient-to-br 
            <?php 
            switch($modul['kategori']) {
                case 'sosial': echo 'from-blue-400 to-blue-600'; break;
                case 'produksi': echo 'from-orange-400 to-orange-600'; break;
                case 'distribusi': echo 'from-green-400 to-green-600'; break;
                case 'neraca': echo 'from-purple-400 to-purple-600'; break;
            }
            ?> flex items-center justify-center relative">
            <i class="fas fa-file-pdf text-6xl text-white/30"></i>
            
            <!-- Bookmark Button -->
            <button onclick="toggleBookmark(<?= $modul['id'] ?>, this)" 
                    class="absolute top-2 left-2 w-8 h-8 rounded-full flex items-center justify-center transition
                           <?= $isBookmarked ? 'bg-yellow-400 text-white' : 'bg-white/20 text-white/70 hover:bg-white/40' ?>">
                <i class="fas fa-bookmark"></i>
            </button>
            
            <!-- Status Badge -->
            <?php if ($isCompleted): ?>
            <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                <i class="fas fa-check mr-1"></i>Selesai
            </div>
            <?php elseif ($isDownloaded): ?>
            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                <i class="fas fa-download mr-1"></i>Diunduh
            </div>
            <?php endif; ?>
        </div>
        <div class="p-5">
            <span class="px-2 py-1 text-xs rounded-full 
                <?php 
                switch($modul['kategori']) {
                    case 'sosial': echo 'bg-blue-100 text-blue-600'; break;
                    case 'produksi': echo 'bg-orange-100 text-orange-600'; break;
                    case 'distribusi': echo 'bg-green-100 text-green-600'; break;
                    case 'neraca': echo 'bg-purple-100 text-purple-600'; break;
                }
                ?>">
                <?= ucfirst($modul['kategori']) ?>
            </span>
            <h3 class="font-semibold text-gray-800 mt-3 mb-2 group-hover:text-accent transition"><?= $modul['judul'] ?></h3>
            <p class="text-sm text-gray-500 mb-4 line-clamp-2"><?= $modul['deskripsi'] ?></p>
            
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-400">
                    <i class="fas fa-file mr-1"></i><?= $modul['ukuran_file'] ?>
                </span>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-2">
                <a href="<?= base_url('user/modul/download/' . $modul['id']) ?>" 
                   class="flex-1 flex items-center justify-center gap-2 bg-accent hover:bg-accent-hover text-white px-3 py-2 rounded-lg text-sm transition">
                    <i class="fas fa-download"></i> Unduh
                </a>
                
                <?php if ($isDownloaded && !$isCompleted): ?>
                <form action="<?= base_url('user/modul/complete/' . $modul['id']) ?>" method="POST" class="flex-1">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm transition">
                        <i class="fas fa-check"></i> Selesai
                    </button>
                </form>
                <?php elseif ($isCompleted): ?>
                <span class="flex-1 flex items-center justify-center gap-2 bg-gray-200 text-gray-500 px-3 py-2 rounded-lg text-sm">
                    <i class="fas fa-check-circle"></i> Tuntas
                </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<script>
// Apply filters
function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const kategori = document.getElementById('kategoriFilter').value;
    const filter = document.getElementById('filterType').value;
    
    let url = '<?= base_url('user/modul') ?>?';
    const params = [];
    
    if (search) params.push('search=' + encodeURIComponent(search));
    if (kategori !== 'all') params.push('kategori=' + kategori);
    if (filter !== 'all') params.push('filter=' + filter);
    
    window.location.href = url + params.join('&');
}

// Toggle bookmark filter
function toggleBookmarkFilter() {
    const filterInput = document.getElementById('filterType');
    filterInput.value = filterInput.value === 'bookmark' ? 'all' : 'bookmark';
    applyFilters();
}

// Toggle bookmark via AJAX
function toggleBookmark(modulId, btn) {
    fetch('<?= base_url('user/modul/bookmark/') ?>' + modulId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.bookmarked) {
                btn.classList.remove('bg-white/20', 'text-white/70', 'hover:bg-white/40');
                btn.classList.add('bg-yellow-400', 'text-white');
            } else {
                btn.classList.remove('bg-yellow-400', 'text-white');
                btn.classList.add('bg-white/20', 'text-white/70', 'hover:bg-white/40');
            }
        }
    })
    .catch(err => console.error(err));
}
</script>
<?= $this->endSection() ?>
