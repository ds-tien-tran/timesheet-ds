@extends('layouts.main')
@section('content')
    @include('notification.error')
    @include('notification.success')
    <h1 class="h3 mb-2">List user</h1>
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
                    @foreach ($users as $key => $user)
                        <tr>
                            <th scope="row">{{ $key + 1}}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @can('seenAdmin')
                                <a href="{{route('user.infoUser', $user->id)}}" class="btn btn-primary"><i class="fas fa-user-edit"></i></a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{$key + 1}}"><i class="fas fa-solid fa-trash"></i></button>
                                @endcan
                               
                                <a href="{{route('timesheet.listTimesheet', $user->id)}}" class="btn btn-success"><i class="fas fa-file-word"></i></a>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$key + 1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title{{$key + 1}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Do you want delete user? 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form method="post" action="{{route('user.destroy', $user->id)}}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    
                                </div>
                            </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    
    </div>
    <div class="text-center">
        {!! $users->links('pagination::bootstrap-4') !!}    
    </div>
@endsection