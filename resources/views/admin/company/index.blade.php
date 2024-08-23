@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-white">
                    @if (session('success'))
                        <div class="alert alert-success text-dark alert-dismissible mt-2 fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-header d-flex justify-content-end">
                        <a href="{{ route('company.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table-bordered table-hover table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Website</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $d)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>
                                            @if($d->logo != null)
                                                <img src="{{ asset('storage/'.$d->logo) }}" class="img-fluid img-thumbnail w-50 h-50" alt="{{ $d->name }}">
                                            @else
                                                Logo tidak tersedia!
                                            @endif
                                        </td>
                                        <td>{{ $d->website }}</td>
                                        <td>
                                            <a href="{{ route('company.edit', $d->id) }}"
                                                class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('company.destroy', $d->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="alert('are you sure?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
