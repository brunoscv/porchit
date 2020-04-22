@extends('layouts.app', ['title' => __('Products')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is a product page.'),
        'class' => 'col-lg-12'
    ])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-0">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Create Products') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- New Products Form -->
                        <form action="/products/save" method="POST" class="form-horizontal">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="task-name" class="col-sm-12 control-label">Product name</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="description" id="task-name" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="task-name" class="col-sm-12 control-label">Product Status</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="status" required>
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="task-name" class="col-sm-12 control-label">State</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="state_id" id="states" required>
                                                <option value=""><?= "Select a State" ?></option>
                                                <?php foreach ($states as $key => $state) { ?>
                                                    <option value="<?= $state->id?>"><?= $state->description?></option>   
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="task-name" class="col-sm-12 control-label">Zip Codes</label>
                                        <p class='col-12 ml-4'><input type='checkbox' id='select_all' /> Select / Unselect All</p>
                                        <div class="row" id="zipcodes">
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-plus"></i> Register
                                    </button>
                                    <a href="{{ route('products') }}" class="btn btn-default">
                                        <i class="fa fa-block"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        @include('layouts.footers.auth')
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('body').on('change', '#states', function() {
                var stateId = $("#states").val();
                $('#select_all').prop('checked',false);
                $.ajax({
                    url : "zipcode/" + stateId, 
                    type : 'GET',
                    /* context: this, */
                    dataType:"json",
                    data : {'stateId' : stateId},
                    success : function(data){
                        var json_obj = data.result;
                        $("#zipcodes").html("");
                        if (data.success == true) {
                            for (var i in json_obj) {
                                $("#zipcodes").append("<div class='control-group col-sm-2 checkbox text-center'>"
                                                        + "<label class='checkbox-inline'><input type='checkbox' name='productzip[]' value="+ json_obj[i]["zip"] + " class='checkbox'> "+ json_obj[i]["zip"] +"</label>"
                                                      + "</div>"); 
                            }
                        } 
                    },
                    fail: function(data) {
                        console.log(data);
                    } 
                });
            });

            $('#select_all').change(function() {
                var checkboxes = $(this).closest('form').find(':checkbox');
                checkboxes.prop('checked', $(this).is(':checked'));
            });
    
            $('.checkbox').on('click',function(){
                if($('.checkbox:checked').length == $('.checkbox').length){
                    $('#select_all').prop('checked',true);
                }else{
                    $('#select_all').prop('checked',false);
                }
            });
        });





        
    </script>
@endsection
