@extends('layouts.verif')

@section('content')
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1 class="">{{ __('Verify Your Email Address') }}</h1>
                        <p class="signup-link recovery">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                        @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                        @endif
                        <form class="d-inline text-left" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <div class="form">
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">{{ __('click here to request another') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection
