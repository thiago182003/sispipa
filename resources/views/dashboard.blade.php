@extends('layouts.layout')

@push('styles')
@endpush

@push('scripts')
    <script src={{ asset('/js/dashboards-analytics.js') }}></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-xxl-8 mb-6 order-0">
        </div>
        <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
            <div class="row">
                
            </div>
        </div>
        @if(session('error'))
<script>
    document.addEventListener("DOMContentLoaded", function(){
        alert("{{ session('error') }}");
    });
</script>
@endif
    </div>    
@endsection