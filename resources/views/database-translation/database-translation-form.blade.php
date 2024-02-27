
<!-- <script src="{{ asset('vendor/core/plugins/admin-addon/js/database-translation.js') }}"></script>
 -->
<script>
$(() => {       
    var i=0;    
    $('#add_btn').click(function(){    
        i++;    
        $('#add_text').append('<tr id="row'+i+'" class="dynamic-added"><td><label class="m-2" for="text'+i+'">#'+ i + '</label><textarea type="text" id="text'+i+'" name="text[]" placeholder="Text" rows="3" class="form-control"></textarea></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-icon btn_remove mt-5"><i class="fa fa-trash-alt"></i></button></td></tr>');    
    });             

    $(document).on('click', '.btn_remove', function(){    
        var button_id = $(this).attr("id");     
        $('#row'+button_id+'').remove();    
    });    
});  
</script>

<div class="form-group">                  
    <label class="mb-3 fw-bold">{{ trans('plugins/admin-addon::database-translation.text') }}</label>
    <div class="table-responsive">    
        <table class="table table-bordered" id="add_text">    
            <tr> 
                <td><button type="button" name="add" id="add_btn" class="btn   add-new-optio">{{ trans('plugins/admin-addon::database-translation.add_text') }}</button></td>    
            </tr>    
        </table> 
    </div> 
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label"> {{ trans('plugins/admin-addon::database-translation.lang') }}</label>
    <div class="col-sm-10 mt-2">
        @foreach($languages as $language)
        <input type="checkbox" name="lang[]" value="{{$language->lang_locale}}"> {{$language->lang_name}} &nbsp;
        @endforeach
    </div>
</div>
                                    
                        
  
               


                        
                         
                    
