<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login Administrator</title>
    <script defer data-api="/stats/api/event" data-domain="preview.tabler.io" src="/stats/js/script.js"></script>
    <meta name="msapplication-TileColor" content="" />
    <meta name="theme-color" content="" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <link rel="icon" href="./favicon.ico" type="image/x-icon" />
    <meta property="og:image" content="https://preview.tabler.io/static/og.png">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="640">
    <meta property="og:site_name" content="Tabler">
    <meta property="og:type" content="object">
    <meta property="og:title"
        content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta property="og:url" content="https://preview.tabler.io/static/og.png">
    <meta property="og:description"
        content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
    <!-- CSS files -->
    <link href="{{ asset('assets') }}/css/tabler.min.css?1685973381" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/tabler-flags.min.css?1685973381" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/tabler-payments.min.css?1685973381" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/tabler-vendors.min.css?1685973381" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/demo.min.css?1685973381" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" d-flex flex-column">
    <script src="{{ asset('assets') }}/js/demo-theme.min.js?1685973381"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            {{-- <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark">
                    <img src="./static/logo.svg" width="110" height="32" alt="Tabler"
                        class="navbar-brand-image">
                </a>
            </div> --}}
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="login" method="POST" autocomplete="off" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                placeholder="Masukkan Email" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">
                                Password
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" class="form-control" name="password"
                                    placeholder="Masukkan password" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </div>
                    </form>
                </div>

            </div>
            {{-- <div class="text-center text-secondary mt-3">
                Don't have account yet? <a href="./sign-up.html" tabindex="-1">Sign up</a>
            </div> --}}
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('assets') }}/js/tabler.min.js?1685973381" defer></script>
    <script src="{{ asset('assets') }}/js/demo.min.js?1685973381" defer></script>
</body>

</html>
