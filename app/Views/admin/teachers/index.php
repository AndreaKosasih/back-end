<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <!-- Link ke Bootstrap atau CSS lain -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .container {
            max-width: 1000px;
            margin-top: 50px;
        }

        .item-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .item-card img {
            border-radius: 12px;
            width: 120px;
            height: 90px;
            object-fit: cover;
        }

        .btn-primary {
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 20px;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
        }

        .btn-primary:hover, .btn-danger:hover {
            opacity: 0.9;
        }

        .font-bold {
            font-weight: 700;
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Manage Teachers
                </h2>
                <a href="/admin/teachers/create" class="btn btn-primary">Add New</a>
            </div>

            <!-- Menampilkan Flash Message jika ada -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                        <!-- Loop data teachers -->
                        <?php foreach ($teachers as $teacher): ?>
                            <div class="item-card">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('uploads/teachers/' . esc($teacher['photo'])) ?>" alt="Teacher Photo">
                                    <div class="ms-3">
                                        <h3 class="text-indigo-950 text-xl font-bold"><?= esc($teacher['name']) ?></h3>
                                    </div>
                                </div>

                                <div class="d-none d-md-flex flex-column">
                                    <p class="text-slate-500 text-sm">Date</p>
                                    <h3 class="text-indigo-950 text-xl font-bold"><?= esc($teacher['created_at']) ?></h3>
                                </div>

                                <div class="d-none d-md-flex flex-row items-center gap-x-3">
                                    <form action="/admin/teachers/<?= esc($teacher['id']) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                </form>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Tampilkan jika tidak ada teacher -->
                        <?php if (empty($teachers)): ?>
                            <p class="text-center">No teachers found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Script untuk Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
