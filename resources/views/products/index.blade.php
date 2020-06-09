@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is a product page.'),
        'class' => 'col-lg-12'
    ])
   
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Products</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('products-create') }}" class="btn btn-success">Add new product</a>
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
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">State</th>
                                        <th scope="col">ZipCode(s)</th>
                                        <th scope="col">Creation Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                        <!-- <th scope="col">Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                 <?php foreach ($products as $key => $product) { ?>
                                    <tr>
                                        <td><?= $product->name ?></td>
                                        <td>
                                            <?= $product->state ?>
                                        </td>
                                        
                                        <td class="text-center"><a class="" href="#" id="modalZip" data-toggle="modal" data-target="#productZip" data-productid="<?= $product->id ?>"> <?= $product->zips ?></button></td>
                                       
                                      
                                        <td><?= date('m/d/Y h:i A', strtotime($product->created_at)) ?></td>
                                        <td>
                                            <?= $product->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Deactive</span>' ?>
                                        </td>
                                        <td class="">
                                            <a class="mr-2" href="{{ route('products-edit', $product->id) }}"><i class="fas fa-edit"></i></a>
                                            <a class="mr-2"  href="products/{{ $product->id }}/destroy"><i class="fa fa-trash"></i></a>
                                        </td>
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

    <script type="text/javascript">
  
        $('#productZip').on('shown.bs.modal', function (e) {
            
            var productId = $(e.relatedTarget).data('productid');
            
            $.ajax({
                url : "products/productzipcode/" + productId, 
                type : 'GET',
                /* context: this, */
                dataType:"json",
                data : {'productId' : productId},
                success : function(data){
                    $('#resultZip').html("");
                    var json_obj = data.result; //parse JSON
                    if (data.success == true) {
                    console.log(data);
                        for (var i in json_obj) {
                            
                         /*    console.log(json_obj[i]["zipcode"]); */
                            $('#resultZip').append("<tr>"+ "<td>"+ json_obj[i]["name"] +"</td>" + "<td class='text-center'>"+ json_obj[i]["zipcode"] +"</td>" + "</tr>");
                        }   
                    }
                },
                fail: function(data) {
                   /*  console.log(data); */
                } 
            });
        });
    </script>
@endsection