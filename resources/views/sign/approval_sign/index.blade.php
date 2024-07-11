@extends('layouts.admin')
@section('title', 'Approval Sign')
@section('content')
    <div class="container-fluid">
        <div id="pspdfkit" style="height: 100vh"></div>
    </div>
@endsection
@push('custom-js')
    {{-- <script src="{{ asset('assets/pspdfkit/dist/pspdfkit.js') }}"></script>
    <script>
        PSPDFKit.load({
                container: "#pspdfkit",
                document: "{{ asset('storage/attachments/sign/1-NHR-VI-24.pdf') }}" // Add the path to your document here.
            })
            .then(function(instance) {
                console.log("PSPDFKit loaded", instance);
            })
            .catch(function(error) {
                console.error(error.message);
            });
    </script> --}}
@endpush
