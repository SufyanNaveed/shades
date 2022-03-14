<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo $this->lang->line('Modify Batch') ?></h5>
            <hr>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>

        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
            <form method="post" id="data_form">

                <input type="hidden" name="id" value="<?php echo $batch['id'] ?>">
                <input type="hidden" name="pid" value="<?php echo $batch['pid'] ?>">
                <!-- <input type="hidden" name="act" value="addBatch"> -->

                <div class="form-group row">
                    <div class="col-sm-4"><label class="col-form-label" for="name"><?php echo $this->lang->line('Batch Name') ?>*</label>
                        <input type="text" placeholder="Batch Name" class="form-control margin-bottom required" name="name" value="<?php echo $batch['name'] ?>">
                    </div>
                    <div class="col-sm-4"><label class="col-form-label" for="code"><?php echo $this->lang->line('Code') ?></label>
                        <input type="text" placeholder="Code" class="form-control" name="code" value="<?php echo $batch['code'] ?>">
                    </div>
                    <div class="col-sm-4"><label class="col-form-label" for="qty"><?php echo $this->lang->line('Price') ?>*</label>
                        <input type="text" placeholder="Price" onchange="calculatePrice()" class="form-control margin-bottom required" id="price" name="price" value="<?php echo $batch['price'] ?>">
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-sm-6"><label class="col-form-label" for="qty"><?php echo $this->lang->line('Quantity') ?>*</label>
                        <input type="text" placeholder="Quantity" onchange="calculatePrice()" id="qty" class="form-control margin-bottom required" name="qty" value="<?php echo $batch['qty'] ?>">
                    </div>
                    <div class="col-sm-6"><label class="col-form-label" for="code"><?php echo $this->lang->line('Description') ?></label>
                        <input type="text" placeholder="Description" class="form-control" name="des" value="<?php echo $batch['des'] ?>">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="dead" name="dead" value="<?php echo $batch['dead'] ? 1 : 0 ?>" <?php echo ($batch['dead']) ? "checked" : "" ?>>
                            <label class="form-check-label" for="exampleCheck1"><?php echo $this->lang->line('Manage Dead Record') ?></label>
                        </div>
                    </div>

                    <div class="col-sm-3" id="dead_div" style="display:<?php echo ($batch['dead']) ? "" : "none" ?>">
                    <label class="col-form-label" for="product_qty_alert"><?php echo $this->lang->line('Enter Dead Item Quantity') ?></label>

                        <input type="text" placeholder="<?php echo $this->lang->line('Enter Dead Item Quantity') ?>"
                               class="form-control margin-bottom" name="dead_item" value="<?php echo $batch['dead_items'] ?>" onkeypress="return isNumber(event)">
                    </div>
                </div> 
                <hr>

                <!-- <hr>
                 <div class="form-group row">
                    <div class="col-sm-4"><label class="col-form-label" for="product_name"><?php echo $this->lang->line('Product Name') ?>*</label>
                        <input type="text" placeholder="Product Name" class="form-control margin-bottom required" name="product_name">
                    </div>
                    <div class="col-sm-4">
                    <label class="col-form-label" for="product_code"><?php echo $this->lang->line('Product Code') ?></label>
                        <input type="text" placeholder="Product Code" class="form-control" name="product_code">
                    </div>
                    <div class="col-sm-4">
                    <label class="col-form-label" for="product_price"><?php echo $this->lang->line('Product Retail Price') ?></label>
                        <div class="input-group"><span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="product_price" id="product_price" class="form-control required" placeholder="0.00" aria-describedby="sizing-addon" onkeypress="return isNumber(event)" ><span id="total" class="input-group-addon"></span>
                        </div>
                    </div>
                </div> -->


                <!-- <div class="form-group row">

                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="product_cat"><?php //echo $this->lang->line('Product Category') ?>
                            *</label>
                        <select name="product_cat" id="product_cat" class="form-control">
                            <?php
                            // foreach ($cat as $row) {
                            //     $cid = $row['id'];
                            //     $title = $row['title'];
                            //     echo "<option value='$cid'>$title</option>";
                            // }
                            ?>
                        </select>
                    </div>


                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="sub_cat"><?php //echo $this->lang->line('Sub') ?><?php //echo $this->lang->line('Category') ?></label>
                        <select id="sub_cat" name="sub_cat" class="form-control required select-box">

                        </select>


                    </div>
                </div> -->

                <!-- <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php //echo $this->lang->line('Daily Feed') . $this->lang->line('Price') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php //echo $this->config->item('currency') ?></span>
                            <input type="number" name="daily_feed" id="daily_feed" class="form-control"
                                   placeholder="0.00" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div> -->

                <!-- <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('Product Retail Price') ?>*</label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="product_price" id="product_price" class="form-control required"
                                   placeholder="0.00" aria-describedby="sizing-addon"
                                   onkeypress="return isNumber(event)"
                                   onblur="calculateTotal()"><span id="total"
                                    class="input-group-addon"></span>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="form-group row">
                    <div class="col-sm-6">
                    <label class="col-form-label" for="product_qty"><?php echo $this->lang->line('Stock Units') ?></label>

                        <input type="text" placeholder="<?php echo $this->lang->line('Stock Units') ?>*"
                               class="form-control margin-bottom required" name="product_qty"
                               onkeypress="return isNumber(event)"></div>

                    <div class="col-sm-6">
                    <label class="col-form-label" for="product_qty_alert"><?php echo $this->lang->line('Alert Quantity') ?></label>

                        <input type="text" placeholder="<?php echo $this->lang->line('Alert Quantity') ?>"
                               class="form-control margin-bottom" name="product_qty_alert"
                               onkeypress="return isNumber(event)">
                    </div>
                </div> 
                <hr> -->
                <!-- <div class="form-group row"><label
                            class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                    <div class="col-sm-6">
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files --
                        <table id="files" class="files"></table>
                        <br>
                        <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                            <!-- The file input field used as target for the file upload widget --
        <input id="fileupload" type="file" name="files[]">
    </span>
                        <br>
                        <pre>Allowed: gif, jpeg, png (Use light small weight images for fast loading - 200x200)</pre>
                        <br>
                        <!-- The global progress bar --

                    </div>
                </div> -->
                <div class="form-group row">

                    <!-- <label class="col-sm-2 col-form-label"></label> -->

                    <div class="col-sm-12">
                        <input type="submit" id="submit-data" class="btn btn-lg btn-blue margin-bottom"
                               value="<?php echo $this->lang->line('Edit Batch') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="services/editBatch" id="action-url">
                    </div>
                </div>
