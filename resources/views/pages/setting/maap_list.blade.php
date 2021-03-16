@extends('layouts.app', ['activePage' => 'maap', 'titlePage' => __('Maap'),'title' => 'Maap'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Maap</h4>
            <p class="card-category">Maap List</p>
            <a type="button" name="button" class="pull-right btn btn-success" id="addMaapModalBtn" >+</a>
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
                    Code
                  </th>
                  <th>
                    Status
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

<div class="modal fade" id="addMaapModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Maap</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_maap_form">
          <input type="hidden" id="id" name="id" value="0">
        <div class="form-group">
          <label for="">Maap Name</label>
          <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Maap Code</label>
          <input type="text" name="code" id="code" class="form-control"  >
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
    function loadMaapData(){
        
      $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
        url : "{{route('setting.maap.get')}}",
        type : "POST",
        success:function(res){
          if(res.IsSuccess){
            var html = "";
            var i = 1;
            if(res.Data.length > 0){
                res.Data.forEach(maap => {
                  html += `<tr>`;
                  html += `<td>${i}</td>`;
                  html += `<td>${maap.name}</td>`;
                  html += `<td>${maap.code}</td>`;
                  html += `<td>${maap.status}</td>`;
                  html += `<td>   
                  <a type="button" class="p-2" style="cursor:pointer;" onClick="updateMaap($(this).data('id'))" data-id="${maap.id}" ><i class="material-icons">mode_edit</i></a>
                  <a type="button" class="p-2" style="cursor:pointer;" onClick="deleteMaap($(this).data('id'))" data-id="${maap.id}" ><i class="material-icons">delete_forever</i></a>
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
        $('#code').val("");
    }

    function updateMaap(id){
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data : "id="+id,
          url: "{{ route('maap.get.one') }}",
          type: "POST",
          cache:false,
          success:function(res){
            if(res.IsSuccess){
                $('#id').val(res.Data.id);
                $('#name').val(res.Data.name);
                $('#code').val(res.Data.code);
                $('#addMaapModal').modal('show');
            }else{
              md.showNotification('top','right','danger',res.ErrorMessage);
              $('#addMaapModal').modal('hide');
            }
          }
      });
    }

    function deleteMaap(id){
      $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : "id="+id,
            url: "{{ route('maap.delete') }}",
            type: "POST",
            cache:false,
            success:function(res){
              if(res.IsSuccess){
                md.showNotification('top','right','danger',res.SuccessMessage);  
                loadMaapData();
              }else{
                md.showNotification('top','right','danger',res.ErrorMessage);
              }
            }
        })
    }

    $(function(){
        
      // load Data with AJAX
      loadMaapData();


      // add new estimate
      $('#addMaapModalBtn').on('click',function(){
        clearData();
        $('#addMaapModal').modal();
      });

    
      // update estimate model
      
      

      //add estimate modal method start
      $('#add_maap_form').validate({
          rules: {
            name: "required",
            code: "required",
          },
          messages: {
            name: "Please enter maap name",
            code: "Please enter maap shortcode"
          },
          submitHandler: function(form,event) {
            event.preventDefault();
            var formData = $('#add_maap_form').serialize(); 
            console.log(formData);
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data : formData,
              url: "{{ route('maap.store') }}",
              type: "POST",
              cache:false,
              success:function(res){
                if(res.IsSuccess){
                  $('#addMaapModal').modal('hide');
                  md.showNotification('top','right','success',res.SuccessMessage);
                  loadMaapData();
                  clearData();
                }else{
                  md.showNotification('top','right','danger',res.ErrorMessage);
                  $('#addMaapModal').modal('hide');
                }
              }
            });
          }
      })
    });
  
</script>
@endpush

@endsection
