@extends('layouts.app', ['title' => __('Drivers')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is a drivers page.'),
        'class' => 'col-lg-12'
    ])
   
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">List of Drivers</h3>
                            </div>
                            <div class="col-4 text-right">
                                <!-- <a href="{{ route('products-create') }}" class="btn btn-success">Add new product</a> -->
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
                            <table class="table align-items-center" id="table-drivers">
                                <thead class="thead-light">
                                    <tr>
                                        <!-- <th scope="col">#</th> -->
                                        <th class="text-center" scope="col">Driver Name</th>
                                        <th class="text-center" scope="col">Email</th>
                                        <th class="text-center" scope="col">Phone</th>
                                        <th class="text-center" scope="col">Creation Date</th>
                                        <!-- <th  class="text-center"scope="col">Status</th> -->
                                        <!-- <th scope="col">Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                 <?php foreach ($drivers as $key => $driver) { ?>
                                    <tr>
                                        <!-- <td><?= $driver->id ?></td> -->
                                        <td><?= $driver->firstname . ' '. $driver->lastname ?></td>
                                        <td><?= $driver->email ?></td>
                                        <td><?= $driver->phone ?></td>
                                        <td class="text-center"><?= date('m/d/Y h:i A', strtotime($driver->created_at)) ?></td>
                                        <!-- <td class="text-center"> <a class="" href="#" data-toggle="modal" data-target="#driverActive" data-driverid="<?= $driver->id ?>"> <?= $driver->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Deactive</span>' ?></a></td> -->
                                         <!-- <td class="">
                                           <a class="mr-2" href="{{ route('products-edit', $driver->id) }}"><i class="fas fa-edit"></i></a>
                                            <a class="mr-2"  href="products/{{ $driver->id }}/destroy"><i class="fa fa-trash"></i></a> 
                                        </td>-->
                                    </tr>
                                    <?php } ?>
                                   
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
        @include('layouts.footers.auth')
    </div>

    <!-- Modal -->
    <div class="modal fade" id="driverActive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            
                <form id="" class="form-horizontal">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-notification">Confirmation</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="py-3 text-center">
                            <i class="ni ni-bell-55 ni-3x"></i>
                            <h4 class="heading mt-4">Are you sure ?</h4>
                            <!-- <p>If you continue, the current Pickup status it will change.</p> -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="activePickup">Yes, Proceed!</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </form>
                
        </div>
    </div>

    <script type="text/javascript">
        $('#table-drivers').DataTable( {
            ordering: false
        } );

        $('#driverActive').on('shown.bs.modal', function (e) {
            
            var driverId = $(e.relatedTarget).data('driverid');
            
            $('#activePickup').click( function() { 
                $.ajax({
                    url : "drivers/activedriver/" + driverId, 
                    type : 'GET',
                    /* context: this, */
                    dataType:"json",
                    data : {'driverId' : driverId},
                    success : function(data){
                        window.location.href = "<?= route('drivers')?>";
                    },
                    fail: function(data) {
                    /*  console.log(data); */
                    } 
                });
            });
        });
    </script>
@endsection