@extends('layouts.app')
@section('content')
<style>
    .login-card-img {
    object-fit: cover;
    width: 100% !important;
    height: 100% !important;
}
</style>
<div class="container">
    <div class="card login-card" style="border-radius: 15px; background-color: #f8f9fa; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1)">
        <div class="row no-gutters">
            <div class="col-md-7">
                {{-- <img src="{{ asset('assets/garage/images/login.jpg') }}" alt="login" class="login-card-img" style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;"> --}}
                <img src="{{ asset('bg-4.jpg') }}" alt="login" class="login-card-img" style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
            </div>
            <div class="col-md-5">
                <div class="card-body">
                    <div class="brand-wrapper">
                        <img src="{{ asset('icon.png') }}" alt="logo" class="logo">
                    </div>
                    <div class="card card-radius-shadow mt-3" style="border-radius: 10px; background-color: #ffffff; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
                        <div class="card-header">
                            <p class="mb-0" style="font-size: 12px">
                                <b>Bagspace</b> merupakan sistem collaboration tool di mana user bisa berkolaborasi dalam suatu proyek, baik internal department maupun antar department. Sistem ini menyediakan fitur Chat, Booking Room, Timeline Project, serta Digital Sign.
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('login') }}" class="mt-3">
                        @csrf
                        <div class="form-group">
                            <input 
                                type="text" 
                                id="nik" 
                                name="nik" 
                                class="form-control @error('nik') is-invalid @enderror" 
                                placeholder="NIK" 
                                value="{{ old('nik') }}" 
                                required 
                                autocomplete="nik" 
                                autofocus 
                                style="font-size: 12px !important; border-radius: 8px;">
                            @error('nik')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Password" 
                                required 
                                autocomplete="current-password" 
                                style="font-size: 12px !important; border-radius: 8px;">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-danger submit-btn bg-core w-100" style="border-radius: 8px;">
                            {{ __('Login') }}
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>
    // JavaScript to toggle card content visibility
    document.getElementById("cardHeader").addEventListener("click", function() {
        var cardBody = document.getElementById("cardBody");

        // Toggle the visibility of the card body
        if (cardBody.style.display === "none" || cardBody.style.display === "") {
            cardBody.style.display = "block";
        } else {
            cardBody.style.display = "none";
        }
    });

    // Optionally, add animation for smooth transition
    document.getElementById("cardBody").style.transition = "all 0.3s ease-in-out";
</script>
@endsection
