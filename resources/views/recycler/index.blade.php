
@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is your profile page.'),
        'class' => 'col-lg-12'
    ])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">APP Users</h3>
                            </div>
                            <div class="col-4 text-right">
                                <!-- <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">Add user</a> -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                @if(session()->get('success'))
                                    <div class="alert alert-success">
                                    {{ session()->get('success') }}  
                                    </div>
                                @endif
                            </div>
                            <table class="table align-items-center table-flush" id="table-clients">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Zipcode</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Creation Date</th>
                                        <!-- <th scope="col"></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($app_users as $user)
                                    <tr>
                                        <td>{{$user->firstname}} {{$user->lastname}}</td>
                                        <td><a href="mailto:{{$user->email}}">{{$user->email}}</a> </td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->zipcode}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>{{ date('m/d/Y h:i A', strtotime($user->created_at)) }}</td>
                                        <!-- <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{ route('user.edit', $user->id) }}">Edit</a>
                                                    <a class="dropdown-item" href="user/{{ $user->id }}/destroy">Delete</a>

                                               </div>
                                             
                                            </div>
                                        </td> -->
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav class="d-flex justify-content-end" aria-label="...">
                                
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // $(document).ready( function () {
            //     $('#datatable-basic').DataTable();
            // } );
        </script>
        @include('layouts.footers.auth')
    </div>
    <script type="text/javascript">
        $('#table-clients').DataTable( {
            ordering: false,
            "pagingType": "simple_numbers"
        });
    </script>
@endsection
