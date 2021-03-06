@extends('layouts.template1')
@section('content')

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

  <div class="page-wrapper">
      <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Data Foto Kegiatan</h4> 
                  <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <a class="btn btn-success" data-bs-toggle="modal" href="javascript:void(0)" data-bs-target="#addKegiatanModal">
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="green" />
                                    <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="black" />
                                    <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="black" />
                                    </svg>
                                </span> 
                            Tambah Data</a>
                        </ol>
                    </nav>
                  </div>           
            </div>
        </div>
      </div>
      <div class="container-fluid">
          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-body">
                          <div class="table-responsive">
                            <div id="show_all_kegiatan">
                              <h1 class="text-center text-secondary my-5">Loading...</h1>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!--  add modal start  -->
  <div class="modal fade" id="addKegiatanModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Foto Kegiatan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" id="add_kegiatan_form" enctype="multipart/form-data">
          @csrf
          <div class="modal-body p-4 bg-light">
            <div class="my-2">
              <label for="title">Title</label>
              <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
            </div>
            <div class="my-2">
              <label for="description">Description</label>
              <input type="text" name="description" class="form-control" placeholder="Description" required>
            </div>
            <div class="my-2">
              <label for="image">Upload Image</label>
              <input type="file" name="image" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="add_kegiatan_btn" class="btn btn-primary">Tambah Kegiatan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- add modal end -->

  <!-- edit modal start -->
  <div class="modal fade" id="editKegiatanModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Foto Kegiatan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" id="edit_kegiatan_form" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="kegiatan_id" id="kegiatan_id">
          <input type="hidden" name="kegiatan_image" id="kegiatan_image">
          <div class="modal-body p-4 bg-light">
            <div class="my-2">
              <label for="title">Title</label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" required>
            </div>
            <div class="my-2">
              <label for="description">Description</label>
              <input type="text" name="description" id="description" class="form-control" placeholder="Description" required>
            </div>
            <div class="my-2">
              <label for="image">Upload Image</label>
              <input type="file" name="image" class="form-control">
            </div>
            <div class="mt-2" id="image">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="edit_kegiatan_btn" class="btn btn-success">Update Foto Kegiatan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- edit modal end -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">
    $(function() {

      // add new kegiatan ajax request
      $("#add_kegiatan_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_kegiatan_btn").text('Adding...');
        $.ajax({
          url: '{{ route('kegiatan-store') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Added Successfully!',
                'success'
              )
              fetchAllKegiatan();
            }
            $("#add_kegiatan_btn").text('Tambah');
            $("#add_kegiatan_form")[0].reset();
            $("#addKegiatanModal").modal('hide');
          }
        });
      });

      // edit kegiatan ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('kegiatan-edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#title").val(response.title);
            $("#description").val(response.description);
            $("#image").html(
              `<img src="storage/images/${response.image}" width="200" class="img-fluid img-thumbnail">`);
            $("#kegiatan_id").val(response.id);
            $("#kegiatan_image").val(response.image);
          }
        });
      });

      // update kegiatan ajax request
      $("#edit_kegiatan_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_kegiatan_btn").text('Updating...');
        $.ajax({
          url: '{{ route('kegiatan-update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Updated Successfully!',
                'success'
              )
              fetchAllKegiatan();
            }
            $("#edit_kegiatan_btn").text('Update Kegiatan');
            $("#edit_kegiatan_form")[0].reset();
            $("#editKegiatanModal").modal('hide');
          }
        });
      });

      // delete ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('kegiatan-delete') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllKegiatan();
              }
            });
          }
        })
      });

      // fetch all kegiatan ajax request
      fetchAllKegiatan();

      function fetchAllKegiatan() {
        $.ajax({
          url: '{{ route('kegiatan-fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_kegiatan").html(response);
            $("table").DataTable({
              order: [0, 'asc']
            });
          }
        });
      }
    });
  </script>
@endsection