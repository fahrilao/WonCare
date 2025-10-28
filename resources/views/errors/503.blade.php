@extends('layouts.exception')

@section('content')
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">503</h1>
            <h4 class="mb-2 mx-2">{{ __('errors.503.title') }} 🔧</h4>
            <p class="mb-6 mx-2">{{ __('errors.503.message') }}</p>
            <a href="{{ url('/') }}" class="btn btn-primary mb-10">{{ __('errors.back_to_home') }}</a>
        </div>
    </div>
@endsection
