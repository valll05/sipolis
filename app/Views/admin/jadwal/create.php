<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('sidebar') ?>
<a href="<?= base_url('admin/dashboard') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span>Dashboard</span>
</a>
<a href="<?= base_url('admin/modul') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-book w-5"></i>
    <span>Kelola Modul</span>
</a>
<a href="<?= base_url('admin/user') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-users w-5"></i>
    <span>Kelola User</span>
</a>
<a href="<?= base_url('admin/user/pengajar') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-chalkboard-teacher w-5"></i>
    <span>Kelola Pengajar</span>
</a>
<a href="<?= base_url('admin/jadwal') ?>" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Kelola Jadwal</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Tambah Jadwal Baru</h2>
        
        <form action="<?= base_url('admin/jadwal/store') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Pengajar</label>
                <select name="pengajar_id" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                    <option value="">Pilih Pengajar</option>
                    <?php foreach ($pengajar as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= old('pengajar_id') == $p['id'] ? 'selected' : '' ?>><?= $p['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="<?= old('tanggal') ?>" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Waktu</label>
                    <input type="time" name="waktu" value="<?= old('waktu') ?>" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Topik</label>
                <input type="text" name="topik" value="<?= old('topik') ?>" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                       placeholder="Topik pembelajaran" required>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="bg-accent hover:bg-accent-hover text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Jadwal
                </button>
                <a href="<?= base_url('admin/jadwal') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
