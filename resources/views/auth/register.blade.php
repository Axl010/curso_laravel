<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-button:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }
        
        .card-shadow {
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        }
        
        .password-strength {
            height: 4px;
            transition: all 0.3s ease;
        }
        
        .progress-bar {
            border-radius: 2px;
            transition: width 0.5s ease;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            <!-- Encabezado -->
            <div class="px-8 py-10">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 gradient-button rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800">Crear Cuenta</h1>
                    <p class="text-gray-500 mt-2">Completa el formulario para registrarte</p>
                </div>

                <!-- Mensajes de error -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Se encontraron {{ count($errors) }} error(es)
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Formulario de registro -->
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Campo Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-gray-400"></i>Nombre completo
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                required 
                                class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-purple-500 transition duration-200"
                                placeholder="Tu nombre completo"
                                value="{{ old('name') }}"
                                autocomplete="name"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Ingresa tu nombre y apellido</p>
                    </div>
                    
                    <!-- Campo Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>Correo electrónico
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                required 
                                class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-purple-500 transition duration-200"
                                placeholder="usuario@ejemplo.com"
                                value="{{ old('email') }}"
                                autocomplete="email"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-at text-gray-400"></i>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Usaremos este email para contactarte</p>
                    </div>
                    
                    <!-- Campo Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-gray-400"></i>Contraseña
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                required 
                                class="w-full px-4 py-3 pl-10 pr-10 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-purple-500 transition duration-200"
                                placeholder="Mínimo 8 caracteres"
                                autocomplete="new-password"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                        
                        <!-- Indicador de fortaleza de contraseña -->
                        <div class="mt-2">
                            <div class="flex justify-between mb-1">
                                <span class="text-xs font-medium text-gray-500">Fortaleza de contraseña</span>
                                <span id="passwordStrengthText" class="text-xs font-medium">Débil</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="passwordStrengthBar" class="progress-bar h-2 rounded-full bg-red-500 w-1/4"></div>
                            </div>
                            <ul class="mt-2 text-xs text-gray-500 space-y-1">
                                <li id="lengthCheck" class="flex items-center"><i class="fas fa-times text-red-400 mr-2"></i> Mínimo 8 caracteres</li>
                                <li id="uppercaseCheck" class="flex items-center"><i class="fas fa-times text-red-400 mr-2"></i> Al menos una mayúscula</li>
                                <li id="numberCheck" class="flex items-center"><i class="fas fa-times text-red-400 mr-2"></i> Al menos un número</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Campo Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-gray-400"></i>Confirmar contraseña
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                required 
                                class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-purple-500 transition duration-200"
                                placeholder="Repite tu contraseña"
                                autocomplete="new-password"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                        </div>
                        <div id="passwordMatch" class="mt-1 text-xs hidden">
                            <p class="text-green-600 flex items-center"><i class="fas fa-check-circle mr-1"></i> Las contraseñas coinciden</p>
                        </div>
                        <div id="passwordMismatch" class="mt-1 text-xs hidden">
                            <p class="text-red-600 flex items-center"><i class="fas fa-times-circle mr-1"></i> Las contraseñas no coinciden</p>
                        </div>
                    </div>
                    
                    <!-- Términos y condiciones -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input 
                                id="terms" 
                                name="terms" 
                                type="checkbox" 
                                required
                                class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                            >
                        </div>
                        <div class="ml-3">
                            <label for="terms" class="text-sm text-gray-700">
                                Acepto los <a href="#" class="font-medium text-purple-600 hover:text-purple-500">términos y condiciones</a> y la <a href="#" class="font-medium text-purple-600 hover:text-purple-500">política de privacidad</a>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Botón de registro -->
                    <div class="pt-4">
                        <button 
                            type="submit" 
                            id="submitButton"
                            class="w-full gradient-button py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200"
                        >
                            <i class="fas fa-user-plus mr-2"></i>
                            Crear cuenta
                        </button>
                    </div>
                </form>
                
                <!-- Enlace para login -->
                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-gray-600">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500 transition duration-200">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Pie de página -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-500">
                    &copy; {{ date('Y') }} Tu Aplicación. Protegemos tu información personal.
                </p>
            </div>
        </div>
        
        <!-- Información adicional (opcional) -->
        <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl p-4 card-shadow">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-0.5">
                    <i class="fas fa-shield-alt text-purple-500"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800">Seguridad garantizada</h4>
                    <div class="mt-1 text-xs text-gray-600">
                        <p>Tus datos están protegidos con encriptación de última generación.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Funcionalidad para mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Validación de fortaleza de contraseña
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');
            const lengthCheck = document.getElementById('lengthCheck');
            const uppercaseCheck = document.getElementById('uppercaseCheck');
            const numberCheck = document.getElementById('numberCheck');
            
            let strength = 0;
            
            // Validar longitud mínima
            if (password.length >= 8) {
                strength += 25;
                lengthCheck.innerHTML = '<i class="fas fa-check text-green-500 mr-2"></i> Mínimo 8 caracteres';
            } else {
                lengthCheck.innerHTML = '<i class="fas fa-times text-red-400 mr-2"></i> Mínimo 8 caracteres';
            }
            
            // Validar mayúsculas
            if (/[A-Z]/.test(password)) {
                strength += 25;
                uppercaseCheck.innerHTML = '<i class="fas fa-check text-green-500 mr-2"></i> Al menos una mayúscula';
            } else {
                uppercaseCheck.innerHTML = '<i class="fas fa-times text-red-400 mr-2"></i> Al menos una mayúscula';
            }
            
            // Validar números
            if (/\d/.test(password)) {
                strength += 25;
                numberCheck.innerHTML = '<i class="fas fa-check text-green-500 mr-2"></i> Al menos un número';
            } else {
                numberCheck.innerHTML = '<i class="fas fa-times text-red-400 mr-2"></i> Al menos un número';
            }
            
            // Validar caracteres especiales (opcional)
            if (/[^A-Za-z0-9]/.test(password)) {
                strength += 25;
            }
            
            // Actualizar barra de progreso
            strengthBar.style.width = strength + '%';
            
            // Actualizar texto y color según fortaleza
            if (strength <= 25) {
                strengthBar.className = 'progress-bar h-2 rounded-full bg-red-500';
                strengthText.textContent = 'Débil';
                strengthText.className = 'text-xs font-medium text-red-500';
            } else if (strength <= 50) {
                strengthBar.className = 'progress-bar h-2 rounded-full bg-yellow-500';
                strengthText.textContent = 'Regular';
                strengthText.className = 'text-xs font-medium text-yellow-500';
            } else if (strength <= 75) {
                strengthBar.className = 'progress-bar h-2 rounded-full bg-blue-500';
                strengthText.textContent = 'Buena';
                strengthText.className = 'text-xs font-medium text-blue-500';
            } else {
                strengthBar.className = 'progress-bar h-2 rounded-full bg-green-500';
                strengthText.textContent = 'Fuerte';
                strengthText.className = 'text-xs font-medium text-green-500';
            }
        });
        
        // Validación de coincidencia de contraseñas
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordMatch = document.getElementById('passwordMatch');
        const passwordMismatch = document.getElementById('passwordMismatch');
        
        function validatePasswordMatch() {
            if (confirmPasswordInput.value === '') {
                passwordMatch.classList.add('hidden');
                passwordMismatch.classList.add('hidden');
                return;
            }
            
            if (passwordInput.value === confirmPasswordInput.value) {
                passwordMatch.classList.remove('hidden');
                passwordMismatch.classList.add('hidden');
            } else {
                passwordMatch.classList.add('hidden');
                passwordMismatch.classList.remove('hidden');
            }
        }
        
        passwordInput.addEventListener('input', validatePasswordMatch);
        confirmPasswordInput.addEventListener('input', validatePasswordMatch);
        
        // Validación de formulario antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;
            
            if (!terms) {
                e.preventDefault();
                alert('Debes aceptar los términos y condiciones para continuar');
                return;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return;
            }
            
            // Cambiar texto del botón mientras se envía
            const button = document.getElementById('submitButton');
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creando cuenta...';
            button.disabled = true;
        });
        
        // Efecto de enfoque para inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-purple-300', 'ring-opacity-50');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-purple-300', 'ring-opacity-50');
            });
        });
    </script>
</body>
</html>