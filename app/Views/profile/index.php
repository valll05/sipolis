<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('sidebar') ?>
<?php 
$role = session()->get('role');
$baseUrl = $role === 'admin' ? 'admin' : ($role === 'pengajar' ? 'pengajar' : 'user');
?>
<a href="<?= base_url('/') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-home w-5"></i>
    <span>Beranda</span>
</a>
<a href="<?= base_url($baseUrl . '/dashboard') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span>Dashboard</span>
</a>
<?php if ($role === 'user'): ?>
<a href="<?= base_url('user/modul') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-book w-5"></i>
    <span>Modul Literasi</span>
</a>
<a href="<?= base_url('user/presensi') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Kalender Aktivitas</span>
</a>
<?php elseif ($role === 'pengajar'): ?>
<a href="<?= base_url('pengajar/jadwal') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Jadwal Saya</span>
</a>
<?php elseif ($role === 'admin'): ?>
<a href="<?= base_url('admin/modul') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-book w-5"></i>
    <span>Kelola Modul</span>
</a>
<a href="<?= base_url('admin/user') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-users w-5"></i>
    <span>Kelola User</span>
</a>
<a href="<?= base_url('admin/jadwal') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Kelola Jadwal</span>
</a>
<?php endif; ?>
<a href="<?= base_url('profile') ?>" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-cog w-5"></i>
    <span>Pengaturan</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="max-w-3xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Pengaturan Profil</h2>
        <p class="text-gray-500 dark:text-gray-400">Kelola informasi akun dan keamanan Anda</p>
    </div>
    
    <!-- Profile Info Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 mb-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-accent to-primary rounded-full flex items-center justify-center text-white text-3xl font-bold">
                <?= strtoupper(substr($user['nama'], 0, 1)) ?>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white"><?= $user['nama'] ?></h3>
                <p class="text-gray-500 dark:text-gray-400"><?= $user['email'] ?></p>
                <span class="inline-block mt-1 px-3 py-1 text-xs font-medium rounded-full bg-accent/10 text-accent capitalize">
                    <?= $user['role'] ?>
                </span>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Bergabung sejak</p>
                <p class="font-medium text-gray-800 dark:text-white"><?= date('d F Y', strtotime($user['created_at'])) ?></p>
            </div>
            <?php if ($user['role'] === 'user'): ?>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Program Studi</p>
                <p class="font-medium text-gray-800 dark:text-white"><?= $user['program_studi'] ?: '-' ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Edit Profile Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="fas fa-user-edit mr-2 text-accent"></i>Edit Profil
        </h3>
        
        <form action="<?= base_url('profile/update') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="<?= old('nama', $user['nama']) ?>" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email <span class="text-xs text-gray-400">(tidak dapat diubah)</span></label>
                    <input type="email" value="<?= $user['email'] ?>" readonly disabled
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                </div>
            </div>
            
            <?php if ($user['role'] === 'user'): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Program Studi</label>
                    <input type="text" name="program_studi" value="<?= old('program_studi', $user['program_studi']) ?>"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-accent focus:border-accent"
                           placeholder="Contoh: Statistika">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Universitas</label>
                    <input type="text" name="universitas" value="<?= old('universitas', $user['universitas']) ?>"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-accent focus:border-accent"
                           placeholder="Contoh: Universitas Riau">
                </div>
            </div>
            <?php endif; ?>
            
            <button type="submit" class="bg-accent hover:bg-accent-hover text-white px-6 py-3 rounded-lg font-medium transition">
                Simpan Perubahan
            </button>
        </form>
    </div>
    
    <!-- Change Password Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="fas fa-lock mr-2 text-accent"></i>Ubah Password
        </h3>
        
        <form action="<?= base_url('profile/password') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="space-y-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Saat Ini</label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current_password" required
                               class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-accent focus:border-accent"
                               placeholder="Masukkan password saat ini">
                        <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password" required minlength="6"
                                   class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-accent focus:border-accent"
                                   placeholder="Minimal 6 karakter">
                            <button type="button" onclick="togglePassword('new_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" name="confirm_password" id="confirm_password" required
                                   class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-accent focus:border-accent"
                                   placeholder="Ulangi password baru">
                            <button type="button" onclick="togglePassword('confirm_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-medium transition">
                Ubah Password
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
<?= $this->endSection() ?>
