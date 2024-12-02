<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course - Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .sidebar h3 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .container {
            margin-left: 260px;
            padding: 30px;
        }

        .sidebar .nav-link {
            font-size: 1.2em;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control, .form-select {
            border-radius: 0.5em;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
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
                    <a class="nav-link" href="/teacher/dashboard">Dashboard</a>
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
            <h1>Create New Course</h1>

            <!-- Error Handling -->
            <?php if (!empty(session()->getFlashdata('errors'))): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Create Course Form -->
            <form action="/teacher/courses/store" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Course Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category_id" required>
                        <option value="">Select Category</option>
                        <!-- Populate categories dynamically -->
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= esc($category->id) ?>" <?= old('category_id') == $category->id ? 'selected' : '' ?>>
                                <?= esc($category->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Course Thumbnail</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required>
                </div>

                <div class="mb-3">
                    <label for="about" class="form-label">Course Description</label>
                    <textarea class="form-control" id="about" name="about" rows="5" required><?= old('about') ?></textarea>
                </div>

                <!-- <div class="mb-3">
                    <label for="keypoints" class="form-label">Key Points</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control mb-2" name="course_keypoints[]" placeholder="Key Point 1" value="<?= old('course_keypoints.0') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control mb-2" name="course_keypoints[]" placeholder="Key Point 2" value="<?= old('course_keypoints.1') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control mb-2" name="course_keypoints[]" placeholder="Key Point 3" value="<?= old('course_keypoints.2') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control mb-2" name="course_keypoints[]" placeholder="Key Point 4" value="<?= old('course_keypoints.3') ?>" required>
                        </div>
                    </div>
                </div> -->

                <button type="submit" class="btn btn-primary">Create Course</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
