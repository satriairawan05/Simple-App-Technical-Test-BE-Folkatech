@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-white">
                    <div class="card-body">
                        <form action="{{ route('company.store') }}" id="form" method="post"
                            onsubmit="btnsubmit.disabled=true; return true;" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="name">Name</label>
                                        <input type="text"
                                            class="form-control @error('name')
                                    is-invalid
                                @enderror"
                                            name="name" id="name" placeholder="Masukan Nama ex: Amazon" required
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $errors->get('name')[0] }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email</label>
                                        <input type="email"
                                            class="form-control @error('name')
                                    is-invalid
                                @enderror"
                                            name="email" id="email" placeholder="Masukan Email ex: amazon@gmail.com"
                                            required value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $errors->get('email')[0] }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label for="logo">Logo</label>
                                        <p id="imageFileName" class="d-none"></p>
                                        <img id="imagePreview" class="d-none" alt="image Preview"
                                            style="max-width: 100%; max-height: 150px;">
                                        <input type="file" class="form-control" name="logo" id="image">
                                        @error('logo')
                                            <div class="invalid-feedback">
                                                {{ $errors->get('logo')[0] }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="website">Website</label>
                                        <input type="text"
                                            class="form-control @error('website')
                                    is-invalid
                                @enderror"
                                            name="website" id="website" placeholder="Masukan Website ex: amazon.com"
                                            value="{{ old('website') }}">
                                        @error('website')
                                            <div class="invalid-feedback">
                                                {{ $errors->get('website')[0] }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6 d-flex justify-content-end">
                                        <a href="{{ route('company.index') }}" class="btn btn-sm btn-warning">Back</a>
                                    </div>
                                    <div class="col-6 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#image").change(function() {
                readURL(this);
            });

            // Fungsi untuk menampilkan preview gambar
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        // Tampilkan preview gambar
                        $("#imagePreview").attr("src", e.target.result);
                        $("#imagePreview").removeClass("d-none");
                        $("#imagePreview").addClass("d-flex mx-auto");

                        // Tampilkan nama file
                        $("#imageFileName").text(input.files[0].name);
                        $("#imageFileName").removeClass("d-none");
                        $("#imageFileName").addClass("text-center");
                    }
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endsection
