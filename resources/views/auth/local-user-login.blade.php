<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokale Login - VoltFM</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #c3f135;
            --secondary-color: #222;
            --light-bg: #f8f9fa;
            --dark-text: #333;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .login-card {
            width: 100%;
            max-width: 450px;
            background-color: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin: 0 20px;
        }
        
        .login-header {
            background-color: var(--primary-color);
            padding: 35px;
            text-align: center;
            position: relative;
        }
        
        .logo {
            font-family: 'Syne', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 0;
        }
        
        .login-body {
            padding: 35px;
        }
        
        .login-title {
            font-family: 'Syne', sans-serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .btn-login {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--dark-text);
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 16px;
            width: 100%;
            margin-top: 15px;
        }
        
        .btn-login:hover {
            background-color: #b3e129;
            border-color: #b3e129;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(195, 241, 53, 0.3);
        }
        
        .login-footer {
            text-align: center;
            padding: 15px 35px 35px;
        }
        
        .login-footer p {
            color: #777;
            margin-bottom: 0;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(195, 241, 53, 0.25);
            border-color: var(--primary-color);
        }
        
        .alert {
            border-radius: 8px;
        }

        .development-notice {
            background-color: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1 class="logo">VOLT!FM</h1>
        </div>
        <div class="login-body">
            <h2 class="login-title">Lokale Login</h2>

            <div class="development-notice">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Deze login pagina is alleen beschikbaar in de ontwikkelomgeving.
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('local.user.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">E-mailadres</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Wachtwoord</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Inloggen
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('user.login') }}" class="text-decoration-none" style="color: var(--primary-color);">
                    <i class="fas fa-arrow-left me-2"></i>
                    Terug naar login
                </a>
            </div>
        </div>
        <div class="login-footer">
            <p>© {{ date('Y') }} VoltFM. Alle rechten voorbehouden.</p>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 