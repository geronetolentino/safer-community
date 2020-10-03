@extends('layouts.app')

@section('content')

<div class="row layout-spacing">
    <!-- Content -->
    <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
        <div class="user-profile layout-spacing">
            <div class="widget-content widget-content-area">
                <div class="d-flex justify-content-between">
                    <h3 class="">Profile</h3>
                    <a href="{{ route('rs.account.edit') }}" class="mt-2 edit-profile">
                        <i data-feather="edit-3"></i>
                    </a>
                </div>
                <div class="text-center user-info">
                    <img src="{{ route('image.process',['filename'=>Auth::user()->info->profile_photo]) }}" alt="{{ Auth::user()->name }}" style="width: 150px;" />
                    <p class="">{{ Auth::user()->name }}</p>
                </div>
                <div class="user-info-list">
                    <div class="">
                        <ul class="contacts-block list-unstyled">
                            <li class="contacts-block__item">
                                <i data-feather="hash"></i>
                                POI: {{ Auth::user()->info->poi_id }}
                            </li>
                            <li class="contacts-block__item">
                                <i data-feather="calendar"></i>
                                {{ Auth::user()->info->dob??'Not set' }}
                            </li>
                            <li class="contacts-block__item">
                                <i data-feather="map-pin"></i>
                                {{ Auth::user()->fullAddress }}
                            </li>
                            <li class="contacts-block__item">
                                <i data-feather="mail"></i>
                                {{ Auth::user()->email }}
                            </li>
                            <li class="contacts-block__item">
                                <i data-feather="phone"></i>
                                {{ Auth::user()->info->phone_number??'Not set' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="user-profile layout-spacing">
            <div class="widget-content widget-content-area">
                <div class="text-center">
                    @if(env('APP_ENV') == 'production')
                    @php
                        $base64 = base64_encode(QrCode::size(300)->format('png')->generate(Auth::user()->info->poi_id));
                        $file = "data:image/png;base64,". $base64;
                    @endphp
                        
                    <img src="{{ $file }}">
                    <a href="{{ $file }}" class="btn btn-primary btn-block mt-2" download="SafeEntryQr.png"> <i data-feather="download"></i> Download SafeEntry Qr </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">

        <div class="education layout-spacing">
            <div class="widget-content widget-content-area">
                <h3 class="">Travel History</h3>
           
                <div class="timeline-line">
                    @forelse($est_logs as $log) 
                    <div class="item-timeline">
                        <p class="t-time">{{ $log->created_at->format('M d Y')}}</p>
                        <div class="t-dot t-dot-dark"></div>
                        <div class="t-text">
                            @php 
                            $in = Carbon\Carbon::parse($log->checkin)->format('g:i A');
                            if ($log->status == 'OUT') {
                                $out = Carbon\Carbon::parse($log->checkout)->format('g:i A');
                            } else {
                                $out = null;
                            }
                            @endphp
                            <p>{{ $log->establishment->name }} <br>
                                <small>{{ $in . ' - ' . $out}}</small>
                            </p>
                            <p class="t-meta-time">{{ $log->establishment->address }}</p>
                        </div>
                    </div>
                    @empty
                    <h4 class="text-primary">No travel history found.</h4>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">
    .timeline-line .item-timeline .t-time {
        min-width: 140px !important;
    }
    .timeline-line .item-timeline .t-text .t-meta-time {
        min-width: 200px;
    }
    .user-profile .widget-content-area .user-info-list ul.contacts-block {
        max-width: 350px;
    }
</style>
@endpush