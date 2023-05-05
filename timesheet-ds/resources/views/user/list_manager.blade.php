@extends('layouts.main')
@section('content')
    @include('notification.error')
    @include('notification.success')
    <h1 class="h3 mb-2">List manager</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table">
                <thead class="table-light">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($managers as $key => $manager)
                        <tr>
                            <th scope="row">{{ $key + 1}}</th>
                            <td>{{ $manager->name }}</td>
                            <td>{{ $manager->email }}</td>
                            <td>
                                <a href="{{route('user.listManagerUser', $manager->id)}}" class="btn btn-success">
                                    <i class="fas fa-users"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
    </div>
    <div class="text-center">
        {!! $managers->links('pagination::bootstrap-4') !!}    
    </div>
@endsection