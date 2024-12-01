<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
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
                    <a class="nav-link" href="#" data-target="dashboard-content">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-target="courses-content">Manage Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container p-3">
            <!-- Dashboard Content (Default) -->
            <div id="dashboard-content" class="content-section">
                <h2>Dashboard Content</h2>
                <p>Welcome to the Teacher Dashboard!</p>
            </div>

            <!-- Manage Courses Content -->
            <div id="courses-content" class="content-section">
                <h2>Manage Your Courses</h2>
                <p>Hello, <?= esc($teacherName) ?>. Here are the courses you are managing:</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Course Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($courses)): ?>
                            <tr>
                                <td colspan="4" class="text-center">No courses found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($courses as $index => $course): ?>
                                <tr>
                                    <td><?= esc($index + 1) ?></td>
                                    <td><?= esc($course['course_name']) ?></td>
                                    <td><?= esc($course['description']) ?></td>
                                    <td>
                                        <a href="/teacher/course/edit/<?= esc($course['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="/teacher/course/delete/<?= esc($course['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <a href="/teacher/course/create" class="btn btn-success">Create New Course</a>
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
                    <form action="/logout" method="POST">
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Menangani klik pada menu sidebar untuk memunculkan konten tanpa berpindah halaman
        document.querySelectorAll('.nav-link').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah link berpindah halaman
                
                // Menyembunyikan semua konten
                document.querySelectorAll('.content-section').forEach(function(content) {
                    content.style.display = 'none';
                });

                // Menampilkan konten sesuai dengan target
                const target = event.target.getAttribute('data-target');
                if (target) {
                    document.getElementById(target).style.display = 'block';
                }
            });
        });

        // Default: Tampilkan courses-content ketika halaman dimuat
        document.getElementById('courses-content').style.display = 'block';
    </script>

