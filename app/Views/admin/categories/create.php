<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Category</title>
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
        .main-content {
            margin-left: 250px;
            padding: 20px;
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
                    <a class="nav-link" href="#">Manage Courses</a>
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
        <div class="main-content">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                Create New Category
            </h2>

            <form method="POST" action="/admin/categories/store" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label">Category Icon</label>
                    <input type="file" class="form-control" id="icon" name="icon" required>
                </div>

                <button type="submit" class="btn btn-primary">Save Category</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
