<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<!-- Navbar -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="<?= base_url('/') ?>" class="flex items-center space-x-2 sm:space-x-3 hover:opacity-80 transition">
                <img src="<?= base_url('logo-bps.png') ?>" alt="Logo BPS" class="h-8 w-8 sm:h-10 sm:w-10">
                <div class="flex flex-col">
                    <span class="text-primary-dark font-bold text-sm sm:text-lg leading-tight">SIPOLIS</span>
                    <span class="text-xs text-gray-500 hidden sm:block">BPS Kota Pekanbaru</span>
                </div>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <a href="#modul" class="text-gray-700 hover:text-primary-dark font-medium">Modul</a>
                
                <?php if (session()->get('logged_in')): ?>
                    <?php $dashboardUrl = session()->get('role') === 'pengajar' ? 'pengajar/dashboard' : 'user/dashboard'; ?>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600 text-sm hidden lg:block">Halo, <strong><?= session()->get('nama') ?></strong></span>
                        <a href="<?= base_url($dashboardUrl) ?>" class="bg-accent hover:bg-accent-hover text-white px-4 lg:px-6 py-2 rounded-full font-semibold transition-all">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('auth/login') ?>" class="border-2 border-accent text-accent hover:bg-accent hover:text-white px-6 py-2 rounded-full font-semibold transition-all">Login</a>
                <?php endif; ?>
                
                <!-- Theme Toggle (paling kanan) -->
                <button onclick="toggleTheme()" class="theme-toggle w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition" title="Toggle Theme">
                    <i id="themeIcon" class="fas fa-moon text-gray-600"></i>
                </button>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="flex items-center space-x-3 md:hidden">
                <button onclick="toggleTheme()" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center">
                    <i id="themeIconMobile" class="fas fa-moon text-gray-600 text-sm"></i>
                </button>
                <button onclick="toggleMobileMenu()" class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                    <i id="mobileMenuIcon" class="fas fa-bars text-gray-700"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden border-t border-gray-200">
            <div class="py-4 space-y-3">
                <a href="#modul" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">Modul</a>
                <?php if (session()->get('logged_in')): ?>
                    <?php $dashboardUrl = session()->get('role') === 'pengajar' ? 'pengajar/dashboard' : 'user/dashboard'; ?>
                    <div class="px-4 py-2 text-gray-600 text-sm">Halo, <strong><?= session()->get('nama') ?></strong></div>
                    <a href="<?= base_url($dashboardUrl) ?>" class="block mx-4 bg-accent hover:bg-accent-hover text-white px-4 py-2 rounded-lg font-semibold text-center">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('auth/logout') ?>" class="block mx-4 text-red-500 px-4 py-2 text-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('auth/login') ?>" class="block mx-4 border-2 border-accent text-accent hover:bg-accent hover:text-white px-4 py-2 rounded-lg font-semibold text-center">Login</a>
                    <a href="<?= base_url('auth/register') ?>" class="block mx-4 bg-accent hover:bg-accent-hover text-white px-4 py-2 rounded-lg font-semibold text-center">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const icon = document.getElementById('mobileMenuIcon');
    
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        icon.className = 'fas fa-times text-gray-700';
    } else {
        menu.classList.add('hidden');
        icon.className = 'fas fa-bars text-gray-700';
    }
}

// Update mobile theme icons
const origUpdateThemeIcon = window.updateThemeIcon;
window.updateThemeIcon = function() {
    if (origUpdateThemeIcon) origUpdateThemeIcon();
    const iconMobile = document.getElementById('themeIconMobile');
    if (iconMobile) {
        if (document.documentElement.classList.contains('dark')) {
            iconMobile.className = 'fas fa-sun text-yellow-500 text-sm';
        } else {
            iconMobile.className = 'fas fa-moon text-gray-600 text-sm';
        }
    }
}
</script>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-primary-dark via-primary to-primary-light text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                SIPOLIS
                <span class="block text-accent text-lg md:text-2xl mt-2">Sistem Informasi Pojok Literasi Statistik</span>
            </h1>
            <p class="text-lg text-white/90 mb-8">
                Portal pembelajaran statistik untuk meningkatkan literasi data masyarakat Kota Pekanbaru. 
                Temukan berbagai modul pembelajaran yang mudah dipahami.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="#modul" onclick="smoothScroll(event, 'modul')" class="bg-accent hover:bg-accent-hover text-white px-8 py-3 rounded-full font-semibold transition-all shadow-lg hover:scale-105 transform">
                    <i class="fas fa-book-open mr-2"></i>
                    Lihat Modul
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-white py-8 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl font-bold text-primary-dark mb-1"><?= $total_modul ?>+</div>
                <div class="text-gray-500 text-sm">Modul Tersedia</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-primary-dark mb-1">4</div>
                <div class="text-gray-500 text-sm">Kategori</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-primary-dark mb-1">PDF</div>
                <div class="text-gray-500 text-sm">Format File</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-primary-dark mb-1">100%</div>
                <div class="text-gray-500 text-sm">Gratis</div>
            </div>
        </div>
    </div>
