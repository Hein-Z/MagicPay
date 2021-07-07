@extends('frontend.layouts.app')
@section('nav-title', 'Scan and Pay')

@section('content')
    <div class="row mb-5 pb-5">
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
    <div class="modal fade" id="scanner-model" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scaning QR code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <video width="100%" id="scanner"></video> --}}
                    <div id="reader" width="600px"></div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script2')
    <script src="{{ asset('frontend/js/html5-qrcode.min.js') }}"></script>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            if (decodedText) {
                $('#scanner-model').modal('hide');
                html5QrCode.stop();

                axios.post('/check-user', {
                    to_phone: decodedText
                }).then(res => {
                    $('#spinner-model').modal('hide')

                    if (!res.data.success) {
                        Swal.fire({
                            icon: 'error',
                            title: res.data.user,
                            text: 'This user is invalided',
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: res.data.user,
                            text: decodedText,
                            showCancelButton: true,
                            confirmButtonText: `Confirm`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/transfer?to_phone=' + decodedText
                            }
                        })
                    }

                }).catch(err => {


                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                });


            }
        }

        const html5QrCode = new Html5Qrcode("reader");
        const config = {
            fps: 10,
            qrbox: 250
        };

        $('#scanner-model').on('shown.bs.modal', function(e) {
            html5QrCode.start({
                facingMode: "environment"
            }, config, onScanSuccess);

        })

        $('#scanner-model').on('hidden.bs.modal', function(e) {
            html5QrCode.stop();
        })
    </script>
@endsection
