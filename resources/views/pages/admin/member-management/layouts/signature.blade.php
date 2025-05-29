@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))

@section('content')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Include Cropper CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    </head>
    <div class="container">
        <form style="max-width:600px; padding:20px" method="POST" action="{{ route('admin.layout.upload.signature') }}"
            enctype="multipart/form-data" id="uploadForm">
            @csrf
            <div class="form-group">
                <label for="signatureTitle">Signature Title:</label>
                <input type="text" class="form-control" id="signatureTitle" name="signature_title" required>
            </div>
            <div class="form-group">
                <label for="signatureImage">Upload Signature:</label>
                <input type="file" class="form-control-file" id="signatureImage" name="signature_image" accept="image/*"
                    required>
            </div>
            <div class="form-group">
                <label for="croppedImage">Cropped Signature:</label>
                <img src="" alt="Cropped Image" id="croppedImage" style="max-width: 100%;">
            </div>
            <input type="hidden" name="cropped_image_data" id="croppedImageData">
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
        <script>
            $(document).ready(function() {
                const image = document.getElementById('croppedImage');
                const cropper = new Cropper(image, {
                    aspectRatio: 4 / 2, // Aspect ratio for cropping (width/height)
                    viewMode: 1, // Crop box takes up the maximum canvas size
                    preview: '#croppedImage', // Preview element
                    autoCropArea: 1, // Automatically selects the whole image for cropping
                    responsive: false // Enables responsive cropping
                });

                $('#signatureImage').change(function(event) {
                    const files = event.target.files;
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        cropper.replace(event.target.result);
                    }
                    reader.readAsDataURL(files[0]);
                });

                $('#uploadForm').submit(function(event) {
                    event.preventDefault(); // Prevent default form submission

                    // Get the cropped image data as a Blob object
                    cropper.getCroppedCanvas().toBlob(function(blob) {
                        // Create FormData object
                        const formData = new FormData();
                        formData.append('signature_title', $('#signatureTitle').val());
                        formData.append('signature_image', $('#signatureImage')[0].files[0]);
                        formData.append('cropped_image', blob, 'cropped_signature.png');

                        // Send AJAX request
                        const csrfToken = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: "{{ route('admin.layout.upload.signature') }}",
                            method: 'POST',
                            processData: false, // Prevent jQuery from processing the data
                            contentType: false, // Prevent jQuery from setting contentType
                            data: formData,
                            headers: {
                                "Authorization": "Bearer {{ $apiToken ?? '' }}",
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-Csrf-Token': csrfToken
                            },
                            xhrFields: {
                                withCredentials: true
                            },
                            success: function(response) {
                                // Handle success response
                                alert('Successfully Added')
                                console.log(response);
                            },
                            error: function(error) {
                                // Handle error response
                                alert('An error occured!')
                                console.error(error);
                            }
                        });
                    }, 'image/png');
                });
            });
        </script>
    @endpush


@endsection