</section>

<!-- Modules Section -->
<section id="modul" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-12">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Modul Terbaru</h2>
                <p class="text-gray-500">Pelajari statistik dengan modul yang mudah dipahami</p>
            </div>
            
            <!-- Search & Filter -->
            <div class="flex items-center gap-2">
                <!-- Search Input -->
                <div class="relative flex-1 min-w-0">
                    <input type="text" id="homeSearchInput" placeholder="Cari modul..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 focus:ring-2 focus:ring-accent focus:border-accent"
                           onkeyup="searchHomeModul(this.value)">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                
                <!-- Category Filter Dropdown -->
                <select id="homeKategoriFilter" onchange="filterHomeModul(this.value)" 
                        class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 focus:ring-2 focus:ring-accent focus:border-accent cursor-pointer flex-shrink-0">
                    <option value="all">Semua Kategori</option>
                    <option value="sosial">Statistik Sosial</option>
                    <option value="produksi">Statistik Produksi</option>
                    <option value="distribusi">Statistik Distribusi</option>
                    <option value="neraca">Neraca & Analisis</option>
                </select>
            </div>
        </div>
        
        <?php if (empty($moduls)): ?>
        <div class="text-center py-12">
            <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Belum ada modul tersedia</p>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="modulGrid">
            <?php foreach ($moduls as $modul): ?>
            <?php $isBookmarked = isset($bookmark_ids) && in_array($modul['id'], $bookmark_ids); ?>
            <div class="modul-card bg-white rounded-2xl shadow-md hover:shadow-xl transition-all overflow-hidden group" data-kategori="<?= $modul['kategori'] ?>" data-title="<?= esc($modul['judul']) ?>">
                <div class="h-40 bg-gradient-to-br 
                    <?php 
                    switch($modul['kategori']) {
                        case 'sosial': echo 'from-blue-400 to-blue-600'; break;
                        case 'produksi': echo 'from-orange-400 to-orange-600'; break;
                        case 'distribusi': echo 'from-green-400 to-green-600'; break;
                        case 'neraca': echo 'from-purple-400 to-purple-600'; break;
                    }
                    ?> flex items-center justify-center relative">
                    <i class="fas fa-file-pdf text-6xl text-white/30"></i>
                    
                    <?php if (session()->get('logged_in')): ?>
                    <!-- Bookmark Button -->
                    <button onclick="toggleHomeBookmark(<?= $modul['id'] ?>, this)" 
                            class="absolute top-2 left-2 w-8 h-8 rounded-full flex items-center justify-center transition
                                   <?= $isBookmarked ? 'bg-yellow-400 text-white' : 'bg-white/20 text-white/70 hover:bg-white/40' ?>">
                        <i class="fas fa-star"></i>
                    </button>
                    <?php endif; ?>
                </div>
                <div class="p-6">
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
                    <?php if (session()->get('logged_in')): ?>
                    <a href="<?= base_url('uploads/modul/' . $modul['file_pdf']) ?>" target="_blank" class="block">
                        <h3 class="font-semibold text-gray-800 mt-3 mb-2 group-hover:text-accent transition cursor-pointer"><?= $modul['judul'] ?></h3>
                    </a>
                    <?php else: ?>
                    <h3 class="font-semibold text-gray-800 mt-3 mb-2"><?= $modul['judul'] ?></h3>
                    <?php endif; ?>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2"><?= $modul['deskripsi'] ?></p>
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-400"><i class="fas fa-file mr-1"></i><?= $modul['ukuran_file'] ?></p>
                        <?php if (session()->get('logged_in')): ?>
                        <a href="<?= base_url('user/modul/download/' . $modul['id']) ?>" 
                           class="bg-accent hover:bg-accent-hover text-white px-4 py-2 rounded-full text-sm transition">
                            <i class="fas fa-download mr-1"></i> Unduh
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-10">
            <?php if (session()->get('logged_in')): ?>
                <a href="<?= base_url('user/modul') ?>" class="inline-block bg-accent hover:bg-accent-hover text-white px-8 py-3 rounded-full font-semibold transition-all">
                    Lihat Semua Modul <i class="fas fa-arrow-right ml-2"></i>
                </a>
            <?php else: ?>
                <a href="<?= base_url('auth/login') ?>" class="inline-block bg-accent hover:bg-accent-hover text-white px-8 py-3 rounded-full font-semibold transition-all">
                    Login untuk Download <i class="fas fa-arrow-right ml-2"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>



