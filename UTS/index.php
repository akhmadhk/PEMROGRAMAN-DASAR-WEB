<?php
require_once 'config.php';

// Cek apakah sudah login, jika ya redirect ke dashboard
$isLoggedIn = isLoggedIn();
$username = getUsername();
$role = getUserRole();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Login & Upload - PHP Version</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .auth-container {
            max-width: 450px;
            margin: 50px auto;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: none;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .dashboard-card {
            border-radius: 15px;
            transition: transform 0.3s;
            height: 100%;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .uploaded-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: transform 0.3s;
        }
        .uploaded-image:hover {
            transform: scale(1.05);
        }
        .error-message {
            display: none;
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .success-message {
            display: none;
            color: #28a745;
            font-size: 14px;
            margin-top: 5px;
        }
        .image-preview-container {
            position: relative;
            display: inline-block;
            width: 200px;
            margin: 10px;
        }
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s;
        }
        .remove-image:hover {
            background: rgba(220, 53, 69, 1);
            transform: scale(1.1);
        }
        .navbar {
            background: rgba(255,255,255,0.95) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .loading-spinner {
            display: none;
            margin-top: 10px;
        }
        #imageGalleryRow {
            min-height: 400px;
        }
        #imageGallery {
            min-height: 300px;
        }
        /* Image Modal */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.9);
        }
        .image-modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 90%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .image-modal-close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
        .fade-in {
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

    <!-- Login Page -->
    <div id="loginPage" class="auth-container" style="display: <?php echo $isLoggedIn ? 'none' : 'block'; ?>">
        <div class="card fade-in">
            <div class="card-header text-center">
                <h3><i class="fas fa-lock"></i> Login</h3>
            </div>
            <div class="card-body p-4">
                <form id="loginForm">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="Masukkan username" 
                               value="<?php echo $_COOKIE['remembered_user'] ?? ''; ?>">
                        <div class="error-message" id="usernameError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Masukkan password">
                        <div class="error-message" id="passwordError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Login Sebagai</label>
                        <select class="form-select" id="roleSelect" name="role">
                            <option value="admin" <?php echo (isset($_COOKIE['remembered_role']) && $_COOKIE['remembered_role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="member" <?php echo (isset($_COOKIE['remembered_role']) && $_COOKIE['remembered_role'] === 'member') ? 'selected' : ''; ?>>Member</option>
                        </select>
                        <div class="error-message" id="roleError"></div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember"
                               <?php echo isset($_COOKIE['remember_checked']) && $_COOKIE['remember_checked'] === 'true' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Dashboard Page -->
    <div id="dashboardPage" style="display: <?php echo $isLoggedIn ? 'block' : 'none'; ?>">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><i class="fas fa-home"></i> Dashboard</a>
                <div class="d-flex align-items-center">
                    <span class="me-3">Selamat datang, <strong><?php echo htmlspecialchars($username ?? ''); ?></strong></span>
                    <a href="logout.php" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin logout?')">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user"></i> Informasi User</h5>
                            <hr>
                            <p><strong>Username:</strong> <?php echo htmlspecialchars($username ?? ''); ?></p>
                            <p><strong>Role:</strong> <span class="badge bg-primary"><?php echo strtoupper($role ?? ''); ?></span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-upload"></i> Upload Gambar</h5>
                            <hr>
                            <form id="uploadForm" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="imageUpload" name="image" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF, WEBP (Max: 5MB)</small>
                                    <div class="error-message" id="uploadError"></div>
                                    <div class="success-message" id="uploadSuccess"></div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="uploadBtn">
                                    <i class="fas fa-cloud-upload-alt"></i> Upload
                                </button>
                                <div class="loading-spinner" id="loadingSpinner">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span class="ms-2">Mengupload...</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="imageGalleryRow">
                <div class="col-12">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-images"></i> Galeri Gambar
                                <span id="imageCount" class="badge bg-secondary ms-2">0</span>
                            </h5>
                            <hr>
                            <div id="imageGallery" class="d-flex flex-wrap gap-3">
                                <div class="text-center w-100">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="text-muted mt-2">Memuat gambar...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal">
        <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
        <img class="image-modal-content" id="modalImage">
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
        const currentRole = '<?php echo $role ?? ''; ?>';

        $(document).ready(function() {
            if (isLoggedIn) {
                showDashboard();
                loadImages();
            }
        });

        // Login Form Handler
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            $('.error-message').hide().text('');
            
            const formData = new FormData(this);
            formData.append('remember', $('#rememberMe').is(':checked') ? 'true' : 'false');

            $.ajax({
                url: 'login.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Login berhasil, reload halaman
                        window.location.reload();
                    } else {
                        // Tampilkan error
                        $('#passwordError').text(response.message).show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Login error:', error);
                    $('#passwordError').text('Terjadi kesalahan saat login').show();
                }
            });
        });

        function showDashboard() {
            $('#loginPage').hide();
            $('#dashboardPage').addClass('fade-in').show();
        }

        // Upload Form Handler
        $('#uploadForm').on('submit', function(e) {
            e.preventDefault();
            
            const fileInput = $('#imageUpload')[0];
            const file = fileInput.files[0];
            
            $('#uploadError').hide().text('');
            $('#uploadSuccess').hide().text('');

            if (!file) {
                $('#uploadError').text('Pilih gambar terlebih dahulu!').show();
                return;
            }

            if (!file.type.startsWith('image/')) {
                $('#uploadError').text('File harus berupa gambar!').show();
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                $('#uploadError').text('Ukuran gambar maksimal 5MB!').show();
                return;
            }

            const formData = new FormData(this);

            $('#uploadBtn').prop('disabled', true);
            $('#loadingSpinner').show();

            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    $('#uploadBtn').prop('disabled', false);
                    $('#loadingSpinner').hide();
                    
                    if (response.success) {
                        $('#uploadSuccess').text('Gambar berhasil diupload!').show();
                        $('#uploadForm')[0].reset();
                        loadImages();
                        
                        setTimeout(function() {
                            $('#uploadSuccess').fadeOut();
                        }, 3000);
                    } else {
                        $('#uploadError').text(response.message || 'Gagal mengupload gambar!').show();
                    }
                },
                error: function(xhr, status, error) {
                    $('#uploadBtn').prop('disabled', false);
                    $('#loadingSpinner').hide();
                    console.error('Upload error:', error);
                    
                    if (xhr.status === 401) {
                        alert('Session expired. Silakan login kembali.');
                        window.location.reload();
                    } else {
                        $('#uploadError').text('Terjadi kesalahan saat mengupload!').show();
                    }
                }
            });
        });

        // Load Images
        function loadImages() {
            $.ajax({
                url: 'get_images.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        displayImages(response.images);
                        $('#imageCount').text(response.total || 0);
                    } else {
                        $('#imageGallery').html('<p class="text-muted text-center w-100">Belum ada gambar yang diupload</p>');
                        $('#imageCount').text('0');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Load images error:', error);
                    
                    if (xhr.status === 401) {
                        alert('Session expired. Silakan login kembali.');
                        window.location.reload();
                    } else {
                        $('#imageGallery').html('<p class="text-danger text-center w-100">Gagal memuat gambar</p>');
                        $('#imageCount').text('0');
                    }
                }
            });
        }

        // Display Images
        function displayImages(images) {
            const gallery = $('#imageGallery');
            gallery.empty();
            
            if (images && images.length > 0) {
                images.forEach(function(image) {
                    let uploaderInfo = '';
                    if (currentRole === 'admin' && image.username) {
                        uploaderInfo = `<small class="text-muted">Uploader: <strong>${image.username}</strong></small><br>`;
                    }
                    
                    let deleteButton = '';
                    if (currentRole === 'admin') {
                        deleteButton = `
                            <button class="remove-image" onclick="removeImage('${image.filename}')" title="Hapus gambar">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                    }
                    
                    const imageHtml = `
                        <div class="image-preview-container fade-in">
                            <img src="uploads/${image.filename}" 
                                 class="uploaded-image" 
                                 alt="${image.original_name || image.filename}"
                                 title="Klik untuk memperbesar"
                                 onclick="openImageModal('uploads/${image.filename}')">
                            ${deleteButton}
                            <div class="text-center mt-2" style="width: 200px; word-wrap: break-word;">
                                ${uploaderInfo}
                                <small class="text-muted d-block text-truncate" title="${image.original_name || image.filename}">
                                    ${image.original_name || image.filename}
                                </small>
                                <small class="text-muted d-block">${image.upload_date}</small>
                            </div>
                        </div>
                    `;
                    gallery.append(imageHtml);
                });
            } else {
                gallery.html('<p class="text-muted text-center w-100"><i class="fas fa-images fa-3x mb-3"></i><br>Belum ada gambar yang diupload</p>');
            }
        }

        // Remove Image
        function removeImage(filename) {
            if (currentRole !== 'admin') {
                alert('Akses ditolak! Hanya Admin yang dapat menghapus gambar.');
                return;
            }
            
            if (confirm('Yakin ingin menghapus gambar ini?')) {
                $.ajax({
                    url: 'delete_image.php',
                    type: 'POST',
                    data: { filename: filename },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            loadImages();
                        } else {
                            alert(response.message || 'Gagal menghapus gambar!');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Delete error:', error);
                        
                        if (xhr.status === 401) {
                            alert('Session expired. Silakan login kembali.');
                            window.location.reload();
                        } else {
                            alert('Terjadi kesalahan saat menghapus gambar!');
                        }
                    }
                });
            }
        }

        // Image Modal Functions
        function openImageModal(imageSrc) {
            $('#imageModal').fadeIn();
            $('#modalImage').attr('src', imageSrc);
        }

        function closeImageModal() {
            $('#imageModal').fadeOut();
        }

        $('#imageModal').on('click', function(e) {
            if (e.target.id === 'imageModal') {
                closeImageModal();
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</body>
</html>