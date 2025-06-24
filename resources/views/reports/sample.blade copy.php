 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8" />
     <title>IAA Dashboard Full Page Layout with Centered Login</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
     <style>
         html,
         body {
             height: 100%;
             margin: 0;
             font-family: Arial, sans-serif;
             display: flex;
             flex-direction: column;
             background-color: #f8f9fa;
         }

         header {
             background-color: #02284b;
             color: white;
             padding: 1rem 2rem;
             display: flex;
             justify-content: space-between;
             align-items: center;
             font-weight: bold;
             text-transform: uppercase;
         }

         .page-body {
             flex: 1;
             display: flex;
         }

         .sidebar {
             width: 600px;
             background-color: white;
             color: #02284b;
             padding: 2rem 1.5rem;
             box-sizing: border-box;
             display: flex;
             flex-direction: column;
             gap: 1rem;
             border-right: 2px solid #e0e0e0;
         }

         .sidebar ul {
             list-style: none;
             padding-left: 0;
         }

         .sidebar li {
             margin-bottom: 1rem;
         }

         .sidebar a {
             color: #02284b;
             text-decoration: none;
             font-weight: bold;
             display: block;
             padding: 0.5rem 1rem;
             border-radius: 6px;
             transition: background-color 0.2s, color 0.2s;
         }

         .sidebar a:hover {
             background-color: #02284b;
             color: white;
         }

         .sidebar .description {
             font-size: 0.875rem;
             color: #444;
             line-height: 1.5;
             padding: 0.75rem 1rem;
             background-color: #f1f1f1;
             border-radius: 6px;
         }

         .content {
             flex: 1;
             background-color: white;
             padding: 2rem;
             box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.03);
             display: flex;
             flex-direction: column;
             justify-content: center;
             align-items: center;
         }

         .content form {
             width: 100%;
             max-width: 360px;
         }

         .btn-primary {
             background-color: #02284b;
             border-color: #02284b;
         }

         .btn-primary:hover {
             background-color: #011d36;
             border-color: #011d36;
         }

         footer {
             background-color: #A41E22;
             color: white;
             text-align: center;
             padding: 1rem;
             font-weight: bold;
         }

         .content a.text-decoration-none {
             color: #A41E22;
         }

         .content a.text-decoration-none:hover {
             text-decoration: underline;
         }
     </style>
 </head>

 <body>

     <header>
         <div>IAA LOGO</div>
         <div>INSTITUTE OF ACCOUNTANCY ARUSHA (IAA)</div>
         <div>TAIFA LOGO</div>
     </header>

     <div class="page-body">
         <nav class="sidebar">
             <ul>
                 <li><strong style="color:#A41E22;">IAA ONLINE APPLICATION SYSTEM (IOAS)</strong></li>
                 <ul>
                     <li>
                         The Institute of Accountancy Arusha (IAA) is a parastatal educational institution under the
                         Ministry of Finance and Planning, originally established in 1987 to offer training for
                         candidates aspiring to acquire National Board of Accountants and Auditors (NBAA) certification.
                     </li>
                 </ul>

                 <li strong style="color:#A41E22;">
                     <label for="applicationRequirement"><strong>Application Requirements</strong></label>
                     <select id="applicationRequirement" class="form-select mt-2">
                         <option value="">-- Select Requirement --</option>
                         <option value="master">Master Degree</option>
                         <option value="bachelor">Bachelor Degree</option>
                         <option value="diploma">Ordinary Diploma</option>
                         <option value="certificate">Basic Technician Certificate</option>
                     </select>
                 </li>

                 <li strong style="color:#A41E22;" >Window Status</a></li>
                 <li strong style="color:#A41E22;">Help Desk</a></li>
             </ul>
         </nav>

         <main class="content">
             <div class="mb-4">
                 <a href="{{ route('login') }}" class="text-decoration-none fw-bold fs-5">Welcome to Start
                     Application</a>
             </div>
             <form>
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

     <footer>
         &copy; 2025 INSTITUTE OF ACCOUNTANCY ARUSHA (IAA). All rights reserved.
     </footer>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 </body>

 </html>
