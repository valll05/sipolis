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
<a href="<?= base_url('admin/user/pengajar') ?>" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-chalkboard-teacher w-5"></i>
    <span>Kelola Pengajar</span>
</a>
<a href="<?= base_url('admin/jadwal') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Kelola Jadwal</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Tambah Pengajar Baru</h2>
        
        <form action="<?= base_url('admin/user/pengajar/store') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= old('nama') ?>" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                       placeholder="Nama pengajar" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" value="<?= old('email') ?>" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                       placeholder="email@bps.go.id" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent pr-12"
                           placeholder="Minimal 6 karakter" required>
                    <button type="button" onclick="togglePassword('password', this)" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="bg-accent hover:bg-accent-hover text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengajar
                </button>
                <a href="<?= base_url('admin/user/pengajar') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

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
