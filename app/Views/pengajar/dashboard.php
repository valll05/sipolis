<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('sidebar') ?>
<a href="<?= base_url('/') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-home w-5"></i>
    <span>Beranda</span>
</a>
<a href="<?= base_url('pengajar/dashboard') ?>" class="sidebar-link <?= uri_string() == 'pengajar/dashboard' ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span>Dashboard</span>
</a>
<a href="<?= base_url('pengajar/jadwal') ?>" class="sidebar-link <?= uri_string() == 'pengajar/jadwal' ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Jadwal Saya</span>
</a>
<a href="<?= base_url('profile') ?>" class="sidebar-link <?= uri_string() == 'profile' ? 'active' : '' ?> flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-cog w-5"></i>
    <span>Pengaturan</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Jadwal</p>
                <p class="text-3xl font-bold text-gray-800"><?= $total_jadwal ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Sudah Selesai</p>
                <p class="text-3xl font-bold text-gray-800"><?= $jadwal_selesai ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Schedule -->
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h3 class="font-semibold text-gray-800">Jadwal Mengajar Anda</h3>
    </div>
    <div class="p-6">
        <?php if (empty($jadwals)): ?>
        <p class="text-gray-500 text-center py-8">Belum ada jadwal mengajar</p>
        <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($jadwals as $jadwal): ?>
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-primary rounded-lg flex flex-col items-center justify-center text-white">
                        <span class="text-xs"><?= date('M', strtotime($jadwal['tanggal'])) ?></span>
                        <span class="font-bold text-lg"><?= date('d', strtotime($jadwal['tanggal'])) ?></span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800"><?= $jadwal['topik'] ?></p>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i> <?= $jadwal['waktu'] ?>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-3 py-1 text-sm rounded-full <?= $jadwal['status'] == 'selesai' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' ?>">
                        <?= ucfirst($jadwal['status']) ?>
                    </span>
                    <?php if ($jadwal['status'] == 'belum'): ?>
                    <form action="<?= base_url('pengajar/jadwal/status/' . $jadwal['id']) ?>" method="POST" class="inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="selesai">
                        <button type="submit" class="bg-accent hover:bg-accent-hover text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-check mr-1"></i> Tandai Selesai
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
