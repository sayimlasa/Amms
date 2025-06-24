 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>IAA Dashboard | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .app-header {
            background-color: #02284b;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            text-transform: uppercase;
            flex-wrap: wrap;
            text-align: center;
        }

        .app-sidebar {
            background-color: white;
            border-right: 2px solid #dee2e6;
            padding: 1.5rem;
        }

        .app-content {
            padding: 2rem;
            background-color: white;
        }

        .btn-primary {
            background-color: #02284b;
            border-color: #02284b;
        }

        .btn-primary:hover {
            background-color: #011d36;
            border-color: #011d36;
        }

        footer.app-footer {
            background-color: #A41E22;
            color: white;
            padding: 1rem;
            text-align: center;
            font-weight: bold;
        }

        .sidebar-title {
            color: #A41E22;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 1rem;
        }

        .sidebar-description {
            background-color: #f1f1f1;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            color: #444;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .login-form {
            max-width: 400px;
            width: 100%;
        }

        @media (max-width: 767.98px) {
            .content-wrapper {
                flex-direction: column !important;
            }

            .app-sidebar,
            .app-content {
                min-height: auto !important;
                border-right: none;
            }

            .app-header {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>

    <header class="app-header">
        <div>IAA LOGO</div>
        <div>INSTITUTE OF ACCOUNTANCY ARUSHA (IAA)</div>
        <div>TAIFA LOGO</div>
    </header>

    <div class="container-fluid">
        <div class="row content-wrapper d-flex flex-md-row flex-column">
            <aside class="app-sidebar col-md-4">
                <div class="sidebar-title">IAA ONLINE APPLICATION SYSTEM (IOAS)</div>
                <div class="sidebar-description">
                    <p>The Institute of Accountancy Arusha (IAA) is a parastatal educational institution under the
                        Ministry
                        of Finance and Planning, originally established in 1987 to offer training for candidates
                        aspiring to
                        acquire NBAA certification.</p>
                    <p>
                        The Rector invites suitably qualified candidates for admission into various programmes for the
                        academic year 2025/2026.
                    </p>
                </div>

                <div class="mb-3">
                    <label class="sidebar-title" for="applicationRequirement">Application Requirements</label>
                    <ul class="list-unstyled mt-2">
                        <li><a href="#">Master Degree</a></li>
                        <li><a href="#">Bachelor Degree</a></li>
                        <li><a href="#">Ordinary Diploma</a></li>
                        <li><a href="#">Basic Technician Certificate</a></li>
                    </ul>
                </div>

                <div class="mb-3">
                    <div class="sidebar-title">Window Status</div>
                    <ul class="list-unstyled mt-2">
                        <li><a href="#">Master Degree</a></li>
                        <li><a href="#">Bachelor Degree</a></li>
                        <li><a href="#">Ordinary Diploma</a></li>
                        <li><a href="#">Basic Technician Certificate</a></li>
                    </ul>
                </div>

                <div class="sidebar-title">Help Desk</div>
            </aside>

            <main class="app-content col-md-8 d-flex flex-column justify-content-center align-items-center">
                <div class="mb-4 text-center">
                    <a href="#" class="text-decoration-none fw-bold fs-5">Welcome to Start Application</a>
                </div>

                <form class="login-form">
                    <div class="mb-3 text-start">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" class="form-control" placeholder="Enter username" required />
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Enter password" required />
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">🔐 Login</button>
                </form>

                <div class="text-center">
                    <a href="#" class="btn btn-outline-secondary btn-sm">❓ Forgot Password</a>
                </div>
            </main>
        </div>
    </div>

    <footer class="app-footer">
        &copy; 2025 INSTITUTE OF ACCOUNTANCY ARUSHA (IAA). All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
