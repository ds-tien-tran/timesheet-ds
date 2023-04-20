@extends('layouts.main')
@section('content')
    @include('notification.error')
    @include('notification.success')
    <h4>Information User</h4>
    <div class="card p-4">
        <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" placeholder="name" value="{{ old('name', $user->name)}}" name="name">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="email" value="{{ old('email', $user->email)}}" name="email">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Avatar</label>
                <input type="file" id="avatar" class="form-control" placeholder="avatar" value="{{$user->avatar}}" name="avatar" >
                <img id="imgPreview" src="{{asset('images/user/'.$user->avatar)}}" alt="" height="100px" width="100px" alt="avatar">
                @error('avatar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="3" name="description">{{ old('description', $user->description)}}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-danger">Back</a>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#avatar').change(function(){
                const file = this.files[0];
                if (file){
                    let reader = new FileReader();
                    reader.onload = function(event){
                        $('#imgPreview').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        })
    </script>
@endpush