<!-- Footer -->
<footer class="bg-primary-dark text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <img src="<?= base_url('logo-bps.png') ?>" alt="Logo BPS" class="h-12 w-12 bg-white rounded-full p-1">
                    <span class="font-bold text-lg">BPS Kota Pekanbaru</span>
                </div>
                <p class="text-white/70 text-sm">
                    Menyediakan data statistik yang berkualitas untuk mendukung pembangunan daerah.
                </p>
            </div>
            
            <div>
                <h4 class="font-semibold text-lg mb-4">Kontak</h4>
                <ul class="space-y-2 text-white/70 text-sm">
                    <li><i class="fas fa-map-marker-alt mr-2"></i>Jl. Rawa Indah Pekanbaru, Riau 28125</li>
                    <li><i class="fas fa-phone mr-2"></i>(0761) 7874567</li>
                    <li><i class="fas fa-envelope mr-2"></i>bps1471@bps.go.id</li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-lg mb-4">Ikuti Kami</h4>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/profile.php?id=100072273431504" target="_blank" class="w-10 h-10 bg-white/10 hover:bg-accent rounded-full flex items-center justify-center transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/bpskotapekanbaru/" target="_blank" class="w-10 h-10 bg-white/10 hover:bg-accent rounded-full flex items-center justify-center transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UCbWrkaa-x6cFElnGn-T7aPg/featured" target="_blank" class="w-10 h-10 bg-white/10 hover:bg-accent rounded-full flex items-center justify-center transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://x.com/bps_statistics" target="_blank" class="w-10 h-10 bg-white/10 hover:bg-accent rounded-full flex items-center justify-center transition">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-white/10 mt-10 pt-8 text-center text-white/50 text-sm">
            <p>&copy; <?= date('Y') ?> Badan Pusat Statistik Kota Pekanbaru. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>

<script>
function filterHomeModul(kategori) {
    const cards = document.querySelectorAll('.modul-card');
    cards.forEach(card => {
        if (kategori === 'all' || card.dataset.kategori === kategori) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Smooth scroll animation
function smoothScroll(event, targetId) {
    event.preventDefault();
    const target = document.getElementById(targetId);
    if (target) {
        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Search modules by title
function searchHomeModul(query) {
    const cards = document.querySelectorAll('.modul-card');
    const searchLower = query.toLowerCase();
    
    cards.forEach(card => {
        const title = card.dataset.title ? card.dataset.title.toLowerCase() : '';
        const kategori = card.dataset.kategori || '';
        const selectedKategori = document.getElementById('homeKategoriFilter').value;
        
        const matchesSearch = title.includes(searchLower);
        const matchesKategori = selectedKategori === 'all' || kategori === selectedKategori;
        
        if (matchesSearch && matchesKategori) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Toggle bookmark from home page
function toggleHomeBookmark(modulId, btn) {
    fetch('<?= base_url('user/modul/bookmark/') ?>' + modulId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.bookmarked) {
                btn.classList.remove('bg-white/20', 'text-white/70', 'hover:bg-white/40');
                btn.classList.add('bg-yellow-400', 'text-white');
            } else {
                btn.classList.remove('bg-yellow-400', 'text-white');
                btn.classList.add('bg-white/20', 'text-white/70', 'hover:bg-white/40');
            }
        }
    })
    .catch(err => console.error(err));
}
</script>
<?= $this->endSection() ?>
