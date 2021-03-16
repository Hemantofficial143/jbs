@extends('layouts.app', ['activePage' => 'bill', 'titlePage' => __('Bills'),'title' => 'Bills'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">{{ ($data['name']) }} Bills</h4>
            <p class="card-category"> {{ ($data['name']) }} Bills List</p>
            <a type="button" name="button" class="pull-right btn btn-success" id="createBillBtn" >+</a>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    Sr
                  </th>
                  <th>
                    Invoice Date
                  </th>
                  <th>
                    Description
                  </th>
                  <th>
                    Action
                  </th>
                </thead>
                <tbody id="customerBillData">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updateCustomerBillModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Bill</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="update_customer_bill_form">
          <input type="hidden" id="id" name="id" value="0">
          <div class="form-group">
            <label for="notes">Bill Description ( seprated by "," ) </label>
            <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
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
      $('#createBillBtn').on('click',function(){
        Swal.fire({
          title: 'create new bill?',
          text: "You won't be able to revert this!",
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, create it!'
        }).then((result) => {
          if (result.value) {
            var id = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);      
            
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              method : 'POST',
              url : '{{ route("bill.store") }}',
              data :{customer_id:id},
              success:function(res){
                if(res.IsSuccess){
                  md.showNotification('top','right','success',res.SuccessMessage);
                  loadCustomerBillData();
                }else{
                  md.showNotification('top','right','danger',res.ErrorMessage);
                }
              }
            })
          }
        })
      });
    })
    function loadCustomerBillData(){
      var id = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);
      $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
        url : "{{route('bill.get')}}",
        data : {customer_id:id},
        method : "POST",
        success:function(res){
          if(res.IsSuccess){
            var html = "";
            var i = 1;
            if(res.Data.length > 0){
              
                res.Data.forEach(bill => {
                  html += `<tr>`;
                  html += `<td>${i}</td>`;
                  html += `<td>${bill.created_at}</td>`;
                  html += `<td>${(bill.notes)?bill.notes:'-'}</td>`;
                  html += `<td>   
                  <a type="button" class="p-2" style="cursor:pointer;" href="/customer/bills/${bill.id}" data-id="${bill.id}" ><i class="material-icons">nat</i></a>  
                  <a type="button" class="p-2" style="cursor:pointer;" onClick="updateCustomerBill($(this).data('id'))" data-id="${bill.id}" ><i class="material-icons">mode_edit</i></a>
                  <a type="button" class="p-2" style="cursor:pointer;" onClick="deleteCustomerBill($(this).data('id'))" data-id="${bill.id}" ><i class="material-icons">delete_forever</i></a>
                  </td>`;
                  html += `</tr>`;
                  i++;
                });
            }else{
              html += `<tr><td colspan="6">No Data Dound</td></tr>`;
            }
            $('#customerBillData').html(html);
          }else{    
              md.showNotification('top','right','danger',res.ErrorMessage);
          }
        }
      })
    }

    function clearData(){
        $('#id').val(0);
        $('#notes').val("");
    }

    function updateCustomerBill(id){
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data : {id:id},
          url: "{{ route('bill.get.one') }}",
          type: "POST",
          cache:false,
          success:function(res){
            if(res.IsSuccess){
                $('#id').val(res.Data.id);
                $('#notes').val(res.Data.notes);
                $('#updateCustomerBillModal').modal('show');
            }else{
              md.showNotification('top','right','danger',res.ErrorMessage);
            }
          }
      });
    }

    function deleteCustomerBill(id){
      var bill_id = id;
      var customer_id = window.location.href.substr(window.location.href.lastIndexOf('/') + 1)
      $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                    bill_id:bill_id,
                    customer_id:customer_id
                  },
            url: "{{ route('bill.delete') }}",
            type: "POST",
            cache:false,
            success:function(res){
              if(res.IsSuccess){
                md.showNotification('top','right','danger',res.SuccessMessage);  
                loadCustomerBillData();
              }else{
                md.showNotification('top','right','danger',res.ErrorMessage);
              }
            }
        })
    }

    $(function(){

    loadCustomerBillData();

      // add new customer
    //   $('#addCustomerModalBtn').on('click',function(){
    //     clearData();
    //     $('#addCustomerModal').modal();
    //   });
    
      $('#update_customer_bill_form').validate({
          submitHandler: function(form,event) {
            event.preventDefault();
            var formData = $('#update_customer_bill_form').serialize(); 
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data : formData,
              url: "{{ route('bill.update') }}",
              type: "POST",
              cache:false,
              success:function(res){
                if(res.IsSuccess){
                  $('#updateCustomerBillModal').modal('hide');
                  md.showNotification('top','right','success',res.SuccessMessage);
                  clearData();
                  loadCustomerBillData();
                }
              }
            });
          }
      })
    });
  
</script>
@endpush

@endsection
