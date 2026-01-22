<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="h-screen flex flex-col lg:flex-row overflow-hidden">
    <!-- Mobile Header -->
    <div class="lg:hidden bg-primary-dark text-white px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <img src="<?= base_url('logo-bps.png') ?>" alt="Logo BPS" class="h-8 w-8 object-contain">
            <span class="font-bold text-sm">SIPOLIS</span>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="toggleTheme()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                <i id="themeIconMobile" class="fas fa-moon text-white text-sm"></i>
            </button>
            <button onclick="toggleSidebar()" class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-64 bg-primary-dark text-white flex-shrink-0 flex flex-col h-screen z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <!-- Header (Desktop) -->
        <div class="p-6 flex-shrink-0 hidden lg:block">
            <div class="flex items-center space-x-3">
                <img src="<?= base_url('logo-bps.png') ?>" alt="Logo BPS" class="h-12 w-12 object-contain">
                <div>
                    <span class="font-bold text-lg block leading-tight">SIPOLIS</span>
                    <span class="text-xs text-white/70">BPS Kota Pekanbaru</span>
                </div>
            </div>
        </div>
        
        <!-- Close button (Mobile) -->
        <div class="p-4 flex justify-between items-center lg:hidden border-b border-white/10">
            <span class="font-bold">Menu</span>
            <button onclick="toggleSidebar()" class="text-white/70 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Navigation - Scrollable -->
        <nav class="flex-1 overflow-y-auto px-4 lg:px-6 py-4 space-y-2 scrollbar-thin">
            <?= $this->renderSection('sidebar') ?>
        </nav>
        
        <!-- User Info - Fixed at bottom -->
        <div class="flex-shrink-0 p-4 bg-primary-dark border-t border-white/10">
            <div class="flex items-center space-x-3">
                <a href="<?= base_url('profile') ?>" class="w-10 h-10 rounded-full flex-shrink-0 hover:ring-2 hover:ring-white/30 transition overflow-hidden" title="Pengaturan Profil">
                    <?php if (session()->get('foto')): ?>
                        <img src="<?= base_url('uploads/profile/' . session()->get('foto')) ?>" alt="Foto" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full bg-accent flex items-center justify-center text-white font-bold">
                            <?= strtoupper(substr(session()->get('nama'), 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </a>
                <a href="<?= base_url('profile') ?>" class="flex-1 min-w-0 hover:opacity-80 transition" title="Pengaturan Profil">
                    <p class="font-medium text-sm truncate"><?= session()->get('nama') ?></p>
                    <p class="text-xs text-white/70 capitalize"><?= session()->get('role') ?></p>
                </a>
                <a href="<?= base_url('auth/logout') ?>" class="text-white/70 hover:text-white" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden min-h-screen lg:min-h-0">
        <!-- Top Bar (Desktop) -->
        <header class="hidden lg:flex bg-white shadow-sm px-8 xl:px-12 2xl:px-16 py-4 items-center justify-between flex-shrink-0">
            <h1 class="text-xl font-bold text-gray-800"><?= $title ?? 'Dashboard' ?></h1>
            <div class="flex items-center space-x-4">
                <?php
                    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    $tanggal = $hari[date('w')] . ', ' . date('d') . ' ' . $bulan[date('n') - 1] . ' ' . date('Y');
                ?>
                <span class="text-sm text-gray-500 hidden xl:block"><?= $tanggal ?></span>
                <button onclick="toggleTheme()" class="theme-toggle w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition" title="Toggle Theme">
                    <i id="themeIcon" class="fas fa-moon text-gray-600"></i>
                </button>
            </div>
        </header>
        
        <!-- Page Content - Scrollable -->
        <div class="flex-1 overflow-y-auto p-4 lg:py-8 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('errors')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <ul class="list-disc list-inside">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <?= $this->renderSection('page_content') ?>
            </div>
        </div>
    </main>
</div>

<!-- Confirm Modal (Reusable) -->
<div id="confirmModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-sm w-full mx-4 transform scale-95 transition-transform duration-300" id="confirmModalContent">
        <div class="p-6">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white text-center mb-2" id="confirmModalTitle">Konfirmasi</h3>
            <p class="text-gray-500 dark:text-gray-400 text-center mb-6" id="confirmModalMessage">Apakah Anda yakin ingin melakukan tindakan ini?</p>
            <div class="flex gap-3">
                <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                    Batal
                </button>
                <button id="confirmModalBtn" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition font-medium">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom scrollbar for sidebar */
.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}
.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 4px;
}
.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Sidebar open state */
.sidebar-open {
    transform: translateX(0) !important;
}
</style>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (sidebar.classList.contains('sidebar-open')) {
        sidebar.classList.remove('sidebar-open');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    } else {
        sidebar.classList.add('sidebar-open');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

// Update mobile theme icon too
const originalUpdateThemeIcon = window.updateThemeIcon;
window.updateThemeIcon = function() {
    if (originalUpdateThemeIcon) originalUpdateThemeIcon();
    const iconMobile = document.getElementById('themeIconMobile');
    if (iconMobile) {
        if (document.documentElement.classList.contains('dark')) {
            iconMobile.className = 'fas fa-sun text-yellow-400 text-sm';
        } else {
            iconMobile.className = 'fas fa-moon text-white text-sm';
        }
    }
}

// Confirm Modal Functions
let confirmCallback = null;

function confirmDelete(url, message = 'Yakin ingin menghapus data ini?', title = 'Konfirmasi Hapus') {
    openConfirmModal(title, message, function() {
        window.location.href = url;
    });
}

function openConfirmModal(title, message, callback) {
    const modal = document.getElementById('confirmModal');
    const modalContent = document.getElementById('confirmModalContent');
    
    document.getElementById('confirmModalTitle').textContent = title;
    document.getElementById('confirmModalMessage').textContent = message;
    confirmCallback = callback;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    requestAnimationFrame(() => {
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    });
    
    // Set confirm button action
    document.getElementById('confirmModalBtn').onclick = function() {
        closeConfirmModal();
        if (confirmCallback) confirmCallback();
    };
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    const modalContent = document.getElementById('confirmModalContent');
    
    modal.classList.add('opacity-0');
    modalContent.classList.remove('scale-100');
    modalContent.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Close confirm modal when clicking backdrop
document.getElementById('confirmModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirmModal();
});
</script>
<?= $this->endSection() ?>
