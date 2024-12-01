<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .register-container h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .register-container button:hover {
            background-color: #0056b3;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9em;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Register</h2>

        <!-- Display any validation errors -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="error-message">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <p><?= esc($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/register/store" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?= old('name') ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= old('email') ?>" required>
            </div>

            <div class="form-group">
                <label for="occupation">Occupation:</label>
                <input type="text" name="occupation" id="occupation" value="<?= old('occupation') ?>" required>
            </div>

            <div class="form-group">
                <label for="avatar">Avatar:</label>
                <input type="file" name="avatar" id="avatar" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            <p>Already registered? <a href="/login">Log in here</a></p>
        </div>
    </div>
</body>

</html>