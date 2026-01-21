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
<a href="<?= base_url('admin/user') ?>" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
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
    <h2 class="text-lg font-semibold text-gray-800">Daftar User Terdaftar</h2>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program Studi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Universitas</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (empty($users)): ?>
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada user terdaftar</td>
            </tr>
            <?php else: ?>
            <?php foreach ($users as $user): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-medium mr-3">
                            <?= strtoupper(substr($user['nama'], 0, 1)) ?>
                        </div>
                        <span class="font-medium text-gray-800"><?= $user['nama'] ?></span>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600"><?= $user['email'] ?></td>
                <td class="px-6 py-4 text-gray-600"><?= $user['program_studi'] ?? '-' ?></td>
                <td class="px-6 py-4 text-gray-600"><?= $user['universitas'] ?? '-' ?></td>
                <td class="px-6 py-4 text-gray-500 text-sm"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                <td class="px-6 py-4">
                    <button onclick="confirmDelete('<?= base_url('admin/user/delete/' . $user['id']) ?>', 'Yakin ingin menghapus user ini?')" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
