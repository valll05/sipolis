<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('sidebar') ?>
<a href="<?= base_url('admin/dashboard') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span>Dashboard</span>
</a>
<a href="<?= base_url('admin/modul') ?>" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
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
<a href="<?= base_url('admin/jadwal') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Kelola Jadwal</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Edit Modul</h2>
        
        <form action="<?= base_url('admin/modul/update/' . $modul['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Judul Modul</label>
                <input type="text" name="judul" value="<?= old('judul', $modul['judul']) ?>" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                       placeholder="Masukkan judul modul" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                          placeholder="Deskripsi singkat modul"><?= old('deskripsi', $modul['deskripsi']) ?></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Kategori</label>
                    <select name="kategori" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                        <option value="sosial" <?= $modul['kategori'] == 'sosial' ? 'selected' : '' ?>>Statistik Sosial</option>
                        <option value="produksi" <?= $modul['kategori'] == 'produksi' ? 'selected' : '' ?>>Statistik Produksi</option>
                        <option value="distribusi" <?= $modul['kategori'] == 'distribusi' ? 'selected' : '' ?>>Statistik Distribusi</option>
                        <option value="neraca" <?= $modul['kategori'] == 'neraca' ? 'selected' : '' ?>>Neraca & Analisis</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Pengajar (Opsional)</label>
                    <select name="pengajar_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Tidak Ada</option>
                        <?php foreach ($pengajar as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $modul['pengajar_id'] == $p['id'] ? 'selected' : '' ?>><?= $p['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">File PDF Baru (Opsional)</label>
                <input type="file" name="file_pdf" accept=".pdf"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                <p class="text-sm text-gray-500 mt-1">File saat ini: <?= $modul['file_pdf'] ?> (<?= $modul['ukuran_file'] ?>)</p>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="bg-accent hover:bg-accent-hover text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-save mr-2"></i>
                    Update Modul
                </button>
                <a href="<?= base_url('admin/modul') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
