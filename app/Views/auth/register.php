<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gradient-to-br from-primary-dark via-primary to-primary-light flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4">
                <img src="<?= base_url('logo-bps.png') ?>" alt="Logo BPS" class="h-14 w-14">
            </div>
            <h1 class="text-2xl font-bold text-white">SIPOLIS</h1>
            <p class="text-white/70">BPS Kota Pekanbaru</p>
        </div>
        
        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Daftar Akun Baru</h2>
            
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <form action="<?= base_url('auth/register') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="space-y-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="nama" value="<?= old('nama') ?>" 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="Nama lengkap" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="<?= old('email') ?>" 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="email@example.com" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Program Studi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-graduation-cap"></i>
                            </span>
                            <input type="text" name="program_studi" value="<?= old('program_studi') ?>" 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="Contoh: Statistika" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Asal Universitas</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-university"></i>
                            </span>
                            <input type="text" name="universitas" value="<?= old('universitas') ?>" 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="Contoh: Universitas Riau" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="regPassword"
                                   class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="Minimal 6 karakter" required>
                            <button type="button" onclick="togglePassword('regPassword', this)" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="confirm_password" id="regConfirmPassword"
                                   class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="Ulangi password" required>
                            <button type="button" onclick="togglePassword('regConfirmPassword', this)" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <button type="submit" 
                        class="w-full bg-accent hover:bg-accent-hover text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-[1.02]">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Sudah punya akun? 
                    <a href="<?= base_url('auth/login') ?>" class="text-accent hover:underline font-medium">Masuk di sini</a>
                </p>
            </div>
        </div>
        
        <p class="text-center text-white/50 text-sm mt-6">
            &copy; <?= date('Y') ?> BPS Kota Pekanbaru
        </p>
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
