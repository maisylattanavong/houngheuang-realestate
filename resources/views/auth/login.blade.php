<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

</head>

<body class="auth-body-bg">
    <div class="bg-overlay"></div>
    <div class="wrapper-page">
        <div class="container-fluid p-0">
            <div class="card" style="background-color: #f7f7f7">
                <div class="card-body mb-3">
                    @php
                        $logo = App\Models\Company::first();
                    @endphp
                    <div class="flex justify-center">
                        <div class="flex justify-center mb-1">
                            @if (!is_null($logo))
                            <a href="{{ url('/') }}" class="auth-logo">
                                <img src="{{ asset($logo->logo) }}" style="height:120px" alt="">
                            </a>
                            @else
                                <img src="{{ asset('upload/no_image.jpg') }}" alt="Realestate" style="height: 120px;">
                            @endif
                        </div>
                    </div>

                    <x-guest-layout>
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        @if ($status == 0)
                            <form method="POST" action="{{ route('admin.login') }}">
                                @csrf

                                <!-- Email Address -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                        : value="{{ Cookie::has('email') ? Cookie::get('email') : '' }}" required
                                        autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-input-label for="password" :value="__('Password')" />

                                    <x-text-input id="password" class="block mt-1 w-full" type="password"
                                        name="password" required autocomplete="current-password"
                                        value="{{ Cookie::has('password') ? Cookie::get('password') : '' }}" />

                                    {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
                                </div>
                                <!-- Remember Me -->
                                <div class="flex justify-between mt-3">
                                    <div class="mt-2">
                                        <label for="remember_me" class="inline-flex items-center">
                                            <input id="remember_me" type="checkbox"
                                                @if (Cookie::has('email')) checked @endif
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                name="remember">
                                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                        </label>
                                    </div>
                                    <div>
                                        <x-primary-button class="ml-10">
                                            {{ __('Log in') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                                <div class="flex items-center justify-center mt-4">
                                    @if (Route::has('password.request'))
                                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    @endif
                                </div>

                </div>
                </form>
            @else
                {{-- <h1>Hello status {{ request('id') }}</h1> --}}
                <form method="POST" action="{{ route('admin.status.login') }}">
                    @csrf

                    <!-- Email Address -->
                    <input type="hidden" name="status" value="{{ request('id') }}">
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :
                            value="{{ Cookie::has('email') ? Cookie::get('email') : '' }}" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password"
                            value="{{ Cookie::has('password') ? Cookie::get('password') : '' }}" />

                        {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
                    </div>
                    <!-- Remember Me -->
                    <div class="flex justify-between mt-3">
                        <div class="mt-2">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    @if (Cookie::has('email')) checked @endif
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    name="remember">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        <div>
                            <x-primary-button class="ml-10">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </div>

                    <div class="flex items-center justify-center mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                </form>
                @endif

                </x-guest-layout>

                <!-- end -->
            </div>
            <!-- end cardbody -->
        </div>
        <!-- end card -->
    </div>
    <!-- end container -->
    </div>
    <!-- end -->

    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (Session::has('message'))
            toastr.options.positionClass = 'toast-bottom-right';
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('msg') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

</body>

</html>
