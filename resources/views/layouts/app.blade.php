<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="shortcut icon" href="img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Company Payroll System</title>
    <style>
        /* Fade-out animation */
        .fade-out {
            opacity: 0;
            transition: opacity 1s ease-out;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            background-color: #f8f6f9; /* Soft lavender background instead of pure white */
        }

        /* Pastel color theme overrides */
        .bg-white {
            background-color: #f9f7fa !important; /* Soft off-white */
        }
        
        .shadow {
            box-shadow: 0 4px 6px rgba(180, 175, 205, 0.1) !important; 
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Alert Section -->
    @if (session('success'))
    <div id="success-alert" class="alert alert-success sticky top-0 w-full text-center py-2 px-4 bg-green-100 text-green-800">
        {{ session('success') }}
        <button type="button" class="absolute top-0 right-0 mt-2 mr-4 font-bold"
            onclick="closeAlert('success-alert')"><span class="material-symbols-outlined">
                close
            </span></button>
    </div>
    @endif

    @if (session('error'))
    <div id="error-alert" class="alert alert-error sticky top-0 w-full text-center py-2 px-4 bg-red-100 text-red-800">
        {{ session('error') }}
        <button type="button" class="absolute top-0 right-0 mt-2 mr-4 font-bold"
            onclick="closeAlert('error-alert')"><span class="material-symbols-outlined">
                close
            </span></button>
    </div>
    @endif
    <!-- End Alert Section -->

    <x-navbar />

    @isset($header)
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
    @endisset
    <!-- strat wrapper -->
    <div class="h-screen flex flex-row flex-wrap">

        @include('components.sidebar')

        <!-- strat content -->
        <div class="bg-gray-100 flex-1 p-6 md:mt-16">

            {{ $slot }}

        </div>
        <!-- end content -->

    </div>
    <!-- end wrapper -->

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="/js/scripts.js"></script>
    <!-- Google Material Icons -->
    <script src="https://cdn.jsdelivr.net/npm/google-material-icons@1.0.1/index.min.js"></script>

    <!-- Auto-hide alerts after 10 seconds -->
    <script>
        // Function to close the alert manually
        function closeAlert(alertId) {
            const alertElement = document.getElementById(alertId);
            if (alertElement) {
                alertElement.classList.add('fade-out'); // Add fade-out class
                setTimeout(() => alertElement.remove(), 1000); // Remove after fade-out
            }
        }

        // Auto-hide alerts after 10 seconds
        setTimeout(() => {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');
            if (successAlert) closeAlert('success-alert');
            if (errorAlert) closeAlert('error-alert');
        }, 10000); // 10 seconds
    </script>
    <!-- end script -->

</body>

</html>