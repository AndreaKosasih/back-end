<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hands | Login</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
    <link rel="icon" href="<?= base_url('img/logo.png') ?>" type="image/png">
</head>

<body style="height: 100vh; background: black; position: relative; overflow: hidden;">
    <header class="header">
        <a href="<?= base_url('/') ?>" class="logo">Hands</a>
        <nav>
            <ul class="nav_links">
                <li><a href="<?= base_url('classes') ?>">Classes</a></li>
                <li><a href="<?= base_url('subscription') ?>">Subscription</a></li>
                <li>
                    <a href="<?= base_url('login') ?>">
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
            <div class="login-card" style="height: 22em;">
                <div class="left-login-card">
                    <div class="emp" style="font-size: 4rem;">Login</div>

                    <div id="error-message" style="color: #d50100; margin-bottom: 10px; display: none;"></div>

                    <form action="<?= base_url('/auth/authenticate') ?>" method="POST" id="login-form" class="form-auth">
                        <?= csrf_field() ?>
                        <div class="input-field">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?= old('email') ?>" placeholder="Email" required>

                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="input-field">
                            <div class="remember-me">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <button type="submit" class="submit-button">
                            <div class="emp" style="filter: invert(1);">Login</div>
                        </button>
                    </form>
                </div>
                <div class="div-login-card"></div>
                <div class="right-login-card">
                    <span style="font-size: 2.4rem; margin-bottom: 40%; text-align: justify;">Don't have an account yet?</span>
                    <span style="padding: 5px; margin-bottom: 10%;">Register here</span>
                    <a href="<?= base_url('/register') ?>">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('login-form');
            const errorMessage = document.getElementById('error-message');

            <?php if (session()->getFlashdata('login_error')): ?>
                errorMessage.textContent = '<?= esc(session()->getFlashdata('login_error')) ?>';
                errorMessage.style.display = 'block';
            <?php endif; ?>

            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    if (!loginForm.checkValidity()) {
                        e.preventDefault();
                        errorMessage.textContent = 'Please fill in all required fields';
                        errorMessage.style.display = 'block';
                        return;
                    }
                });
            }
        });
    </script>
</body>

</html>