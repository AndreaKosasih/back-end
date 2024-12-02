<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - Teacher</title>
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

        h1 {
            margin-bottom: 30px;
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
            color: black;
        }

        table tbody tr:hover {
            background-color: #f1f3f5;
        }

        .btn {
            border-radius: 20px;
            padding: 5px 15px;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #b02a37;
        }

        .add-new-btn {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3 class="text-center">Teacher Panel</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="/teacher/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/teacher/courses">Manage Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Manage Courses (Teacher)</h1>
                <a href="/teacher/courses/create" class="btn btn-success btn-sm add-new-btn">Add New Course</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Course Name</th>
                        <th>Category</th>
                        <th>Students</th>
                        <th>Videos</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td>
                                <img src="<?= base_url('writable/uploads/' . esc($course->thumbnail)) ?>" alt="Thumbnail" class="img-thumbnail" style="width: 120px; height: 90px;">
                            </td>
                            <td><?= esc($course->name) ?></td>
                            <td><?= esc($course->category_name) ?></td>
                            <td><?= esc($course->students_count) ?></td>
                            <td><?= esc($course->videos_count) ?></td>
                            <td>
                                <a href="/teacher/courses/edit/<?= esc($course->id) ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form action="/teacher/courses/delete/<?= esc($course->id) ?>" method="POST" style="display:inline;">
                                    <?= csrf_field() ?>
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
