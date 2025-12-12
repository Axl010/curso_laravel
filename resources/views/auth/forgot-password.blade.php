<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
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
        
        .animation-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            <!-- Encabezado -->
            <div class="px-8 py-10">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 gradient-button rounded-full flex items-center justify-center mx-auto mb-4 animation-pulse">
                        <i class="fas fa-key text-white text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800">Recuperar Contraseña</h1>
                    <p class="text-gray-500 mt-2">Ingresa tu email para recibir el enlace de recuperación</p>
                </div>

                <!-- Mensaje de éxito -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700 font-medium">¡Enlace enviado!</p>
                                <p class="text-sm text-green-600 mt-1">{{ session('status') }}</p>
                                <div class="mt-2">
                                    <p class="text-xs text-green-500">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Revisa tu bandeja de entrada y carpeta de spam
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Información importante -->
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700 font-medium">Instrucciones</p>
                            <ul class="mt-1 text-xs text-blue-600 space-y-1">
                                <li><i class="fas fa-arrow-right mr-1"></i> Ingresa el email asociado a tu cuenta</li>
                                <li><i class="fas fa-arrow-right mr-1"></i> Recibirás un enlace para restablecer tu contraseña</li>
                                <li><i class="fas fa-arrow-right mr-1"></i> El enlace expira en 60 minutos</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf
                    
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
                        
                        <!-- Mostrar errores de validación para email -->
                        @error('email')
                            <div class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Botón de envío -->
                    <div>
                        <button 
                            type="submit" 
                            id="submitButton"
                            class="w-full gradient-button py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200 flex items-center justify-center"
                        >
                            <i class="fas fa-paper-plane mr-2"></i>
                            Enviar enlace de recuperación
                        </button>
                    </div>
                </form>
                
                <!-- Enlaces adicionales -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <div class="space-y-3">
                        <a href="{{ route('login') }}" class="flex items-center text-purple-600 hover:text-purple-500 transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Volver al inicio de sesión
                        </a>
                        <a href="{{ route('register') ?? '#' }}" class="flex items-center text-gray-600 hover:text-gray-500 transition duration-200">
                            <i class="fas fa-user-plus mr-2"></i>
                            ¿No tienes una cuenta? Regístrate
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Pie de página -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100">
                <div class="text-center">
                    <p class="text-xs text-gray-500">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Tu información está protegida con encriptación SSL
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Pasos del proceso -->
        <div class="mt-6 bg-white/90 backdrop-blur-sm rounded-xl p-4 card-shadow">
            <div class="text-center mb-4">
                <h4 class="text-sm font-medium text-gray-800 flex items-center justify-center">
                    <i class="fas fa-list-ol mr-2 text-purple-500"></i>
                    Proceso de recuperación
                </h4>
            </div>
            <div class="flex items-center justify-between">
                <div class="text-center flex-1">
                    <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-2">
                        <span class="text-xs font-bold">1</span>
                    </div>
                    <p class="text-xs text-gray-600">Ingresa email</p>
                </div>
                <div class="flex-1">
                    <div class="h-0.5 bg-gray-300 mx-2"></div>
                </div>
                <div class="text-center flex-1">
                    <div class="w-8 h-8 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-2">
                        <span class="text-xs font-bold">2</span>
                    </div>
                    <p class="text-xs text-gray-400">Revisa tu email</p>
                </div>
                <div class="flex-1">
                    <div class="h-0.5 bg-gray-300 mx-2"></div>
                </div>
                <div class="text-center flex-1">
                    <div class="w-8 h-8 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-2">
                        <span class="text-xs font-bold">3</span>
                    </div>
                    <p class="text-xs text-gray-400">Nueva contraseña</p>
                </div>
            </div>
        </div>
        
        <!-- Información de contacto -->
        <div class="mt-4 text-center">
            <p class="text-xs text-white/80">
                ¿Problemas para recuperar tu cuenta?
                <a href="mailto:soporte@tudominio.com" class="font-medium text-white hover:underline">
                    Contacta a soporte
                </a>
            </p>
        </div>
    </div>

    <script>
        // Animación de envío
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.getElementById('submitButton');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enviando...';
            button.disabled = true;
            
            // Simular delay para mostrar la animación
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        });
        
        // Efecto de enfoque para inputs
        const emailInput = document.getElementById('email');
        
        emailInput.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-purple-300', 'ring-opacity-50');
        });
        
        emailInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-purple-300', 'ring-opacity-50');
        });
        
        // Validación en tiempo real del email
        emailInput.addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email === '') {
                this.classList.remove('border-green-500', 'border-red-500');
                this.classList.add('border-gray-300');
            } else if (emailRegex.test(email)) {
                this.classList.remove('border-gray-300', 'border-red-500');
                this.classList.add('border-green-500');
            } else {
                this.classList.remove('border-gray-300', 'border-green-500');
                this.classList.add('border-red-500');
            }
        });
        
        // Mostrar/ocultar mensaje informativo
        document.addEventListener('DOMContentLoaded', function() {
            // Si hay mensaje de éxito, hacer scroll suave
            if (document.querySelector('.bg-green-50')) {
                document.querySelector('.bg-green-50').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    </script>
</body>
</html>