<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('sidebar') ?>
<a href="<?= base_url('admin/dashboard') ?>" class="sidebar-link <?= uri_string() == 'admin/dashboard' ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span>Dashboard</span>
</a>
<a href="<?= base_url('admin/modul') ?>" class="sidebar-link <?= strpos(uri_string(), 'admin/modul') === 0 ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-book w-5"></i>
    <span>Kelola Modul</span>
</a>
<a href="<?= base_url('admin/user') ?>" class="sidebar-link <?= uri_string() == 'admin/user' ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-users w-5"></i>
    <span>Kelola User</span>
</a>
<a href="<?= base_url('admin/user/pengajar') ?>" class="sidebar-link <?= strpos(uri_string(), 'admin/user/pengajar') === 0 ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-chalkboard-teacher w-5"></i>
    <span>Kelola Pengajar</span>
</a>
<a href="<?= base_url('admin/jadwal') ?>" class="sidebar-link <?= strpos(uri_string(), 'admin/jadwal') === 0 ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Kelola Jadwal</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total User</p>
                <p class="text-3xl font-bold text-gray-800"><?= $total_users ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Pengajar</p>
                <p class="text-3xl font-bold text-gray-800"><?= $total_pengajar ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-green-500 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Modul</p>
                <p class="text-3xl font-bold text-gray-800"><?= $total_modul ?></p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-book text-purple-500 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Jadwal</p>
                <p class="text-3xl font-bold text-gray-800"><?= $total_jadwal ?></p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar text-orange-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Data -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Users -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b">
            <h3 class="font-semibold text-gray-800">User Terbaru</h3>
        </div>
        <div class="p-6">
            <?php if (empty($recent_users)): ?>
            <p class="text-gray-500 text-center py-4">Belum ada user terdaftar</p>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($recent_users as $user): ?>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-medium">
                        <?= strtoupper(substr($user['nama'], 0, 1)) ?>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800"><?= $user['nama'] ?></p>
                        <p class="text-sm text-gray-500"><?= $user['universitas'] ?></p>
                    </div>
                    <span class="text-xs text-gray-400"><?= date('d M', strtotime($user['created_at'])) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Upcoming Schedule -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b">
            <h3 class="font-semibold text-gray-800">Jadwal Bulan Ini</h3>
        </div>
        <div class="p-6">
            <?php if (empty($upcoming_jadwal)): ?>
            <p class="text-gray-500 text-center py-4">Belum ada jadwal</p>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach (array_slice($upcoming_jadwal, 0, 5) as $jadwal): ?>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex flex-col items-center justify-center">
                        <span class="text-xs text-gray-500"><?= date('M', strtotime($jadwal['tanggal'])) ?></span>
                        <span class="font-bold text-gray-800"><?= date('d', strtotime($jadwal['tanggal'])) ?></span>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800"><?= $jadwal['topik'] ?></p>
                        <p class="text-sm text-gray-500"><?= $jadwal['pengajar_nama'] ?> • <?= $jadwal['waktu'] ?></p>
                    </div>
                    <span class="px-3 py-1 text-xs rounded-full <?= $jadwal['status'] == 'selesai' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' ?>">
                        <?= ucfirst($jadwal['status']) ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
