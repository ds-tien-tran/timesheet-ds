@extends('layouts.main')
@section('content')
    @include('notification.error')
    @include('notification.success')
    <h4>Information User</h4>
    <div class="card p-4">
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Name :</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" value="{{ $user->name}}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Email :</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" value="{{ $user->email }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Description :</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" value="{{ $user->description }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Avatar :</label>
            <div class="col-sm-10">
              <img style="width:100px" src="{{asset('images/user/'. $user->avatar)}}" alt="">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Role :</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" 
                value="@foreach($user->roles as $role){{$role->name}}@endforeach
                ">
            </div>
        </div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="width: 200px">
            Change role
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <form action="{{route('user.changeRole', $user->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Change role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" value="1" 
                                @if($user->isUser()) checked @endif>
                                <label class="form-check-label" >
                                user
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" value="2"
                                @if($user->isManager()) checked @endif>
                                <label class="form-check-label" >
                                manager
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" value="3"
                                @if($user->isAdmin()) checked @endif>
                                <label class="form-check-label" >
                                admin
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Change</button>
                            </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    
@endpush