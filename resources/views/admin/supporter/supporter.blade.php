@extends('admin.app')
@section('content')

    <div class="page-heading">
        <h3>Sponsorlar</h3>
    </div>
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="form-group">
                        <p> Sponsor eklemek için aşağıdaki butonu kullanınız.</p>
                        <!-- Button trigger for login form modal -->
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#inlineForm">
                            Sponsor Ekle
                        </button>

                        <!--login form Modal -->
                        <div class="modal fade text-left" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel33">Sponsor</h4>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </div>
                                    <form id="supporter_create" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <label>Sponsor İsmi: </label>
                                            <div class="form-group">
                                                <input type="text" name="name" placeholder="Sponsor İsmi" class="form-control">
                                            </div>
                                            <label>Menü İsmi: </label>
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="img" id="img">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Kapat</span>
                                            </button>
                                            <button type="button" onclick="create_supporter()" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Kaydet</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                Menü Listesi
            </div>
            <div class="card-body" style="overflow: auto">
                <table class="table table-responsive" id="supporterTable" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sponsor İsmi</th>
                        <th>Sponsor Fotoğrafı</th>
                        <th>Seçenekler</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
@section('js')

    <script>
        let packageTable = $('#supporterTable').DataTable({
            order: [
                [1, 'ASC']
            ],
            processing: true,
            serverSide: true,
            ajax: '{!! route('fetchSupporter') !!}',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'imgDetail'},
                {data: 'detail'},
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.1/i18n/tr.json"
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function create_supporter(){
            Swal.fire({
                icon: "warning",
                title:"Emin misiniz?",
                html: "Sponsor eklemek istediğinize emin misiniz?",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Onayla",
                cancelButtonText: "İptal",
                cancelButtonColor: "#e30d0d"
            }).then((result)=>{
                if (result.isConfirmed){
                    let url = '{{route('createSupporter')}}';
                    let formData = new FormData(document.getElementById('supporter_create'));
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function (){
                            Swal.fire({
                                icon: "success",
                                title:"Başarılı",
                                showConfirmButton: true,
                                confirmButtonText: "Tamam"
                            });
                            packageTable.ajax.reload();
                        },
                        error: function (data){
                            Swal.fire({
                                icon: "error",
                                title:"Boş girdi bırakmayınız!",
                                html: "<div id=\"validation-errors\"></div>",
                                showConfirmButton: true,
                                confirmButtonText: "Tamam"
                            });
                            $.each(data.responseJSON.errors, function(key,value) {
                                $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div>');
                            });
                        }
                    });
                }
            });
        }

        function delete_supporter(id){
            Swal.fire({
                icon:'warning',
                title:'Emin Misiniz',
                text:'Bu Sponsoru Silmek İstediğinize Emin Misiniz',
                showConfirmButton:true,
                confirmButtonText:'Sil',
                confirmButtonColor:'red',
                showCancelButton:'true',
                cancelButtonText:'İptal',
            }).then((response)=>{
                if (response.isConfirmed){
                    $.ajax({
                        url:'{{route('deleteSupporter')}}',
                        type:'POST',
                        data: {
                            id:id,
                            "_token":'{{csrf_token()}}'
                        },
                        success:()=>{
                            packageTable.ajax.reload();
                            Swal.fire({
                                title:'Başarılı',
                                icon:'success',
                                showConfirmButton:true,
                                confirmButtonText:'Tamam',
                                showCancelButton:false
                            })
                        },
                        error:()=>{
                            Swal.fire({
                                icon:'error',
                                title:'Hata',
                                text:'Silme İşlemiBaşarısız',
                                showConfirmButton:true,
                                confirmButtonText:'Tamam',
                                showCancelButton:false
                            })
                        }
                    })
                }
            })
        }

        function openImg(e){
            Swal.fire({
                html: '<img style="object-fit: cover;max-width: 100%;max-height: 100%"   src="'+e.src+'" />'
            })
        }
    </script>

@endsection
