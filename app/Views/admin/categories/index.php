<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h3 class="text-center">Admin</h3>
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

        <!-- Content Area -->
        <div class="container py-5">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Manage Categories</h2>

            <div class="mb-3">
                <a href="/admin/categories/create" class="btn btn-success">Add New</a>
            </div>

            <div class="row">
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?= base_url('uploads/categories/' . esc($category['icon'])) ?>" class="card-img-top" alt="<?= esc($category['name']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($category['name']) ?></h5>
                                <a href="/admin/categories/edit//<?= esc($category['id']) ?>" class="btn btn-primary">Edit</a>
                                <form action="/admin/categories/delete/<?= esc($category['id']) ?>" method="POST" style="display:inline;">
                                    <?= csrf_field() ?>
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
