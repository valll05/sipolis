<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SIPOLIS' ?> - BPS Kota Pekanbaru</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- FullCalendar -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            dark: '#004b66',
                            DEFAULT: '#054d6d',
                            light: '#0a6d8e'
                        },
                        accent: {
                            DEFAULT: '#198754',
                            hover: '#157347'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <style>
        .sidebar-link.active {
            background-color: #054d6d;
            color: white;
        }
        
        /* Dark mode styles */
        .dark body {
            background-color: #111827;
        }
        
        .dark .bg-white {
            background-color: #1f2937 !important;
        }
        
        .dark .bg-gray-50 {
            background-color: #111827 !important;
        }
        
        .dark .bg-gray-100 {
            background-color: #1f2937 !important;
        }
        
        .dark .text-gray-800 {
            color: #f9fafb !important;
        }
        
        .dark .text-gray-700 {
            color: #e5e7eb !important;
        }
        
        .dark .text-gray-600 {
            color: #d1d5db !important;
        }
        
        .dark .text-gray-500 {
            color: #9ca3af !important;
        }
        
        .dark .border-gray-200 {
            border-color: #374151 !important;
        }
        
        .dark .border-gray-300 {
            border-color: #4b5563 !important;
        }
        
        .dark .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3) !important;
        }
        
        /* Dark mode calendar */
        .dark .fc {
            --fc-border-color: #374151;
            --fc-page-bg-color: #1f2937;
            --fc-neutral-bg-color: #111827;
            --fc-today-bg-color: #374151;
        }
        
        .dark .fc-theme-standard td, 
        .dark .fc-theme-standard th {
            border-color: #374151;
        }
        
        .dark .fc-col-header-cell-cushion,
        .dark .fc-daygrid-day-number {
            color: #e5e7eb;
        }
        
        .dark .fc-toolbar-title {
            color: #10b981 !important;
        }
        
        /* Dark mode cards */
        .dark .rounded-xl {
            background-color: #1f2937;
        }
        
        /* Dark mode inputs */
        .dark input, .dark textarea, .dark select {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
            color: #f9fafb !important;
        }
        
        .dark input::placeholder, .dark textarea::placeholder {
            color: #9ca3af !important;
        }
        
        /* Dark mode modals */
        .dark .modal-content,
        .dark #checkInModal .bg-white,
        .dark #viewModal .bg-white {
            background-color: #1f2937 !important;
        }
        
        /* Theme toggle button */
        .theme-toggle {
            transition: all 0.3s ease;
        }
    </style>
    
    <script>
        // Check for saved theme preference or default to light
        if (localStorage.getItem('theme') === 'dark' || 
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        }
        
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                html.classList.add('light');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.remove('light');
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            updateThemeIcon();
        }
        
        function updateThemeIcon() {
            const icon = document.getElementById('themeIcon');
            if (icon) {
                if (document.documentElement.classList.contains('dark')) {
                    icon.className = 'fas fa-sun text-yellow-400';
                } else {
                    icon.className = 'fas fa-moon text-gray-600';
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', updateThemeIcon);
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <?= $this->renderSection('content') ?>
    
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
