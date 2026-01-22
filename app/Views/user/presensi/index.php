<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('sidebar') ?>
<a href="<?= base_url('/') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-home w-5"></i>
    <span>Beranda</span>
</a>
<a href="<?= base_url('user/dashboard') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span>Dashboard</span>
</a>
<a href="<?= base_url('user/modul') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-book w-5"></i>
    <span>Modul Literasi</span>
</a>
<a href="<?= base_url('user/presensi') ?>" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Kalender Aktivitas</span>
</a>
<a href="<?= base_url('profile') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-cog w-5"></i>
    <span>Pengaturan</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <!-- Streak Card -->
    <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-white/80 text-sm">Streak</p>
                <h3 class="text-3xl font-bold"><?= $streak ?> 🔥</h3>
                <p class="text-white/70 text-xs mt-1">Hari berturut-turut</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-fire text-2xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Monthly Stats -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <p class="text-gray-500 text-sm mb-2">Bulan Ini</p>
        <h3 class="text-2xl font-bold text-gray-800"><?= $monthly_stats['total'] ?> Hari</h3>
        <div class="flex gap-2 mt-2">
            <span class="text-xs px-2 py-1 bg-green-100 text-green-600 rounded-full">😊 <?= $monthly_stats['great'] ?></span>
            <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full">😐 <?= $monthly_stats['neutral'] ?></span>
            <span class="text-xs px-2 py-1 bg-red-100 text-red-600 rounded-full">😔 <?= $monthly_stats['bad'] ?></span>
        </div>
    </div>
    
    <!-- Today Check-in Card -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
        <?php if ($today_checkin): ?>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Hari Ini</p>
                <h3 class="text-xl font-bold text-green-600 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> Sudah Check-in
                </h3>
                <p class="text-gray-500 text-sm mt-1">
                    Mood: <?= match($today_checkin['mood']) { 'great' => '😊 Baik', 'neutral' => '😐 Biasa', 'bad' => '😔 Buruk' } ?>
                </p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-green-600 text-2xl"></i>
            </div>
        </div>
        <?php else: ?>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Hari Ini</p>
                <h3 class="text-xl font-bold text-gray-800">Belum Check-in</h3>
                <p class="text-gray-500 text-sm mt-1">Jangan lupa check-in hari ini!</p>
            </div>
            <button onclick="openCheckInModal()" class="bg-accent hover:bg-accent-hover text-white px-6 py-3 rounded-lg transition text-lg font-semibold animate-pulse">
                <i class="fas fa-calendar-check mr-2"></i> Check-in Sekarang
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Calendar -->
<div class="bg-white rounded-xl shadow-sm p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2">
        <h3 class="font-semibold text-gray-800">Kalender Aktivitas</h3>
        <div class="flex gap-4 text-sm">
            <span class="flex items-center gap-2 text-gray-700 dark:text-gray-200"><span class="w-3 h-3 rounded-full bg-green-500"></span> Presensi</span>
            <span class="flex items-center gap-2 text-gray-700 dark:text-gray-200"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Jadwal</span>
        </div>
    </div>
    <div class="overflow-x-auto -mx-4 px-4 lg:mx-0 lg:px-0">
        <div class="min-w-[700px] lg:min-w-0">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- Check-in Modal -->
