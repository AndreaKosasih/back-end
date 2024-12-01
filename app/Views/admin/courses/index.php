<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <!-- Link CSS atau CDN untuk Bootstrap -->
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
            width: 250px;
        }
        .sidebar a {
            color: white;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .item-card {
            display: flex;
            justify-content: space-between;
            background-color: white;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .item-card img {
            width: 120px;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
        }
        .item-card .ms-3 {
            margin-left: 15px;
        }
        .btn-custom {
            background-color: #0eb9a9;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0c9a8a;
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h3 class="text-center">Admin</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Dashboard</a>
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
                    <a class="nav-link" href="#">Manage Subscriptions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h2 class="mb-4">Manage Courses</h2>

            <!-- Button to Add New Course -->
            <a href="admin/courses/create" class="btn btn-custom mb-4">
                Add New Course
            </a>

            <!-- List of Courses -->
            <div class="row">
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-4 mb-4">
                        <div class="item-card">
                            <div class="d-flex align-items-center">
                                <img src="<?= $course['thumbnail'] ?>" alt="Course Image">
                                <div class="ms-3">
                                    <h4 class="text-primary"><?= $course['name'] ?></h4>
                                    <p class="text-muted"><?= $course->category['name'] ?></p>
                                </div>
                            </div>

                            <!-- Count students and videos in the view -->
                            <div class="d-flex flex-column align-items-center">
                                <p class="text-muted">Students</p>
                                <h5 class="text-primary"><?= isset($course->students) ? count($course->students) : 0 ?></h5>
                            </div>

                            <div class="d-flex flex-column align-items-center">
                                <p class="text-muted">Videos</p>
                                <h5 class="text-primary"><?= isset($course->course_videos) ? count($course->course_videos) : 0 ?></h5>
                            </div>

                            <div class="d-flex flex-column align-items-center">
                                <p class="text-muted">Teacher</p>
                                <h5 class="text-primary"><?= $course->teacher->user->name ?? 'N/A' ?></h5>
                            </div>

                            <div class="d-flex align-items-center gap-x-3">
                                <a href="#" class="btn btn-custom">Manage</a>
                                <form action="#" method="POST">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
