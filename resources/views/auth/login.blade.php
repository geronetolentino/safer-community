@extends('layouts.auth')

@section('content')
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1><a><span class="brand-name">{{ env('APP_NAME') }}</span></a></h1>
                        <p class="signup-link">
                            <span>New Here? <a href="{{ route('register') }}">Create an account</a></span>
                            <br>
                            <br>
                            {{-- <span>Visitor? <a href="{{ route('register.visitor') }}">Create an account</a></span> --}}
                        </p>
                        @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i data-feather="x"></i></button>
                            <strong>Success!</strong> {{ session('success') }}</button>
                        </div> 
                        @endif
                        <form method="POST" action="{{ route('login') }}" class="text-left">
                            @csrf
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <i data-feather="user"></i>
                                    <input id="username" name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Username">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <i data-feather="lock"></i>
                                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Log In</button>
                                    </div>
                                    
                                </div>

                                <div class="field-wrapper text-center keep-logged-in">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary" hidden="">
                                          <input type="checkbox" class="new-control-input" name="remember" id="remember" checked="">
                                          <span class="new-control-indicator"></span>{{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="field-wrapper">
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-pass-link">Forgot Password?</a>
                                    @endif
                                </div>

                            </div>
                        </form>
                        @include('auth.credits')

                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
<style>
    .btn-light { border-color: transparent; }
</style>
@endpush