@extends('admin.app')
@section('content')

    <div class="page-heading">
        <h3>Ücretler</h3>
    </div>
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="form-group">
                        <p> Hizmet eklemek için aşağıdaki butonu kullanınız.</p>
                        <!-- Button trigger for login form modal -->
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#inlineForm">
                            Hizmet Ekle
                        </button>

                        <!--login form Modal -->
                        <div class="modal fade text-left" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel33">Hizmet</h4>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </div>
                                    <form id="payment_create">
                                        @csrf
                                        <div class="modal-body">
                                            <label>Hizmet İsmi: </label>
                                            <div class="form-group">
                                                <input type="text" name="name" placeholder="Hizmet İsmi" class="form-control">
                                            </div>
                                            <label>Hizmet Açıklaması: </label>
                                            <div class="form-group">
                                                <input type="text" name="description" placeholder="Hizmet Açıklaması" class="form-control">
                                            </div>
                                            <label>Hizmet Ücreti: </label>
                                            <div class="form-group">
                                                <input type="number" name="price" placeholder="Hizmet Ücreti" class="form-control">
                                            </div>
                                            <label>Para Birimi: </label>
                                            <div class="form-group">
                                                <input type="text" name="currency" placeholder="Para Birimi" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Kapat</span>
                                            </button>
                                            <button type="button" onclick="create_payment()" class="btn btn-primary ml-1" data-bs-dismiss="modal">
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

    <div class="modal fade text-left" id="paymentUpdate" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Hizmet</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form id="payment_create">
                    @csrf
                    <input type="hidden" id="paymentID">
                    <div class="modal-body">
                        <label>Hizmet İsmi: </label>
                        <div class="form-group">
                            <input type="text" name="name" id="updateName" placeholder="Hizmet İsmi" class="form-control">
                        </div>
                        <label>Hizmet Açıklaması: </label>
                        <div class="form-group">
                            <input type="text" name="description" id="updateDescription" placeholder="Hizmet Açıklaması" class="form-control">
                        </div>
                        <label>Hizmet Ücreti: </label>
                        <div class="form-group">
                            <input type="number" name="price" id="updatePrice" placeholder="Hizmet Ücreti" class="form-control">
                        </div>
                        <label>Para Birimi: </label>
                        <div class="form-group">
                            <input type="text" name="currency" id="updateCurrency" placeholder="Para Birimi" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Kapat</span>
                        </button>
                        <button type="button" onclick="update_payment()" class="btn btn-primary ml-1" data-bs-dismiss="modal">
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
                Ücret Listesi
            </div>
            <div class="card-body" style="overflow: auto">
                <table class="table table-responsive" id="paymentTable" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hizmet Adı</th>
                        <th>Hizmet Açıklaması</th>
                        <th>Hizmet Ücreti</th>
                        <th>Para Birimi</th>
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
        let packageTable = $('#paymentTable').DataTable({
            order: [
                [1, 'ASC']
            ],
            processing: true,
            serverSide: true,
            ajax: '{!! route('paymentFetch') !!}',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'description'},
                {data: 'price'},
                {data: 'currency'},
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

        function create_payment(){
            Swal.fire({
                icon: "warning",
                title:"Emin misiniz?",
                html: "Hizmet eklemek istediğinize emin misiniz?",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Onayla",
                cancelButtonText: "İptal",
                cancelButtonColor: "#e30d0d"
            }).then((result)=>{
                if (result.isConfirmed){
                    let url = '{{route('paymentCreate')}}';
                    let formData = new FormData(document.getElementById('payment_create'));
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

        function delete_payment(id){
            Swal.fire({
                icon:'warning',
                title:'Emin Misiniz',
                text:'Bu Hizmeti Silmek İstediğinize Emin Misiniz',
                showConfirmButton:true,
                confirmButtonText:'Sil',
                confirmButtonColor:'red',
                showCancelButton:'true',
                cancelButtonText:'İptal',
            }).then((response)=>{
                if (response.isConfirmed){
                    $.ajax({
                        url:'{{route('paymentDelete')}}',
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

        function openMenuUpdate(id){
            document.getElementById('paymentID').value = id;
            $.ajax({
                url:'{{route('paymentGet')}}',
                type:'GET',
                data: {
                    id:id
                },
                success:(response)=>{

                    document.getElementById('updateName').value = response.name;
                    document.getElementById('updateDescription').value = response.description;
                    document.getElementById('updatePrice').value = response.price;
                    document.getElementById('updateCurrency').value = response.currency;
                    $('#paymentUpdate').modal("show")
                }
            })
        }

        function update_payment(){
            let name = document.getElementById('updateName').value;
            let description = document.getElementById('updateDescription').value;
            let price = document.getElementById('updatePrice').value;
            let currency = document.getElementById('updateCurrency').value;
            $.ajax({
                url:'{{route('paymentUpdate')}}',
                type:'POST',
                data: {
                    id:document.getElementById('paymentID').value,
                    name:name,
                    description:description,
                    price:price,
                    currency:currency,
                    '_token':'{{csrf_token()}}'
                },
                success:()=>{
                    $('#paymentUpdate').modal('hide')
                    packageTable.ajax.reload()
                    Swal.fire({
                        title:'Başarılı',
                        icon:'success',
                        showConfirmButton:true,
                        confirmButtonText:'Tamam',
                        showCancelButton:false
                    })
                    document.getElementById('updateName').value = '';
                    document.getElementById('updateDescription').value = '';
                    document.getElementById('updatePrice').value = '';
                    document.getElementById('updateCurrency').value = '';
                },
                error:()=>{
                    Swal.fire({
                        icon:'error',
                        title:'Hata',
                        text:'Lütfen Bütün Alanları Doldurduğunuza Emin Olunuz',
                        showConfirmButton:true,
                        confirmButtonText:'Tamam',
                        showCancelButton:false
                    })
                }
            })
        }

    </script>

@endsection
