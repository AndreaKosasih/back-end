<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <!-- Link ke Bootstrap atau CSS lain -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-body {
            background-color: #fff;
            padding: 20px;
        }

        .btn-submit {
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 20px;
        }

        .btn-submit:hover {
            background-color: #3730a3;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
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
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Category</h2>

                <!-- Display validation errors -->
                <?php

    use CodeIgniter\HTTP\Method;

    if (session()->getFlashdata('errors')): ?>
                    <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <p><?= esc($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Form untuk mengedit kategori -->
                <form method="POST" action="/admin/categories/update/<?= esc($category['id']) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input id="name" class="block mt-1 w-full p-2 border border-gray-300 rounded-md" type="text" name="name" value="<?= old('name', esc($category['name'])) ?>" required autofocus autocomplete="name">
                        <?php if (isset($validation) && $validation->getError('name')): ?>
                            <div class="text-red-500 mt-2"><?= $validation->getError('name') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                        <input id="icon" class="block mt-1 w-full p-2 border border-gray-300 rounded-md" type="file" name="icon">
                        <!-- Menampilkan ikon yang sudah ada -->
                        <div class="mt-2">
                            <img src="<?= base_url('uploads/categories/' . esc($category['icon'])) ?>" alt="Current Icon" class="w-24 h-24 object-cover rounded-md">
                        </div>
                        <?php if (isset($validation) && $validation->getError('icon')): ?>
                            <div class="text-red-500 mt-2"><?= $validation->getError('icon') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="btn-submit">
                            Update Category
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Script untuk Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
