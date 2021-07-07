@extends('frontend.layouts.app')
@section('nav-title', 'Scan and Pay')

@section('content')
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 ">
            <div class="row">
                <div class="col-12 text-center h4 mb-3">QR Scaner</div>
                <div class="col-12 text-center">
                    <div class="col-12 col-lg-8 offset-lg-2 text-center mb-3">
                        <img src="{{ asset('frontend/svg/QR code_Isometric.svg') }}" alt="">
                    </div>
                    <div class="col-12 col-lg-8 offset-lg-2 text-center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#scanner-model">
                            Scan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="scanner-model" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scaning QR code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video width="100%" id="scanner"></video>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script2')
    <script src="{{ asset('frontend/js/qr-scanner.umd.min.js') }}"></script>

    <script>
        var videoElem = document.getElementById('scanner');
        const qrScanner = new QrScanner(videoElem, function(result) {
            // if (result) {
            //     qrScanner.stop();
            //     $('#scanner-model').modal('hide');
            //     console.log('decoded qr code:', result);
            // }
            console.log('decoded qr code:', result);
        });

        $('#scanner-model').on('shown.bs.modal', function(e) {
            qrScanner.start();
        })

        $('#scanner-model').on('hidden.bs.modal', function(e) {
            qrScanner.stop();

        })
    </script>
@endsection
