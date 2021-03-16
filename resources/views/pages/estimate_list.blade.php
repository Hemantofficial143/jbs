@extends('layouts.app', ['activePage' => 'estimate', 'titlePage' => __('Estimate'),'title' => 'Estimate'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Estimate</h4>
            <p class="card-category">Estimate List</p>
            <a type="button" name="button" class="pull-right btn btn-success" id="addEstimateModalBtn" >+</a>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    Sr
                  </th>
                  <th>
                    Name
                  </th>
                  <th>
                    Mobile
                  </th>
                  <th>
                    Address
                  </th>
                  <th>
                    Email
                  </th>
                  <th>
                    Action
                  </th>
                </thead>
                <tbody id="estimateData">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      {{-- <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0"> Table on Plain Background</h4>
            <p class="card-category"> Here is a subtitle for this table</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <th>
                    ID
                  </th>
                  <th>
                    Name
                  </th>
                  <th>
                    Country
                  </th>
                  <th>
                    City
                  </th>
                  <th>
                    Salary
                  </th>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      1
                    </td>
                    <td>
                      Dakota Rice
                    </td>
                    <td>
                      Niger
                    </td>
                    <td>
                      Oud-Turnhout
                    </td>
                    <td>
                      $36,738
                    </td>
                  </tr>
                  <tr>
                    <td>
                      2
                    </td>
                    <td>
                      Minerva Hooper
                    </td>
                    <td>
                      Curaçao
                    </td>
                    <td>
                      Sinaai-Waas
                    </td>
                    <td>
                      $23,789
                    </td>
                  </tr>
                  <tr>
                    <td>
                      3
                    </td>
                    <td>
                      Sage Rodriguez
                    </td>
                    <td>
                      Netherlands
                    </td>
                    <td>
                      Baileux
                    </td>
                    <td>
                      $56,142
                    </td>
                  </tr>
                  <tr>
                    <td>
                      4
                    </td>
                    <td>
                      Philip Chaney
                    </td>
                    <td>
                      Korea, South
                    </td>
                    <td>
                      Overland Park
                    </td>
                    <td>
                      $38,735
                    </td>
                  </tr>
                  <tr>
                    <td>
                      5
                    </td>
                    <td>
                      Doris Greene
                    </td>
                    <td>
                      Malawi
                    </td>
                    <td>
                      Feldkirchen in Kärnten
                    </td>
                    <td>
                      $63,542
                    </td>
                  </tr>
                  <tr>
                    <td>
                      6
                    </td>
                    <td>
                      Mason Porter
                    </td>
                    <td>
                      Chile
                    </td>
                    <td>
                      Gloucester
                    </td>
                    <td>
                      $78,615
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div> --}}
    </div>
  </div>
</div>

<div class="modal fade" id="addEstimateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Estimate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_estimate_form">
          <input type="hidden" id="id" name="id" value="0">
        <div class="form-group">
          <label for="name">Customer Name</label>
          <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="mobile">Customer Mobile</label>
          <input type="text" name="mobile" id="mobile" class="form-control"  >
        </div>
        <div class="form-group">
          <label for="address">Customer Address</label>
          <textarea class="form-control" name="address" id="address" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label for="">Estimate Note ( Seprate by Comma ',' )</label>
          <textarea class="form-control" name="note" id="note" rows="3"></textarea>
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
    function loadEstimateData(){
      
      $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
        url : "{{route('estimate.get')}}",
        type : "POST",
        success:function(res){
          if(res.IsSuccess){
            var html = "";
            var i = 1;
            if(res.Data.length > 0){
                res.Data.forEach(estimate => {
                  html += `<tr>`;
                  html += `<td>${i}</td>`;
                  html += `<td>${estimate.name}</td>`;
                  html += `<td>${estimate.mobile}</td>`;
                  html += `<td>${estimate.address}</td>`;
                  html += `<td>${(estimate.email !== null)?estimate.email:'-'}</td>`;
                  html += `<td>   
                  <a type="button" class="p-2" style="cursor:pointer;" href="estimate/export/${estimate.id}" data-id="${estimate.id}"><i class="material-icons">picture_as_pdf</i></a>
                  <a type="button" class="p-2" style="cursor:pointer;" href="/estimate/item/${estimate.id}"  ><i class="material-icons">keyboard_arrow_right</i></a>
                  <a type="button" class="p-2" style="cursor:pointer;" onClick="updateEstimate($(this).data('id'))" data-id="${estimate.id}" ><i class="material-icons">mode_edit</i></a>
                  <a type="button" class="p-2" style="cursor:pointer;" onClick="deleteEstimate($(this).data('id'))" data-id="${estimate.id}" ><i class="material-icons">delete_forever</i></a>
                  </td>`;
                  html += `</tr>`;
                  i++;
                });
            }else{
              html += `<tr><td colspan="6">No Data Dound</td></tr>`;
            }
            $('#estimateData').html(html);
          }else{    
              md.showNotification('top','right','danger',res.ErrorMessage);
          }
        }
      })
    }

    function clearData(){
        $('#id').val(0);
        $('#name').val("");
        $('#mobile').val("");
        $('#address').val("");
    }

    function updateEstimate(id){
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data : "id="+id,
          url: "{{ route('estimate.get.one') }}",
          type: "POST",
          cache:false,
          success:function(res){
            if(res.IsSuccess){
                $('#id').val(res.Data.id);
                $('#name').val(res.Data.name);
                $('#mobile').val(res.Data.mobile);
                $('#address').val(res.Data.address);
                $('#note').val(res.Data.note);
                $('#addEstimateModal').modal('show');
            }else{
              md.showNotification('top','right','danger',res.ErrorMessage);
            }
          }
      });
    }

    function deleteEstimate(id){
      $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : "id="+id,
            url: "{{ route('estimate.delete') }}",
            type: "POST",
            cache:false,
            success:function(res){
              if(res.IsSuccess){
                md.showNotification('top','right','danger',res.SuccessMessage);  
                loadEstimateData();
              }else{
                md.showNotification('top','right','danger',res.ErrorMessage);
              }
            }
        })
    }

    $(function(){
      
      // load Data with AJAX
      loadEstimateData();


      // add new estimate
      $('#addEstimateModalBtn').on('click',function(){
        clearData();
        $('#addEstimateModal').modal();
      });

    
      // update estimate model
      
      

      // add estimate modal method start
      $('#add_estimate_form').validate({
          rules: {
            name: "required",
            mobile: {
              required :true,
              number: true,
		          minlength: 10,
		          maxlength: 10 
            },
            address : "required",
          },
          messages: {
            name: "Please enter customer name",
            mobile: {
              required : "Please enter customer mobile",
              number : "Number Only"
            },
            address:  "Please enter customer address",
          },
          submitHandler: function(form,event) {
            event.preventDefault();
            var formData = $('#add_estimate_form').serialize(); 
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data : formData,
              url: "{{ route('estimate.store') }}",
              type: "POST",
              cache:false,
              success:function(res){
                if(res.IsSuccess){
                  $('#addEstimateModal').modal('hide');
                  md.showNotification('top','right','success',res.SuccessMessage);
                  loadEstimateData();
                }else{

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
