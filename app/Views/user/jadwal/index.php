<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('sidebar') ?>
<a href="<?= base_url('user/dashboard') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span>Dashboard</span>
</a>
<a href="<?= base_url('user/modul') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-book w-5"></i>
    <span>Modul Literasi</span>
</a>
<a href="<?= base_url('user/jadwal') ?>" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-alt w-5"></i>
    <span>Jadwal Konsultasi</span>
</a>
<a href="<?= base_url('user/presensi') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-calendar-check w-5"></i>
    <span>Presensi Harian</span>
</a>
<a href="<?= base_url('profile') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-cog w-5"></i>
    <span>Pengaturan</span>
</a>
<a href="<?= base_url('/') ?>" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
    <i class="fas fa-home w-5"></i>
    <span>Beranda</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold text-gray-800">Jadwal Konsultasi</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Calendar -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
        <div id="calendar"></div>
    </div>
    
    <!-- Upcoming Schedule List -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-4 border-b">
            <h3 class="font-semibold text-gray-800">Jadwal Mendatang</h3>
        </div>
        <div class="p-4 max-h-[500px] overflow-y-auto">
            <?php if (empty($jadwals)): ?>
            <p class="text-gray-500 text-center py-4">Belum ada jadwal</p>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($jadwals as $jadwal): ?>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-medium text-gray-800"><?= $jadwal['topik'] ?></span>
                        <span class="px-2 py-1 text-xs rounded-full <?= $jadwal['status'] == 'selesai' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' ?>">
                            <?= ucfirst($jadwal['status']) ?>
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mb-2">
                        <i class="fas fa-chalkboard-teacher mr-1"></i> <?= $jadwal['pengajar_nama'] ?>
                    </p>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-calendar mr-1"></i> <?= date('d M Y', strtotime($jadwal['tanggal'])) ?> • <?= $jadwal['waktu'] ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Custom Popup Modal -->
<div id="eventModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform scale-95 transition-transform duration-300" id="eventModalContent">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800" id="modalTitle">Detail Jadwal</h3>
                <button onclick="closeEventModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="modalBody" class="space-y-3">
                <!-- Content will be injected here -->
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeEventModal()" class="bg-accent hover:bg-accent-hover text-white px-6 py-2 rounded-lg transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Truncate calendar event text */
.fc-event-title {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.fc-daygrid-event {
    overflow: hidden;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Custom popup functions
function openEventModal(title, content) {
    const modal = document.getElementById('eventModal');
    const modalContent = document.getElementById('eventModalContent');
    
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalBody').innerHTML = content;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    requestAnimationFrame(() => {
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    });
}

function closeEventModal() {
    const modal = document.getElementById('eventModal');
    const modalContent = document.getElementById('eventModalContent');
    
    modal.classList.add('opacity-0');
    modalContent.classList.remove('scale-100');
    modalContent.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Close modal when clicking backdrop
document.getElementById('eventModal').addEventListener('click', function(e) {
    if (e.target === this) closeEventModal();
});

// Calendar
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        buttonText: {
            today: 'Hari ini',
            month: 'Bulan',
            week: 'Minggu'
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        events: '<?= base_url('user/jadwal/events') ?>',
        eventDidMount: function(info) {
            info.el.setAttribute('title', info.event.title);
        },
        eventClick: function(info) {
            var props = info.event.extendedProps;
            var statusClass = props.status === 'selesai' 
                ? 'bg-green-100 text-green-600' 
                : 'bg-yellow-100 text-yellow-600';
            
            var content = `
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-calendar-check text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 mb-1">${info.event.title.split(' - ')[0]}</p>
                        <p class="text-sm text-gray-500 mb-2">
                            <i class="fas fa-chalkboard-teacher mr-1"></i> ${props.pengajar || '-'}
                        </p>
                        <p class="text-sm text-gray-500 mb-3">
                            <i class="fas fa-clock mr-1"></i> ${props.waktu || '-'}
                        </p>
                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full ${statusClass}">
                            ${props.status ? props.status.charAt(0).toUpperCase() + props.status.slice(1) : '-'}
                        </span>
                    </div>
                </div>
            `;
            
            openEventModal('Detail Jadwal Konsultasi', content);
        }
    });
    calendar.render();
});
</script>
<?= $this->endSection() ?>
