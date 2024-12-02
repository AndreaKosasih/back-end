<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
    <title>Profile | <?= $user['name'] ?? 'User' ?></title>
</head>

<body>
    <header class="header">
        <a href="<?= base_url('/') ?>">
            <div class="logo">Hands</div>
        </a>
        <nav>
            <ul class="nav_links">
                <li><a href="<?= base_url('classes') ?>">Classes</a></li>
                <li><a href="<?= base_url('subscription') ?>">Subscription</a></li>
                <li>
                    <a href="<?= base_url('/login') ?>">
                        <div class="main-button">Login</div>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main style="margin-top: 150px  ;">
        <section class="first-page" style="justify-content: start">
            <h1>My Profile</h1>
            <p>Welcome Back, <?= session()->get('name') ?? 'User' ?></p>

            <div class="profile-container">
                <div class="profile-left">
                    <img src="<?= base_url(('uploads/avatars/' . $user['avatar']) ?? 'images/default-avatar.png') ?>"
                        alt="<?= $user['name'] ?? 'User' ?>'s profile photo"
                        class="profile-image">

                    <div class="info-card">
                        <div class="emp">
                            <h3>
                                User Information
                            </h3>
                        </div>
                        <div class="user-info">
                            <p><?= $user['name'] ?? 'Not set' ?></p>
                            <p><?= $user['email'] ?? 'Not set' ?></p>
                            <p><?= $user['occupation'] ?? 'Not set' ?></p>
                        </div>
                    </div>
                </div>

                <div class="profile-right">
                    <div class="info-card">
                        <h3>Continue your journey</h3>
                        <div class="journey-grid">
                            <div class="info-card">Journey 1</div>
                            <div class="info-card">Journey 2</div>
                            <div class="info-card">Journey 3</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Debug helper
        console.log('User Data:', <?= json_encode($user ?? null) ?>);
    </script>
</body>

</html>