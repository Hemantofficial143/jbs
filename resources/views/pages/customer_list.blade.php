@extends('layouts.app', ['activePage' => 'customer', 'titlePage' => __('Customer'),'title' => 'Customer'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Customer</h4>
            <p class="card-category">Customer List</p>
            <a type="button" name="button" class="pull-right btn btn-success" id="addCustomerModalBtn" >+</a>
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
                    Email
                  </th>
                  <th>
                    Address
                  </th>
                  <th>
                    Action
                  </th>
                </thead>
                <tbody id="customerData">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_customer_form">
          <input type="hidden" id="id" name="id" value="0">
        <div class="form-group">
          <label for="name">Customer Name</label>
          <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="mobile">Customer Mobile</label>
          <input type="number" name="mobile" id="mobile" class="form-control"  >
        </div>
        <div class="form-group">
            <label for="email">Customer Email</label>
            <input type="text" name="email" id="email" class="form-control"  >
          </div>
        <div class="form-group">
          <label for="address">Customer Address</label>
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
    
    function loadCustomerData(){
      
      $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
        url : "{{route('customer.get')}}",
        type : "POST",
        success:function(res){
          if(res.IsSuccess){
            var html = "";
            var i = 1;
            if(res.Data.length > 0){
                res.Data.forEach(customer => {
                  html += `<tr>`;
                  html += `<td>${i}</td>`;
                  html += `<td>${customer.name}</td>`;
                  html += `<td>${customer.mobile}</td>`;
                  html += `<td>${(customer.email !== null)?customer.email:'-'}</td>`;
                  html += `<td>${customer.address}</td>`;
                  html += `<td>   
                  <a type="button" class="p-2" style="cursor:pointer;" href="/customer/bills/${customer.id}" data-id="${customer.id}" ><i class="material-icons">attach_money</i></a>
                  <a type="button" class="p-2" style="cursor:pointer;" onClick="updateCustomer($(this).data('id'))" data-id="${customer.id}" ><i class="material-icons">mode_edit</i></a>
                  <a type="button" class="p-2" style="cursor:pointer;" onClick="deleteCustomer($(this).data('id'))" data-id="${customer.id}" ><i class="material-icons">delete_forever</i></a>
                  </td>`;
                  html += `</tr>`;
                  i++;
                });
            }else{
              html += `<tr><td colspan="6">No Data Dound</td></tr>`;
            }
            $('#customerData').html(html);
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
        $('#email').val("");
        $('#address').val("");
    }

    function updateCustomer(id){
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data : "id="+id,
          url: "{{ route('customer.get.one') }}",
          type: "POST",
          cache:false,
          success:function(res){
            if(res.IsSuccess){
                $('#id').val(res.Data.id);
                $('#name').val(res.Data.name);
                $('#mobile').val(res.Data.mobile);
                $('#email').val(res.Data.mobile);
                $('#address').val(res.Data.address);
                $('#addCustomerModal').modal('show');
            }else{
              md.showNotification('top','right','danger',res.ErrorMessage);
            }
          }
      });
    }

    function deleteCustomer(id){
      $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : "id="+id,
            url: "{{ route('customer.delete') }}",
            type: "POST",
            cache:false,
            success:function(res){
              if(res.IsSuccess){
                md.showNotification('top','right','danger',res.SuccessMessage);  
                loadCustomerData();
              }else{
                md.showNotification('top','right','danger',res.ErrorMessage);
              }
            }
        })
    }

    $(function(){
      
      // load Data with AJAX
      loadCustomerData();


      // add new customer
      $('#addCustomerModalBtn').on('click',function(){
        clearData();
        $('#addCustomerModal').modal();
      });
      

      // add customer modal method start
      $('#add_customer_form').validate({
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
            var formData = $('#add_customer_form').serialize(); 
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data : formData,
              url: "{{ route('customer.store') }}",
              type: "POST",
              cache:false,
              success:function(res){
                if(res.IsSuccess){
                  $('#addCustomerModal').modal('hide');
                  md.showNotification('top','right','success',res.SuccessMessage);
                  loadCustomerData();
                }else{

                }
              }
            });
          }
      })
    });
  
</script>
@endpush

@endsection
