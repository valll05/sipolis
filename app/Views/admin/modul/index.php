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
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold text-gray-800">Daftar Modul</h2>
    <a href="<?= base_url('admin/modul/create') ?>" class="bg-accent hover:bg-accent-hover text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
        <i class="fas fa-plus"></i>
        Tambah Modul
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengajar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ukuran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (empty($moduls)): ?>
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada modul</td>
            </tr>
            <?php else: ?>
            <?php foreach ($moduls as $modul): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800"><?= $modul['judul'] ?></div>
                    <div class="text-sm text-gray-500 truncate max-w-xs"><?= $modul['deskripsi'] ?></div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 text-xs rounded-full 
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
                </td>
                <td class="px-6 py-4 text-gray-600"><?= $modul['pengajar_nama'] ?? '-' ?></td>
                <td class="px-6 py-4 text-gray-600"><?= $modul['ukuran_file'] ?></td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="<?= base_url('admin/modul/edit/' . $modul['id']) ?>" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="confirmDelete('<?= base_url('admin/modul/delete/' . $modul['id']) ?>', 'Yakin ingin menghapus modul ini?')" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
