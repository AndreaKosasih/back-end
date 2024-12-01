<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Course</title>
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
            margin-left: 260px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
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
        <div class="content p-5">
            <h2 class="mb-4">Create New Course</h2>

            <!-- Display Validation Errors -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Form for Creating Course -->
            <form method="POST" action="<?= base_url('/admin/courses/store') ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                        <div class="text-danger"><?= $validation->getError('name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Thumbnail</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
                    <?php if (isset($validation) && $validation->hasError('thumbnail')): ?>
                        <div class="text-danger"><?= $validation->getError('thumbnail') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="teacher" class="form-label">Teacher</label>
                    <select name="teacher_id" id="teacher_id" class="form-control">
                        <option value="">Choose Teacher</option>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?= esc($teacher['id']) ?>" <?= (old('teacher_id') == $teacher['id']) ? 'selected' : '' ?>>
                                <?= esc($teacher['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('teacher_id')): ?>
                        <div class="text-danger"><?= $validation->getError('teacher_id') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">Choose Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= esc($category['id']) ?>" <?= (old('category_id') == $category['id']) ? 'selected' : '' ?>>
                                <?= esc($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('category_id')): ?>
                        <div class="text-danger"><?= $validation->getError('category_id') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="about" class="form-label">About</label>
                    <textarea name="about" id="about" rows="5" class="form-control"><?= old('about') ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('about')): ?>
                        <div class="text-danger"><?= $validation->getError('about') ?></div>
                    <?php endif; ?>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <label for="keypoints" class="form-label">Key Points</label>
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <input type="text" class="form-control mb-2" placeholder="Key point <?= $i + 1 ?>" name="course_keypoints[]">
                    <?php endfor; ?>
                    <?php if (isset($validation) && $validation->hasError('keypoints')): ?>
                        <div class="text-danger"><?= $validation->getError('keypoints') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add New Course</button>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