<div id="checkInModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 modal-backdrop opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden modal-content transform scale-95 opacity-0 translate-y-8 transition-all duration-300">
        <div class="bg-gradient-to-r from-primary-dark to-primary p-4 text-white">
            <div class="flex items-center justify-between">
                <?php
                    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    $tanggalHariIni = $hari[date('w')] . ', ' . date('d') . ' ' . $bulan[date('n') - 1] . ' ' . date('Y');
                ?>
                <h3 class="font-bold text-lg" id="modalTitle">Check-in Harian @ <?= $tanggalHariIni ?></h3>
                <button onclick="closeCheckInModal()" class="text-white/80 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form id="checkInForm" class="p-6">
            <?= csrf_field() ?>
            
            <!-- Mood Selection -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-3">Suasana hati</label>
                <div class="flex gap-4">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="mood" value="bad" class="hidden peer" <?= ($today_checkin && $today_checkin['mood'] == 'bad') ? 'checked' : '' ?>>
                        <div class="peer-checked:ring-2 peer-checked:ring-red-500 peer-checked:bg-red-50 p-4 rounded-xl border-2 border-gray-200 text-center transition hover:border-red-300">
                            <div class="text-4xl mb-2">😔</div>
                            <span class="text-gray-600 font-medium">Buruk</span>
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="mood" value="neutral" class="hidden peer" <?= ($today_checkin && $today_checkin['mood'] == 'neutral') || !$today_checkin ? 'checked' : '' ?>>
                        <div class="peer-checked:ring-2 peer-checked:ring-yellow-500 peer-checked:bg-yellow-50 p-4 rounded-xl border-2 border-gray-200 text-center transition hover:border-yellow-300">
                            <div class="text-4xl mb-2">😐</div>
                            <span class="text-gray-600 font-medium">Biasa</span>
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="mood" value="great" class="hidden peer" <?= ($today_checkin && $today_checkin['mood'] == 'great') ? 'checked' : '' ?>>
                        <div class="peer-checked:ring-2 peer-checked:ring-green-500 peer-checked:bg-green-50 p-4 rounded-xl border-2 border-gray-200 text-center transition hover:border-green-300">
                            <div class="text-4xl mb-2">😊</div>
                            <span class="text-gray-600 font-medium">Baik</span>
                        </div>
                    </label>
                </div>
            </div>
            
            <!-- Progress Notes -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Catatan</label>
                <textarea name="catatan" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                          placeholder="Apa yang kamu pelajari hari ini?"><?= $today_checkin['catatan'] ?? '' ?></textarea>
            </div>
            
            <!-- Submit -->
            <div class="flex items-center justify-between">
                <?php if ($today_checkin): ?>
                <span class="text-xs px-3 py-1 bg-green-100 text-green-600 rounded-full font-medium">
                    <i class="fas fa-check mr-1"></i> Terkirim
                </span>
                <?php else: ?>
                <span></span>
                <?php endif; ?>
                <button type="submit" class="bg-accent hover:bg-accent-hover text-white px-6 py-3 rounded-lg font-semibold transition">
                    OK
                </button>
            </div>
        </form>
    </div>
</div>

<!-- View Modal (for past dates) -->
<div id="viewModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 modal-backdrop opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden modal-content transform scale-95 opacity-0 translate-y-8 transition-all duration-300">
        <div class="bg-gradient-to-r from-gray-600 to-gray-700 p-4 text-white">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-lg" id="viewModalTitle">Check-in Detail</h3>
                <button onclick="closeViewModal()" class="text-white/80 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6" id="viewModalContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
