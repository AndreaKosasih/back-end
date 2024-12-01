<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .header {
            background-color: #4f46e5;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 2em;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .card div {
            background: #f9f9f9;
            flex: 1 1 calc(25% - 20px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card div:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card svg {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
            fill: #4f46e5;
        }

        .card p {
            font-size: 1em;
            color: #666;
            margin: 0;
        }

        .card h3 {
            font-size: 2em;
            color: #333;
            margin: 10px 0 0;
            font-weight: bold;
        }

        .button.primary {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4f46e5;
            color: #fff;
            text-decoration: none;
            border-radius: 20px;
            font-weight: bold;
            text-align: center;
        }

        .button.primary:hover {
            background-color: #3730a3;
        }

        .student-upgrade {
            text-align: center;
            padding: 20px;
        }

        .student-upgrade h3 {
            font-size: 1.8em;
            color: #333;
        }

        .student-upgrade p {
            font-size: 1em;
            color: #666;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= session()->get('role') === 'owner' ? 'Owner Dashboard' : 'Dashboard' ?></h1>
    </div>

    <div class="container">
        <?php if (session()->get('role') === 'owner'): ?>
            <div class="card">
                <div>
                    <svg><!-- SVG for Courses --></svg>
                    <p>Courses</p>
                    <h3><?= isset($courses) ? $courses : 0 ?></h3>
                </div>
                <div>
                    <svg><!-- SVG for Transactions --></svg>
                    <p>Transactions</p>
                    <h3><?= isset($transactions) ? $transactions : 0 ?></h3>
                </div>
                <div>
                    <svg><!-- SVG for Students --></svg>
                    <p>Students</p>
                    <h3><?= isset($students) ? $students : 0 ?></h3>
                </div>
                <div>
                    <svg><!-- SVG for Teachers --></svg>
                    <p>Teachers</p>
                    <h3><?= isset($teachers) ? $teachers : 0 ?></h3>
                </div>
            </div>
        <?php elseif (session()->get('role') === 'teacher'): ?>
            <div class="card">
                <div>
                    <svg><!-- SVG for Courses --></svg>
                    <p>Courses</p>
                    <h3><?= isset($courses) ? $courses : 0 ?></h3>
                </div>
                <div>
                    <svg><!-- SVG for Students --></svg>
                    <p>Students</p>
                    <h3><?= isset($students) ? $students : 0 ?></h3>
                </div>
            </div>
        <?php elseif (session()->get('role') === 'student'): ?>
            <div class="student-upgrade">
                <h3>Upgrade Skills Today</h3>
                <p>Grow your career with experienced teachers in Alqowy Class.</p>
                <a href="/courses" class="button primary">Explore Catalog</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
