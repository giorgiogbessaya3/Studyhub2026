<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

     <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">
    <title>Connexion - StudyHub</title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 450px;
            width: 90%;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo i {
            font-size: 3rem;
            color: #667eea;
            background: #f0f3ff;
            padding: 20px;
            border-radius: 15px;
        }

        h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 8px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-right: none;
        }

        .form-control {
            border: 1px solid #ddd;
            border-left: none;
            padding: 10px 15px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: none;
        }

        .password-toggle {
            cursor: pointer;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            margin-top: 10px;
            transition: opacity 0.3s;
        }

        .btn-login:hover {
            opacity: 0.9;
        }

        .demo-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .demo-title {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .demo-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .demo-btn {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: left;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 0.9rem;
        }

        .demo-btn:hover {
            background: #e9ecef;
        }

        .demo-btn small {
            display: block;
            color: #666;
            font-size: 0.8rem;
            margin-top: 3px;
        }

        .alert {
            font-size: 0.9rem;
            padding: 10px 15px;
            margin-bottom: 20px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #666;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <i class="bi bi-book-half"></i>
            </div>
            
            <h2 class="text-center">StudyHub</h2>
            <p class="subtitle text-center">Connectez-vous à votre espace</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    Email ou mot de passe incorrect
                </div>
            @endif

            @if(session('status'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" name="password" id="password" required>
                        <span class="input-group-text password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Se souvenir</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-decoration-none small">Mot de passe oublié?</a>
                </div>

                <button type="submit" class="btn-login" id="submitBtn">
                    <span class="spinner-border spinner-border-sm d-none me-2" id="spinner"></span>
                    <span id="btnText">Se connecter</span>
                </button>
            </form>

            <div class="register-link">
                Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
            </div>

            
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        function fillDemo(email, password) {
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="password"]').value = password;
        }

        document.getElementById('loginForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const spinner = document.getElementById('spinner');
            const btnText = document.getElementById('btnText');
            
            btn.disabled = true;
            spinner.classList.remove('d-none');
            btnText.textContent = 'Connexion...';
        });
    </script>
</body>
</html>