/* Modal animations */
.modal-backdrop.show {
    opacity: 1;
}
.modal-content.show {
    opacity: 1;
    transform: scale(1) translateY(0);
}
/* Mood card hover animation */
.mood-card {
    transition: all 0.2s ease;
}
.mood-card:hover {
    transform: translateY(-2px);
}
/* Emoji bounce animation */
@keyframes bounce-in {
    0% { transform: scale(0); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
.emoji-bounce {
    animation: bounce-in 0.4s ease-out;
}

/* Calendar event styles */
.fc-event {
    border: none !important;
    border-radius: 8px !important;
    padding: 4px 8px !important;
    margin-bottom: 2px !important;
    font-size: 12px !important;
}

.checkin-submitted {
    background-color: transparent !important;
    border: 1px solid #e5e7eb !important;
}

.checkin-submitted .fc-event-title {
    color: #374151 !important;
}

.checkin-missed {
    background-color: transparent !important;
    border: 1px solid #e5e7eb !important;
}

.checkin-missed .fc-event-title {
    color: #374151 !important;
}

/* Today highlight */
.fc-day-today {
    background-color: #fef9c3 !important;
}

/* Fixed height calendar cells */
.fc .fc-scrollgrid-sync-table {
    table-layout: fixed !important;
    width: 100% !important;
}

.fc .fc-daygrid-body tr {
    height: 100px !important;
}

.fc .fc-daygrid-day {
    width: 14.28% !important;
    max-width: 14.28% !important;
    overflow: hidden !important;
}

.fc .fc-daygrid-day-frame {
    min-height: 100px !important;
    height: 100px !important;
    overflow: hidden !important;
    position: relative;
}

.fc-daygrid-body-balanced .fc-daygrid-day-events {
    max-height: 55px !important;
    overflow: hidden !important;
    position: relative !important;
}

.fc .fc-daygrid-more-link {
    color: #0f766e !important;
    font-weight: 600 !important;
    font-size: 11px !important;
}

.fc .fc-daygrid-day-top {
    padding: 4px !important;
}

/* Event overflow fix */
.fc-daygrid-event {
    overflow: hidden !important;
    white-space: nowrap !important;
    text-overflow: ellipsis !important;
    max-width: 100% !important;
}

.fc-daygrid-event-harness {
    overflow: hidden !important;
    max-width: 100% !important;
}

.fc-daygrid-day-events {
    overflow: hidden !important;
}

.fc-event-main {
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}

/* Force events to stay within cell */
.fc-daygrid-day-frame {
    position: relative;
    overflow: hidden !important;
}

.fc-daygrid-event-harness-abs {
    max-width: calc(100% - 4px) !important;
    overflow: hidden !important;
}

/* Mobile calendar responsive */
/* Mobile: Calendar uses horizontal scroll, no shrinking needed */
@media (max-width: 768px) {
    .fc .fc-toolbar {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 8px;
    }
}

/* Custom calendar header */
.fc .fc-toolbar-title {
    font-size: 1.5rem !important;
    font-weight: 600 !important;
    color: #0f766e !important;
}

.fc .fc-button {
    background-color: #6b7280 !important;
    border: none !important;
    padding: 8px 14px !important;
}

.fc .fc-button:hover {
    background-color: #4b5563 !important;
}

.fc .fc-button-primary:not(:disabled).fc-button-active {
    background-color: #0f766e !important;
}

/* Dark mode calendar styles */
.dark .fc {
    --fc-border-color: #374151;
    --fc-page-bg-color: #1f2937;
}

.dark .fc .fc-daygrid-day-number {
    color: #e5e7eb !important;
}

.dark .fc .fc-col-header-cell-cushion {
    color: #e5e7eb !important;
}

.dark .fc .fc-toolbar-title {
    color: #10b981 !important;
}

.dark .fc-day-today {
    background-color: rgba(16, 185, 129, 0.2) !important;
}

.dark .fc-day-today .fc-daygrid-day-number {
    color: #10b981 !important;
    font-weight: bold;
}

.dark .fc .fc-scrollgrid {
    border-color: #374151 !important;
}

.dark .fc .fc-scrollgrid td,
.dark .fc .fc-scrollgrid th {
    border-color: #374151 !important;
}

.dark .fc .fc-daygrid-more-link {
    color: #10b981 !important;
}

.dark .fc-theme-standard td,
.dark .fc-theme-standard th {
    border-color: #374151 !important;
}

/* Dark mode for event text */
.dark .fc-event-title,
.dark .fc-event-main,
.dark .fc-daygrid-event {
    color: #e5e7eb !important;
}

.dark .fc .fc-daygrid-event-dot {
    border-color: #10b981 !important;
}

/* Dark mode for popover/more events popup */
.dark .fc-popover {
    background-color: #1f2937 !important;
    border-color: #374151 !important;
}

.dark .fc-popover-header {
    background-color: #374151 !important;
    color: #e5e7eb !important;
}

.dark .fc-popover-body {
    background-color: #1f2937 !important;
}

.dark .fc-popover .fc-event-title,
.dark .fc-popover .fc-event-main {
    color: #e5e7eb !important;
}

/* Event content inside calendar cells - dark mode */
.dark .fc-daygrid-day-events .text-gray-700 {
    color: #e5e7eb !important;
}
</style>

<script>
// Modal functions with animation
function openCheckInModal() {
    const modal = document.getElementById('checkInModal');
    const content = modal.querySelector('.modal-content');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Trigger animation
    requestAnimationFrame(() => {
        modal.classList.add('show');
        content.classList.add('show');
    });
}

function closeCheckInModal() {
    const modal = document.getElementById('checkInModal');
    const content = modal.querySelector('.modal-content');
    
    modal.classList.remove('show');
    content.classList.remove('show');
    
    // Wait for animation to complete
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

function openViewModal() {
    const modal = document.getElementById('viewModal');
    const content = modal.querySelector('.modal-content');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    requestAnimationFrame(() => {
        modal.classList.add('show');
        content.classList.add('show');
    });
}

function closeViewModal() {
    const modal = document.getElementById('viewModal');
    const content = modal.querySelector('.modal-content');
    
    modal.classList.remove('show');
    content.classList.remove('show');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Close modal when clicking backdrop
document.getElementById('checkInModal').addEventListener('click', function(e) {
    if (e.target === this) closeCheckInModal();
});
document.getElementById('viewModal').addEventListener('click', function(e) {
    if (e.target === this) closeViewModal();
});

// Form submission
document.getElementById('checkInForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= base_url('user/presensi/checkin') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeCheckInModal();
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
});

// Calendar
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        buttonText: {
            today: 'Hari ini',
            month: 'Bulan'
        },
        dayMaxEvents: 2,
        fixedWeekCount: false,
        contentHeight: 600,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        events: '<?= base_url('user/presensi/events') ?>',
        eventContent: function(arg) {
            var props = arg.event.extendedProps;
            
            // Check if it's a jadwal event
            if (props.type === 'jadwal') {
                var statusColor = props.status === 'selesai' ? '#22c55e' : '#3b82f6';
                var html = `
                    <div class="flex items-center gap-1 px-1 py-0.5 text-xs rounded cursor-pointer" style="background-color: ${statusColor}; color: white;">
                        <span class="font-medium">${props.waktu.substring(0, 5)}</span>
                        <span class="truncate">${arg.event.title.replace('📅 ', '')}</span>
                    </div>
                `;
                return { html: html };
            }
            
            // Presensi event
            var isSubmitted = props.status === 'submitted';
            var html = `
                <div class="p-1">
                    <div class="text-xs text-gray-700 mb-1">${arg.event.title}</div>
                    <span class="text-xs px-2 py-0.5 rounded-full ${isSubmitted ? 'bg-green-100 text-green-600 border border-green-200' : 'bg-red-100 text-red-600 border border-red-200'}">
                        ${isSubmitted ? 'Terkirim' : 'Belum Terkirim'}
                    </span>
                </div>
            `;
            
            return { html: html };
        },
        dateClick: function(info) {
            var today = new Date().toISOString().split('T')[0];
            if (info.dateStr === today) {
                openCheckInModal();
            } else if (info.dateStr < today) {
                // View past check-in
                fetch('<?= base_url('user/presensi/date/') ?>' + info.dateStr)
                    .then(response => response.json())
                    .then(result => {
                        if (result.data) {
                            var emoji = {great: '😊', neutral: '😐', bad: '😔'};
                            var moodText = {great: 'Baik', neutral: 'Biasa', bad: 'Buruk'};
                            document.getElementById('viewModalTitle').textContent = 'Check-in @ ' + info.dateStr;
                            document.getElementById('viewModalContent').innerHTML = `
                                <div class="text-center mb-4">
                                    <span class="text-6xl">${emoji[result.data.mood]}</span>
                                    <p class="text-gray-600 mt-2 capitalize font-medium">${moodText[result.data.mood]}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-700">${result.data.catatan || 'Tidak ada catatan'}</p>
                                </div>
                            `;
                        } else {
                            document.getElementById('viewModalTitle').textContent = info.dateStr;
                            document.getElementById('viewModalContent').innerHTML = `
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-calendar-times text-4xl mb-2"></i>
                                    <p>Tidak ada check-in pada tanggal ini</p>
                                </div>
                            `;
                        }
                        openViewModal();
                    });
            }
        },
        eventClick: function(info) {
            var props = info.event.extendedProps;
            
            // Check if it's a jadwal event
            if (props.type === 'jadwal') {
                var statusClass = props.status === 'selesai' 
                    ? 'bg-green-100 text-green-600' 
                    : 'bg-blue-100 text-blue-600';
                document.getElementById('viewModalTitle').textContent = 'Jadwal Konsultasi';
                document.getElementById('viewModalContent').innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 mb-2">${info.event.title.replace('📅 ', '')}</p>
                            <p class="text-sm text-gray-500 mb-1">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>${props.pengajar}
                            </p>
                            <p class="text-sm text-gray-500 mb-3">
                                <i class="fas fa-clock mr-2"></i>${props.waktu}
                            </p>
                            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full ${statusClass}">
                                ${props.status === 'selesai' ? 'Selesai' : 'Belum'}
                            </span>
                        </div>
                    </div>
                `;
                openViewModal();
                return;
            }
            
            // Presensi event
            var emoji = {great: '😊', neutral: '😐', bad: '😔'};
            var moodText = {great: 'Baik', neutral: 'Biasa', bad: 'Buruk'};
            document.getElementById('viewModalTitle').textContent = 'Check-in @ ' + info.event.startStr;
            document.getElementById('viewModalContent').innerHTML = `
                <div class="text-center mb-4">
                    <span class="text-6xl">${emoji[props.mood]}</span>
                    <p class="text-gray-600 mt-2 capitalize font-medium">${moodText[props.mood]}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">${props.catatan || 'Tidak ada catatan'}</p>
                </div>
            `;
            openViewModal();
        }
    });
    calendar.render();
});
</script>
<?= $this->endSection() ?>
