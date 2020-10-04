@extends('layouts.app')

@section('content')

<div class="alert alert-dark mb-4" role="alert">
    <h4 class="text-light mb-0">Welcome to {{ env('APP_NAME') }}</h4> 
</div> 

@include('user-hci.condition')

@include('user-hci.patients')

@endsection

@push('styles')
<link href="{{ asset('css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css">  
<link href="{{ asset('css/components/tabs-accordian/custom-accordions.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/components/cards/card.css') }}" rel="stylesheet" type="text/css">

@endpush

@push('scripts')

<script src="{{ asset('js/components/ui-accordions.js') }}"></script>
<script type="text/javascript">

</script>
@endpush