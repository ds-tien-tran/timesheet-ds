@extends('layouts.main')
@section('content')
    @include('notification.error')
    @include('notification.success')
    <h1 class="h3 mb-2">List user</h1>
    <div class="card shadow mb-4" data-bs-toggle="modal" data-bs-target="#userModal">
        <h4 class="ml-3">Manger : {{ $manager->name}}</h4>
        <div class="d-flex">
            <button class=" ml-3 w-110 btn btn-success"><i class="fas fa-plus"></i> Add User</button>
        </div>
        
        <div class="card-body">
            <table class="table">
                <thead class="table-light">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <th scope="row">{{ $key + 1}}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
    </div>
    <div class="text-center">
        {!! $users->links('pagination::bootstrap-4') !!}    
    </div>
    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add user-manager</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="d-flex mb-4" id="formSearchUser" >
                        <input class="form-control me-2" type="search" placeholder="Search user" aria-label="Search" name="search" id="inputSearch">
                        <button class="btn btn-outline-success" type="button" id="btnSearchUser">Search</button>
                    </form>
                    <table class="table" id="tableShowUser">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .w-110 {
            width: 110px;
        } 
    </style>
@endpush
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#userModal').modal({backdrop: 'static', keyboard: false}) 
            
            // Load list user 
            $.ajax({
                type: "GET",
                url: "{{ route('user.listUserNoManager') }}",
                success: function (response) {
                    data = response.data;
                    var html = '';
                    
                    data.forEach(element => {
                        html += `<tr>`;
                        html += `<td>${element.name}</td>`;
                        html += `<td>${element.email}</td>`;
                        html += `</tr>`;
                    });
                    
                    $('#tableShowUser').append(html);
                }
            });

            //click search user
            $('#btnSearchUser').on('click', function (e) {
                e.preventDefault();
                $('#formSearchUser').submit();
            }); 
            $('#formSearchUser').on('submit', function(e) {
                e.preventDefault();
                let search = $('#inputSearch').val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('user.searchUserNoManager')}}",
                    data: {
                        search:search
                    },
                    success: function (response) {
                        console.log(response);
                    }
                    // error: function(response) {
                    //     console.log('err')
                    // }
                });
            });
        });
    </script>
@endpush