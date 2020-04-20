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
                                            <input type="text" name="description" id="task-name" value="<?= $products->name?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="task-name" class="col-sm-12 control-label">Product Status</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="status">
                                                <option value="1" <?php if($products->status == 1) {echo "selected";} ?>>Active</option>
                                                <option value="0"<?php if($products->status == 0) {echo "selected";} ?>>Deactive</option>
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
                                            <select class="form-control" name="state_id" id="states">
                                                <option value=""><?= "Select a State" ?></option>
                                                <?php foreach ($states as $key => $state) { ?>
                                                    <?php $selected = $state->id == $products->state_id ? $selected = "selected": $selected=""; ?> 
                                                    <option value="<?= $state->id?>" <?= $selected ?>><?= $state->description?></option>   
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
                                        <div class="row" id="zipcodes">
                                            <?php foreach ($zipmaster as $key => $zip) { ?>
                                               
                                                    <div class='control-group col-sm-2 checkbox text-center'>
                                                       
                                                        <label class='checkbox-inline'><input type='checkbox' name='productzip[]' value=""> <?= $zip->zip ?></label>
                                                    </div>
                                                
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-plus"></i> Register
                                    </button>
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
                                                        + "<label class='checkbox-inline'><input type='checkbox' name='productzip[]' checked value="+ json_obj[i]["zip"] + "> "+ json_obj[i]["zip"] +"</label>"
                                                      + "</div>"); 
                            }
                        } 
                    },
                    fail: function(data) {
                        console.log(data);
                    } 
                });
            });
        });





        
    </script>
@endsection
