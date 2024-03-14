@extends('admin.app')
@section('content')

    <input type="hidden" id="getUrl" value="{{route('getSubMenu')}}">
    <input type="hidden" id="updateUrl" value="{{route('updateSubMenu')}}">

    <!-- SubMenu Update Modal -->

    <div class="modal fade text-left" id="subMenuUpdate" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Menü</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form id="updateSubMenu">
                    @csrf
                    <input type="hidden" id="id_update" name="id">
                    <input type="hidden" id="id_menu" name="menu_id" value="{{$menu -> id}}">
                    <div class="modal-body">
                        <label>Menü İsmi: </label>
                        <div class="form-group">
                            <input type="text" name="name" id="updateName" placeholder="Menü İsmi" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Kapat</span>
                        </button>
                        <button type="button" onclick="updateSubMenu()" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Kaydet</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                Alt Menü Listesi
            </div>
            <div class="card-body" style="overflow: auto">
                <table class="table table-responsive" id="subMenuTable" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alt Menü</th>
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
        let packageTable = $('#subMenuTable').DataTable({
            order: [
                [1, 'ASC']
            ],
            processing: true,
            serverSide: true,
            ajax: '{!! route('fetchSubMenu', $menu -> id) !!}',
            columns: [
                {data: 'id'},
                {data: 'name'},
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

        function delete_sm(id){
            Swal.fire({
                icon:'warning',
                title:'Emin Misiniz',
                text:'Bu Menüyü Silmek İstediğinize Emin Misiniz',
                showConfirmButton:true,
                confirmButtonText:'Sil',
                confirmButtonColor:'red',
                showCancelButton:'true',
                cancelButtonText:'İptal',
            }).then((response)=>{
                if (response.isConfirmed){
                    $.ajax({
                        url:'{{route('deleteSubMenu')}}',
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

        {{--function update_submenu(){--}}
        {{--    let name = document.getElementById('updateName').value;--}}
        {{--    $.ajax({--}}
        {{--        url:'{{route('updateSubMenu')}}',--}}
        {{--        type:'POST',--}}
        {{--        data: {--}}
        {{--            id:document.getElementById('submenuID').value,--}}
        {{--            name:name,--}}
        {{--            '_token':'{{csrf_token()}}'--}}
        {{--        },--}}
        {{--        success:()=>{--}}
        {{--            $('#subMenuUpdate').modal('hide')--}}
        {{--            packageTable.ajax.reload()--}}
        {{--            Swal.fire({--}}
        {{--                title:'Başarılı',--}}
        {{--                icon:'success',--}}
        {{--                showConfirmButton:true,--}}
        {{--                confirmButtonText:'Tamam',--}}
        {{--                showCancelButton:false--}}
        {{--            })--}}
        {{--            document.getElementById('updateName').value = '';--}}
        {{--        },--}}
        {{--        error:()=>{--}}
        {{--            Swal.fire({--}}
        {{--                icon:'error',--}}
        {{--                title:'Hata',--}}
        {{--                text:'Lütfen Bütün Alanları Doldurduğunuza Emin Olunuz',--}}
        {{--                showConfirmButton:true,--}}
        {{--                confirmButtonText:'Tamam',--}}
        {{--                showCancelButton:false--}}
        {{--            })--}}
        {{--        }--}}
        {{--    })--}}
        {{--}--}}

        {{--function openSubMenuUpdate(id){--}}
        {{--    document.getElementById('submenuID').value = id;--}}
        {{--    $.ajax({--}}
        {{--        url:'{{route('getSubMenu')}}',--}}
        {{--        type:'GET',--}}
        {{--        data: {--}}
        {{--            id:id--}}
        {{--        },--}}
        {{--        success:(response)=>{--}}

        {{--            document.getElementById('updateName').value = response.name;--}}
        {{--            $('#subMenuUpdate').modal("show")--}}
        {{--        }--}}
        {{--    })--}}
        {{--}--}}

        function openSubMenuUpdate(id){
            let url = $('#getUrl').val();
            let formData = new FormData();
            formData.append('id', id);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData:false,
                success: function (data){
                    $('#updateName').val(data.name);
                    $('#id_update').val(data.id);
                    $('#id_menu').val(data.menu_id);
                    $('#subMenuUpdate').modal('show');
                },
                error: function (data){
                    Swal.fire({
                        icon: "error",
                        title:"Hata!",
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
        function updateSubMenu(){
            Swal.fire({
                icon: "warning",
                title:"Emin misiniz?",
                html: "Bu hastayı güncellemek istediğinize emin misiniz?",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Onayla",
                cancelButtonText: "İptal",
                cancelButtonColor: "#e30d0d"
            }).then((result)=>{
                if (result.isConfirmed){
                    let url = $('#updateUrl').val();
                    console.log(url);
                    let formData = new FormData(document.getElementById('updateSubMenu'));
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
                            $('#subMenuUpdate').modal('hide');
                            packageTable.ajax.reload();
                        },
                        error: function (data){
                            Swal.fire({
                                icon: "error",
                                title:"Hata!",
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

    </script>

@endsection
