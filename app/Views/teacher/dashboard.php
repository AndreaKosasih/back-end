<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
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

        .content-section {
            display: none;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h3 class="text-center">Teacher</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-target="dashboard-content">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-target="manage-courses-content">Manage Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container p-3">
            <div id="dashboard-content" class="content-section">
                <h2>Dashboard Content</h2>
                <p>Welcome to the Teacher Dashboard!</p>
            </div>
            <div id="manage-courses-content" class="content-section">
                <!-- Courses content will be loaded here via AJAX -->
            </div>
        </div>
    </div>

    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="/logout">
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Bootstrap dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery first -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Menangani klik pada menu sidebar untuk memunculkan konten tanpa berpindah halaman
        document.querySelectorAll('.nav-link').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah link berpindah halaman

                // Menghapus kelas 'active' dari semua nav-link
                document.querySelectorAll('.nav-link').forEach(function(item) {
                    item.classList.remove('active');
                });

                // Menambahkan kelas 'active' pada link yang diklik
                link.classList.add('active');

                // Menyembunyikan semua konten
                document.querySelectorAll('.content-section').forEach(function(content) {
                    content.style.display = 'none';
                });

                // Menampilkan konten sesuai dengan target
                const target = event.target.getAttribute('data-target');
                if (target) {
                    if (target === 'manage-courses-content') {
                        $.ajax({
                            url: '/teacher/loadManageCourses',
                            method: 'GET',
                            success: function(data) {
                                document.getElementById('manage-courses-content').innerHTML = data; // Insert the courses list or message into the page
                            },
                            error: function(xhr, status, error) {
                                console.log("Error details:", xhr.responseText); // Logs the error response for debugging
                                alert("An error occurred while loading the courses.");
                            }
                        });



                    }
                    document.getElementById(target).style.display = 'block';
                }
            });
        });

        // Default: Tampilkan dashboard ketika halaman dimuat
        document.getElementById('dashboard-content').style.display = 'block';
    </script>
</body>

</html>