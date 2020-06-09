@extends('layouts.app', ['title' => __('Pickups')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is a pickups page.'),
        'class' => 'col-lg-12'
    ])
   
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">List of Pickups</h3>
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
                            <table class="table align-items-center" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <!-- <th scope="col">#</th> -->
                                        <th class="text-center" scope="col">Recycler</th>
                                        <th class="text-center" scope="col">Products</th>
                                        <th class="text-center" scope="col">Comments</th>
                                        <th class="text-center" scope="col">Pickup Date</th>
                                        <th class="text-center" scope="col">Creation Date</th>
                                        <th  class="text-center"scope="col">Status</th>
                                        <!-- <th scope="col">Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                 <?php foreach ($pickups as $key => $pickup) { ?>
                                    <tr>
                                        <!-- <td><?= $pickup->id ?></td> -->
                                        <td><?= $pickup->firstname . ' '. $pickup->lastname ?></td>
                                        <td class="text-center"><a class="" href="#" data-toggle="modal" data-target="#productZip" data-pickupid="<?= $pickup->id ?>"> <?= $pickup->products ?></a></td>
                                        <td><?= $pickup->comments ?></td>
                                        <td class="text-center"><?= date('m/d/Y h:i A', strtotime($pickup->date_pickup)) ?></td>
                                        <td class="text-center"><?= date('m/d/Y h:i A', strtotime($pickup->created_at)) ?></td>
                                        <td class="text-center"> <a class="" href="#" data-toggle="modal" data-target="#pickupActive" data-pickupid="<?= $pickup->id ?>"> <?= $pickup->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Deactive</span>' ?></a></td>
                                         <!-- <td class="">
                                           <a class="mr-2" href="{{ route('products-edit', $pickup->id) }}"><i class="fas fa-edit"></i></a>
                                            <a class="mr-2"  href="products/{{ $pickup->id }}/destroy"><i class="fa fa-trash"></i></a> 
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
    <div class="modal fade" id="productZip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= gettext('ZipCodes Per Product') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive dash-social">
                    
                    <table class="table "><!--listTable-->
                        <thead class="thead-light">
                            <tr> 
                                <th><?= gettext('Product') ?></th>                                        
                                <th class="text-center"><?= gettext('Zip') ?></th>                                            
                            </tr><!--end tr-->
                        </thead>
                        <tbody id="resultZip"><!-- Get the information from Mustache.js --> </tbody>
                    </table>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pickupActive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            
                <form id="" class="form-horizontal">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-notification">Confimation</h6>
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
  
        $('#productZip').on('shown.bs.modal', function (e) {
            
            var pickupId = $(e.relatedTarget).data('pickupid');
            //alert(pickupId);
            
            $.ajax({
                url : "pickups/productzipcode/" + pickupId, 
                type : 'GET',
                /* context: this, */
                dataType:"json",
                data : {'pickupId' : pickupId},
                success : function(data){
                    $('#resultZip').html("");
                    var json_obj = data.result; //parse JSON
                    if (data.success == true) {
                    console.log(data);
                        for (var i in json_obj) {
                            
                        /*    console.log(json_obj[i]["zipcode"]); */
                            $('#resultZip').append("<tr>"+ "<td>"+ json_obj[i]["description"] +"</td>" + "<td class='text-center'>"+ json_obj[i]["zipcode"] +"</td>" + "</tr>");
                        }   
                    }
                },
                fail: function(data) {
                /*  console.log(data); */
                } 
            });
           
        });

        $('#pickupActive').on('shown.bs.modal', function (e) {
            
            var pickupId = $(e.relatedTarget).data('pickupid');
            
            $('#activePickup').click( function() { 
                $.ajax({
                    url : "pickups/activepickup/" + pickupId, 
                    type : 'GET',
                    /* context: this, */
                    dataType:"json",
                    data : {'pickupId' : pickupId},
                    success : function(data){
                        window.location.href = "<?= route('pickups')?>";
                    },
                    fail: function(data) {
                    /*  console.log(data); */
                    } 
                });
            });
        });
    </script>
@endsection