<!--                <button class="btn btn-pink add_serial btn-sm m-1">   --><?php //echo $this->lang->line('add_serial') ?><!--</button><div id="added_product"></div>-->

            </form>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>products/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img = 'default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + file.name + '"></td></tr>');
                    img = file.name;
                });

                $('#image').val(img);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });

    $(document).on('click', "#dead", function (e) {
        // alert($(this).is(':checked'))
        if($(this).is(':checked')){
            $(this).val(1);
            $("#dead_div").show();  // checked
        } else {
            $(this).val(0);
            $("#dead_div").hide();  // unchecked
        }
    });
    function calculateTotal(){
        // alert(('#daily_feed').val())
        const total = parseFloat(parseFloat($('#daily_feed').val()) + parseFloat($('#product_price').val()));
        $('#total').html(total);
        // alert(total)
    }
    function calculatePrice(){
        // alert(('#daily_feed').val())
        if($('#price').val() != "" && $('#qty').val() != ""){
            const total = parseFloat(parseFloat($('#price').val())/parseFloat($('#qty').val()));
            $('#product_price').val(total);
        }
        // alert(total)
    }


    $(document).on('click', ".tr_clone_add", function (e) {
        e.preventDefault();
        var n_row = $('#v_var').find('tbody').find("tr:last").clone();

        $('#v_var').find('tbody').find("tr:last").after(n_row);

    });
    $(document).on('click', ".tr_clone_add_w", function (e) {
        e.preventDefault();
        var n_row = $('#w_var').find('tbody').find("tr:last").clone();

        $('#w_var').find('tbody').find("tr:last").after(n_row);

    });

    $(document).on('click', ".tr_delete", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });


    $("#sub_cat").select2();
    $("#product_cat").on('change', function () {
        $("#sub_cat").val('').trigger('change');
        var tips = $('#product_cat').val();
        $("#sub_cat").select2({

            ajax: {
                url: baseurl + 'products/sub_cat?id=' + tips,
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (product) {
                    return {
                        product: product,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.title,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
    });
    $(document).on('click', ".v_delete_serial", function (e) {
            e.preventDefault();
            $(this).closest('div .serial').remove();
        });
                    $(document).on('click', ".add_serial", function (e) {
            e.preventDefault();

            $('#added_product').append('<div class="form-group serial"><label for="field_s" class="col-lg-2 control-label"><?= $this->lang->line('serial') ?></label><div class="col-lg-10"><input class="form-control box-size" placeholder="<?= $this->lang->line('serial') ?>" name="product_serial[]" type="text"  value=""></div><button class="btn-sm btn-purple v_delete_serial m-1 align-content-end"><i class="fa fa-trash"></i> </button></div>');

        });
</script>
