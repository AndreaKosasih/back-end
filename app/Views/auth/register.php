<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hands | Register</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
    <link rel="icon" href="<?= base_url('img/logo.png') ?>" type="image/png">
</head>

<body style="height: 100vh; background: black; position: relative; overflow: hidden;">
    <header class="header">
        <a href="/" class="logo">Hands</a>
        <nav>
            <ul class="nav_links">
                <li><a href="classes">Classes</a></li>
                <li><a href="subscription">Subscription</a></li>
                <li>
                    <a href="login">
                        <div class="main-button">Login</div>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="tubelight">
            <div class="left-light"></div>
            <div class="right-light"></div>
        </div>
        <section class="active">
            <div class="register-card" style="height: 28em;">
                <div class="left-login-card">
                    <div class="emp" style="font-size: 4rem;">Register</div>

                    <?php
                    $errors = session()->getFlashdata('errors');
                    $error = session()->getFlashdata('error');
                    ?>

                    <?php if ($errors || $error): ?>
                        <div class="error-message" style="color: #d50100; margin: 10px 0; padding: 10px; border-radius: 5px;">
                            <?php
                            if (is_array($errors)) {
                                foreach ($errors as $err) {
                                    echo "<p>" . esc($err) . "</p>";
                                }
                            }
                            if ($error) {
                                echo "<p>" . esc($error) . "</p>";
                            }
                            ?>
                        </div>
                    <?php endif; ?>


                    <form action="/register/store" method="post" enctype="multipart/form-data" id="register-form" class="form-auth">
                        <?= csrf_field() ?>
                        <div class="input-field" style="flex-direction: row;">
                            <div class="left-half-card">
                                
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" value="<?= old('name') ?>" required>

                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" value="<?= old('email') ?>" required>

                                <label for="occupation">Occupation:</label>
                                <select name="occupation" id="occupation" class="form-select" required>
                                    <option value="" disabled <?= !old('occupation') ? 'selected' : '' ?>>Select your role</option>
                                    <option value="student" <?= old('occupation') == 'student' ? 'selected' : '' ?>>Student</option>
                                    <option value="teacher" <?= old('occupation') == 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                </select>
                            </div>

                            <div class="right-half-card">
                                <label for="avatar">Avatar:</label>
                                <input type="file" name="avatar" id="avatar" required>

                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password" required>

                                <label for="confirmPassword">Confirm Password:</label>
                                <input type="password" name="confirmPassword" id="confirmPassword" required>
                            </div>
                        </div>
                        <div id="passwordMatch" style="font-size: 0.8em; margin-top: 2.5px; margin-left: 55%;"></div>
                        <button type="submit" class="submit-button" form="register-form">
                            <div class="emp" style="filter: invert(1);">
                                Register
                            </div>
                        </button>
                    </form>

                </div>
                <div class="div-login-card"></div>
                <div class="right-login-card">
                    <span style="font-size: 2.4rem; margin-bottom: 40%; text-align: justify;">Already have an account? Your journey awaits you!</span>
                    <span style="padding: 5px; margin-bottom: 10%;">Login here</span>
                    <a href="login">
                        <div class="main-button" style="width: fit-content; display: flex; align-items: center;">
                            <svg width="35" height="28" viewBox="0 0 35 28" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 14C7.51759 14 12.75 14 12.75 14H32M32 14L20.1791 2M32 14L20.1791 26"
                                    stroke="white" stroke-width="3" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="modal" id="successModal" style="display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
            <div style="background: white; padding: 20px; border-radius: 5px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                <h2 style="color: #4CAF50;">Success!</h2>
                <p style="color: black;"><?= session()->getFlashdata('success') ?></p>
                <button onclick="window.location.href='<?= base_url('auth/login') ?>'"
                    style="background: #4CAF50; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 10px;">
                    Go to Login
                </button>
            </div>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirmPassword');
            const passwordMatch = document.getElementById('passwordMatch');
            const registerForm = document.getElementById('register-form');

            const validatePassword = () => {
                if (confirmPassword.value === '') {
                    passwordMatch.textContent = '';
                    return;
                }

                const match = password.value === confirmPassword.value;
                passwordMatch.style.color = match ? 'green' : '#d50100';
                passwordMatch.textContent = match ? 'Passwords match' : 'Passwords do not match';

                if (registerForm) {
                    const submitButton = registerForm.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = !match;
                    }
                }
            };

            password.addEventListener('input', validatePassword);
            confirmPassword.addEventListener('input', validatePassword);
        });
    </script>
    </script>
</body>

</html>