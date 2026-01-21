<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('sidebar') ?>
<a href="<?= base_url('/') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-home w-5"></i>
    <span>Beranda</span>
</a>
<a href="<?= base_url('user/dashboard') ?>" class="sidebar-link <?= uri_string() == 'user/dashboard' ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span>Dashboard</span>
</a>
<a href="<?= base_url('user/modul') ?>" class="sidebar-link <?= uri_string() == 'user/modul' ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-book w-5"></i>
    <span>Modul Literasi</span>
</a>
<a href="<?= base_url('user/presensi') ?>" class="sidebar-link <?= uri_string() == 'user/presensi' ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Kalender Aktivitas</span>
</a>
<a href="<?= base_url('profile') ?>" class="sidebar-link <?= uri_string() == 'profile' ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-cog w-5"></i>
    <span>Pengaturan</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<!-- Welcome Card -->
<div class="bg-gradient-to-r from-primary-dark to-primary rounded-xl shadow-sm p-6 text-white mb-8">
    <h2 class="text-2xl font-bold mb-2">Selamat Datang, <?= session()->get('nama') ?>! 👋</h2>
    <p class="text-white/80">Tingkatkan literasi statistik Anda dengan modul-modul yang tersedia.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-book text-blue-500 text-xl"></i>
            </div>
            <span class="text-3xl font-bold text-gray-800"><?= $stats['total_modul'] ?></span>
        </div>
        <p class="text-gray-500 text-sm">Total Modul Tersedia</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-download text-green-500 text-xl"></i>
            </div>
            <span class="text-3xl font-bold text-gray-800"><?= $stats['downloaded'] ?></span>
        </div>
        <p class="text-gray-500 text-sm">Modul Diunduh</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-purple-500 text-xl"></i>
            </div>
            <span class="text-3xl font-bold text-gray-800"><?= $stats['completed'] ?></span>
        </div>
        <p class="text-gray-500 text-sm">Modul Selesai</p>
    </div>
</div>

<!-- Progress Bar -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-8">
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold text-gray-800">Progress Belajar</h3>
        <span class="text-accent font-bold"><?= $stats['progress_percent'] ?>%</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-3">
        <div class="bg-accent rounded-full h-3 transition-all duration-500" style="width: <?= $stats['progress_percent'] ?>%"></div>
    </div>
</div>

<!-- Recent Modules -->
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="font-semibold text-gray-800">Modul Terbaru</h3>
        <a href="<?= base_url('user/modul') ?>" class="text-accent hover:underline text-sm">Lihat Semua →</a>
    </div>
    <div class="p-6">
        <?php if (empty($recent_modul)): ?>
        <p class="text-gray-500 text-center py-4">Belum ada modul</p>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($recent_modul as $modul): ?>
            <div class="p-4 border rounded-lg hover:shadow-md transition">
                <div class="flex items-start justify-between mb-3">
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
                    <i class="fas fa-file-pdf text-red-500"></i>
                </div>
                <h4 class="font-medium text-gray-800 mb-2 line-clamp-2"><?= $modul['judul'] ?></h4>
                <p class="text-xs text-gray-500 mb-3"><?= $modul['ukuran_file'] ?></p>
                <a href="<?= base_url('user/modul/download/' . $modul['id']) ?>" 
                   class="flex items-center justify-center gap-2 w-full bg-accent hover:bg-accent-hover text-white py-2 rounded-lg text-sm transition">
                    <i class="fas fa-download"></i> Unduh
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
