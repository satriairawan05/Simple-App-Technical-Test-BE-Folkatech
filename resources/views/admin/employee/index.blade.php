@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    @if (session('success'))
                        <div class="alert alert-success text-dark alert-dismissible mt-2 fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-header d-flex justify-content-end">
                        <a href="{{ route('employee.create') }}" class="btn btn-sm btn-success"><i
                                class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table-bordered table-hover table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee as $d)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $d->firstname }}</td>
                                        <td>{{ $d->lastname }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->phone }}</td>
                                        <td>{{ $d->company->name }}</td>
                                        <td>
                                            <a href="{{ route('employee.edit', $d->id) }}" class="btn btn-sm btn-warning"><i
                                                    class="fa fa-edit"></i></a>
                                            <form action="{{ route('employee.destroy', $d->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="alert('are you sure?')"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $employee->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
