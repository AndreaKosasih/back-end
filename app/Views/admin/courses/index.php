<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #343a40;
            color: white;
            min-height: 100vh;
            padding: 20px;
        }

        .sidebar h3 {
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 4px;
        }

        .container {
            margin-left: 220px; /* Adjust sidebar width */
            padding: 20px;
        }

        table {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table th,
        table td {
            vertical-align: middle;
            text-align: center;
        }

        table th {
            background-color: #495057;
            color: white;
        }

        table tbody tr:hover {
            background-color: #f1f3f5;
        }

        img {
            border-radius: 8px;
            object-fit: cover;
            width: 120px;
            height: 90px;
        }

        .btn {
            border-radius: 20px;
            padding: 5px 15px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3 class="text-center">Admin Panel</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="/admin/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/categories">Manage Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/courses">Manage Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/teachers">Manage Teachers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/transactions">Manage Subscriptions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container">
            <h1>Manage Courses (Admin)</h1>
            <a href="/admin/courses/create" class="btn btn-primary mb-3">Add New Course</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Course Name</th>
                        <th>Category</th>
                        <th>Teacher</th>
                        <th>Students</th>
                        <th>Videos</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td>
                                <img src="<?= base_url('writable/uploads/' . esc($course->thumbnail)) ?>" alt="Thumbnail">
                            </td>
                            <td><?= esc($course->name) ?></td>
                            <td><?= esc($course->category_name) ?></td>
                            <td><?= esc($course->teacher_name) ?></td>
                            <td><?= esc($course->students_count) ?></td>
                            <td><?= esc($course->videos_count) ?></td>
                            <td>
                                <a href="/admin/courses/manage/<?= esc($course->id) ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form action="/admin/courses/delete/<?= esc($course->id) ?>" method="POST" style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
