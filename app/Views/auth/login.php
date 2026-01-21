<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gradient-to-br from-primary-dark via-primary to-primary-light flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4">
                <img src="<?= base_url('logo-bps.png') ?>" alt="Logo BPS" class="h-14 w-14">
            </div>
            <h1 class="text-2xl font-bold text-white">SIPOLIS</h1>
            <p class="text-white/70">BPS Kota Pekanbaru</p>
        </div>
        
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Masuk ke Akun</h2>
            
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <form action="<?= base_url('auth/login') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="mb-4">
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
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="loginPassword"
                               class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                               placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword('loginPassword', this)" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" 
                        class="w-full bg-accent hover:bg-accent-hover text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-[1.02]">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Belum punya akun? 
                    <a href="<?= base_url('auth/register') ?>" class="text-accent hover:underline font-medium">Daftar di sini</a>
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
