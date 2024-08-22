@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-white">
                    <div class="card-body">
                        <form action="{{ route('employee.edit', $d->id) }}" id="form" method="post"
                            onsubmit="btnsubmit.disabled=true; return true;" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="firstname">First Name</label>
                                        <input type="text"
                                            class="form-control @error('firstname')
                                    is-invalid
                                @enderror"
                                            name="firstname" id="firstname" placeholder="Masukan Nama ex: Budi" required
                                            value="{{ old('firstname', $d->firstname) }}">
                                        @error('firstname')
                                            <div class="invalid-feedback">
                                                {{ $errors->get('firstname')[0] }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="lastname">Last Name</label>
                                        <input type="text"
                                            class="form-control @error('lastname')
                                    is-invalid
                                @enderror"
                                            name="lastname" id="lastname" placeholder="Masukan Nama ex: Andre" required
                                            value="{{ old('lastname', $d->lastname) }}">
                                        @error('lastname')
                                            <div class="invalid-feedback">
                                                {{ $errors->get('lastname')[0] }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label for="email">Email</label>
                                        <input type="email"
                                            class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                            name="email" id="email" placeholder="Masukan Email ex: amazon@gmail.com"
                                            required value="{{ old('email', $d->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $errors->get('email')[0] }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="phone">Phone</label>
                                        <input type="text"
                                            class="form-control @error('phone')
                                    is-invalid
                                @enderror"
                                            name="phone" id="phone"
                                            placeholder="Masukan No Handhone ex: 08XX-XXXX-XXXX"
                                            value="{{ old('phone', $d->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $errors->get('phone')[0] }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="company_id">Company</label>
                                        <select name="company_id" class="form-select form-select-lg form-control" aria-label="Select Company">
                                            @if (old('company_id') == $d->company_id)
                                                @foreach ($company as $com)
                                                    @if (old('company_id') == $com->id)
                                                        <option value="{{ $d->id }}" selected>{{ $d->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option selected>Open this select menu</option>
                                            @endif
                                        </select>
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
@endsection
