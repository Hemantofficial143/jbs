@extends('layouts.app', ['activePage' => 'estimate', 'titlePage' => @trans('titles.estimate_items'),'title' => @trans('titles.estimate_items')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">@lang('titles.estimate_items')</h4>
            <p class="card-category">@lang('titles.estimate_items') List</p>
            <a type="button" name="button" class="pull-right btn btn-success" id="addEstimateItemModalBtn" >+</a>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    Sr
                  </th>
                  <th>
                    Item
                  </th>
                  <th>
                    Price
                  </th>
                  <th>
                    Maap
                  </th>
                  <th>
                    Description
                  </th>
                  <th>
                    Actions
                  </th>
                </thead>
                <tbody id="estimateItemData">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="addEstimateItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Estimate Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_estimate_item_form">
        <input type="hidden" id="estimate_id" name="estimate_id" value="{{ collect(request()->segments())->last() }}">
        <input type="hidden" id="id" name="id" value="0">
        <div class="form-group">
          <label for="name">Item Name</label>
          <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="price">Item Price</label>
          <input type="text" name="price" id="price" class="form-control">
        </div>
        <div class="form-group">
          <label for="maap">Maap</label>
          <select class="custom-select" name="maap" id="maap">
            <option value="">Select one</option>
            @foreach ($maap as $map)
              <option value="{{$map['id']}}" >{{ $map['name'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="description">Description ( optional )</label>
          <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
@push('js')
<script>

    function clearData(){
        $('#id').val(0);
        $('#name').val("");
        $('#price').val("");
        $('#description').val("");
        $('#maap').val("");
    }

    function loadEstimateItemData(){
    var id = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);      
      $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
        url : "{{route('estimate.items.get')}}",
        data : {id:id},
        type : "POST",
        success:function(res){
          if(res.IsSuccess){
            var html = "";
            var i = 1;
            if(res.Data.length > 0){
                res.Data.forEach(estimateItem => {
                  html += `<tr>`;
                  html += `<td>${i}</td>`;
                  html += `<td>${estimateItem.name}</td>`;
                  html += `<td>${estimateItem.price}</td>`;
                  html += `<td>${estimateItem.maap}</td>`;
                  html += `<td>${(estimateItem.description !== null)?estimateItem.description:'-'}</td>`;
                  html += `</tr>`;
                  i++;
                });
            }else{
                md.showNotification('top','right','danger',"No Data Found");
                html += `<tr><td colspan="6">No Data Dound</td></tr>`;
            }
            $('#estimateItemData').html(html);
          }else{    
              md.showNotification('top','right','danger',res.ErrorMessage);
          }
        }
      })
    }

    // function clearData(){
    //     $('#id').val(0);
    //     $('#name').val("");
    //     $('#mobile').val("");
    //     $('#address').val("");
    // }

    // function updateEstimate(id){
    //   $.ajax({
    //       headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //       },
    //       data : "id="+id,
    //       url: "{{ route('estimate.get.one') }}",
    //       type: "POST",
    //       cache:false,
    //       success:function(res){
    //         if(res.IsSuccess){
    //             $('#id').val(res.Data.id);
    //             $('#name').val(res.Data.name);
    //             $('#mobile').val(res.Data.mobile);
    //             $('#address').val(res.Data.address);
    //             $('#addEstimateModal').modal('show');
    //         }else{
    //           md.showNotification('top','right','danger',res.ErrorMessage);
    //         }
    //       }
    //   });
    // }

    // function deleteEstimate(id){
    //   $.ajax({
    //         headers: {
    //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         data : "id="+id,
    //         url: "{{ route('estimate.delete') }}",
    //         type: "POST",
    //         cache:false,
    //         success:function(res){
    //           if(res.IsSuccess){
    //             md.showNotification('top','right','danger',res.SuccessMessage);  
    //             loadEstimateData();
    //           }else{
    //             md.showNotification('top','right','danger',res.ErrorMessage);
    //           }
    //         }
    //     })
    // }

    $(function(){
        
      // load Data with AJAX
      loadEstimateItemData();


      // add new estimate
      $('#addEstimateItemModalBtn').on('click',function(){
        clearData();
        $('#addEstimateItemModal').modal();
      });

    
      // update estimate model
      
      

      //add estimate item modal method start
      $('#add_estimate_item_form').validate({
          rules: {
            name: "required",
            price: "required",
            maap : "required",
          },
          messages: {
            name: "Please enter Item name",
            price: "Please Enter Item Price ",
            maap : "Please Select Item Maap",
          },
          submitHandler: function(form,event) {
            event.preventDefault();
            var formData = $('#add_estimate_item_form').serialize(); 
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data : formData,
              url: "{{ route('estimate.item.store') }}",
              type: "POST",
              cache:false,
              success:function(res){
                if(res.IsSuccess){
                  $('#addEstimateItemModal').modal('hide');
                  md.showNotification('top','right','success',res.SuccessMessage);
                  loadEstimateItemData();
                }else{
                  md.showNotification('top','right','danger',res.ErrorMessage);
                }
              }
            });
          }
      })
      // add estimate modal method end
    });
  
</script>
@endpush

@endsection
