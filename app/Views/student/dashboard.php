<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Link CSS atau CDN untuk Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            min-height: 100vh;
        }
        .sidebar a {
            color: white;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h3 class="text-center">Student</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="/student/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto">
        <h1 class="text-2xl font-bold">Welcome, <?= isset($name) ? esc($name) : 'User' ?></h1>
        <h3 class="text-indigo-950 font-bold text-2xl">Upgrade Skills Today</h3>
                <p class="text-slate-500 text-base">
                    Grow your career with experienced teachers in Alqowy Class.
                </p>
                <a href="/" class="w-fit font-bold py-4 px-6 rounded-full">
                    Explore Catalog
                </a>
        </div>
    </div>

    <!-- Script untuk Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
