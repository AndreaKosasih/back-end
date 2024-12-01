<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Teacher</title>

    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .sidebar {
            background-color: #343a40;
            color: white;
            width: 250px;
            min-height: 100vh;
            padding-top: 30px;
            position: fixed;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            flex-grow: 1;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-container h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #6c63ff;
        }

        .form-group .error {
            color: #ff0000;
            font-size: 12px;
            margin-top: 5px;
        }

        .btn-submit {
            background-color: #6c63ff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #5a54d4;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }

            .form-container {
                padding: 20px;
                margin: 10px;
            }
        }
    </style>

</head>
<body>

    <div class="sidebar">
        <h3>Admin</h3>
        <a href="#">Dashboard</a>
        <a href="/admin/categories">Manage Categories</a>
        <a href="#">Manage Courses</a>
        <a href="/admin/teachers">Manage Teachers</a>
        <a href="#">Manage Subscriptions</a>
        <a href="/logout">Logout</a>
    </div>

    <div class="main-content">
        <div class="form-container">
            <h2>Add New Teacher</h2>

            <!-- Flash Error Messages -->
            <?php if (session()->getFlashdata('errors')): ?>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div class="error"><?= esc($error) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <form method="POST" action="<?= site_url('admin/teachers/store') ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" required autofocus>
                    <?php if (isset($errors['email'])): ?>
                        <div class="error"><?= esc($errors['email']) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn-submit">Add New Teacher</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
