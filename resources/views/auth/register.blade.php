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
    <title>Inscription - StudyHub</title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .register-card {
            max-width: 500px;
            width: 100%;
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
            text-align: center;
        }

        .subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            z-index: 10;
            cursor: pointer;
        }

        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
        }

        .btn-register:hover {
            opacity: 0.9;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 0.9rem;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            font-size: 0.9rem;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="logo">
            <i class="bi bi-book-half"></i>
        </div>
        
        <h2>StudyHub</h2>
        <p class="subtitle">Créez votre compte gratuitement</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>
                Veuillez corriger les erreurs ci-dessous.
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-2">
                <label class="form-label">Nom complet</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="Jean Dupont"
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="exemple@email.com"
                       required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label class="form-label">Mot de passe</label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           id="password"
                           placeholder="Minimum 8 caractères"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" 
                       class="form-control" 
                       name="password_confirmation" 
                       id="password_confirmation"
                       placeholder="Confirmez votre mot de passe"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Vous êtes</label>
                <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                    <option value="">Sélectionnez</option>
                    <option value="eleve" {{ old('role') == 'eleve' ? 'selected' : '' }}>Élève</option>
                    <option value="enseignant" {{ old('role') == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-register" id="submitBtn">
                <span id="btnText">S'inscrire</span>
                <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
            </button>

            <div class="login-link">
                Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
            </div>
        </form>
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

        document.getElementById('registerForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');
            
            btn.disabled = true;
            btnText.classList.add('d-none');
            spinner.classList.remove('d-none');
        });
    </script>
</body>
</html>