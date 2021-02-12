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
            <a type="button" name="button" class="pull-right btn btn-success" data-toggle="modal" data-target="#addEstimateModal">+</a>
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
                <tbody>
                  @if(isset($data) && count($data) > 0)
                  @php
                    $i = 1;    
                  @endphp
                    @foreach ($data as $estimate)
                        <tr>
                          <td>{{ $i }}</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        @php
                          $i++;    
                        @endphp
                    @endforeach
                  @else
                  <tr>
                    <td colspan="6">No Data Found</td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
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
      </div>
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
        <div class="form-group">
          <label for="">Customer Name</label>
          <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Customer Mobile</label>
          <input type="text" name="mobile" id="mobile" class="form-control"  >
        </div>
        <div class="form-group">
          <label for="">Customer Address</label>
          <textarea class="form-control" name="address" id="address" rows="3"></textarea>
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
    $(function(){
      


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
                }else{

                }
              }
            });
          }
      })
      // add estimate modal method end
    })
</script>
@endpush

@endsection
