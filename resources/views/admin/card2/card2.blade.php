@extends('admin.app')

@section('content')

    <div class="page-heading">
        <h3>Card2 sliderı</h3>
    </div>
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="form-group">
                        <p>Card2 sliderı eklemek için aşağıdaki butonu kullanınız.</p>
                        <!-- Button trigger for login form modal -->
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#inlineForm">
                            Card2 sliderı Ekle
                        </button>

                        <!-- Login form Modal -->
                        <div class="modal fade text-left" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                            <div style="height: 600px" class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel33">Slider</h4>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </div>
                                    <form id="slider_create" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <label>Fotoğraf: </label>
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="img" id="img">
                                            </div>
                                            <label>Card2 Title: </label>
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="maintitle" id="maintitle">
                                            </div>
                                            <label>Card2 Description: </label>
                                            <div class="form-group">
                                                <textarea class="form-control" name="maindescription" id="maindescription"></textarea>
                                            </div>
                                            <label>Link İsmi: </label>
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="link" id="link">
                                            </div>
                                            <label>Sayfa Başlığı: </label>
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="title" id="title">
                                            </div>
                                            <label>Sayfa İçeriği: </label>
                                            <div class="form-group">
                                                <textarea class="form-control" name="description" id="description"></textarea>
                                            </div>
                                            {{-- Dil Seçimi için Dropdown --}}
                                            <div class="form-group">
                                                <label for="language_code">Dil Seçimi:</label>
                                                <select class="form-select" id="language_code" name="language_code">
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->code }}">{{ $country->code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Kapat</span>
                                            </button>
                                            <button type="button" onclick="create_slider()" class="btn btn-primary ml-1" data-bs-dismiss="modal">
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
                <table class="table table-responsive" id="sliderTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fotoğraf İsmi</th>
                        <th>Dil Seçeneği</th>
                        <th>Fotoğraf</th>
                        <th>Slider Title</th>
                        <th>Slider Description</th>
                        <th>Link İsmi</th>
                        <th>Sayfa Başlığı</th>
                        <th>Sayfa İçeriği</th>
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

    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <!-- Replace the Summernote initialization script with CKEditor initialization -->
    <script>
        $(document).ready(function() {
            // Initialize CKEditor
            CKEDITOR.replace('description', {
                // Adjust the height as needed
                height: 300,
                // Reserve space at the bottom for toolbar and buttons
                autoGrow_bottomSpace: 40,
                // Other CKEditor options...
            });

            // Handle modal shown event to adjust the modal height
            $('#inlineForm').on('shown.bs.modal', function () {
                // Adjust the modal height based on CKEditor content height
                var editorHeight = CKEDITOR.instances['description'].container.$.offsetHeight;
                var newModalHeight = 800 + editorHeight;
                $('#inlineForm .modal-dialog').css('height', newModalHeight + 'px');
            });
        });
    </script>

    <script>
        let packageTable = $('#sliderTable').DataTable({
            order: [
                [1, 'ASC']
            ],
            processing: true,
            serverSide: true,
            ajax: '{!! route('fetchCard2') !!}',
            columns: [
                {data: 'id'},
                {data: 'img'},
                {data: 'lang'},
                {data: 'imgDetail'},
                {data: 'maintitle'},
                {data: 'maindescription'},
                {data: 'link'},
                {data: 'title'},
                {data: 'description'},
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

        function create_slider() {
            Swal.fire({
                icon: "warning",
                title: "Emin misiniz?",
                html: "Slider eklemek istediğinize emin misiniz?",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Onayla",
                cancelButtonText: "İptal",
                cancelButtonColor: "#e30d0d"
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = '{{ route('createCard2') }}';
                    let formData = new FormData(document.getElementById('slider_create'));
                    formData.set('description', CKEDITOR.instances['description'].getData()); // Include CKEditor content

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function () {
                            Swal.fire({
                                icon: "success",
                                title: "Başarılı",
                                showConfirmButton: true,
                                confirmButtonText: "Tamam"
                            });
                            packageTable.ajax.reload();
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: "error",
                                title: "Boş girdi bırakmayınız!",
                                html: "<div id=\"validation-errors\"></div>",
                                showConfirmButton: true,
                                confirmButtonText: "Tamam"
                            });
                            $.each(data.responseJSON.errors, function (key, value) {
                                $('#validation-errors').append('<div class="alert alert-danger">' + value + '</div>');
                            });
                        }
                    });
                }
            });
        }


        function delete_slider(id){
            Swal.fire({
                icon: 'warning',
                title: 'Emin Misiniz',
                text: 'Bu Slideri Silmek İstediğinize Emin Misiniz',
                showConfirmButton: true,
                confirmButtonText: 'Sil',
                confirmButtonColor: 'red',
                showCancelButton: true,
                cancelButtonText: 'İptal',
            }).then((response)=>{
                if (response.isConfirmed){
                    $.ajax({
                        url: '{{route('deleteCard2')}}',
                        type: 'POST',
                        data: {
                            id: id,
                            "_token": '{{csrf_token()}}'
                        },
                        success:()=>{
                            packageTable.ajax.reload();
                            Swal.fire({
                                title: 'Başarılı',
                                icon: 'success',
                                showConfirmButton: true,
                                confirmButtonText: 'Tamam',
                                showCancelButton: false
                            })
                        },
                        error:()=>{
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                text: 'Silme İşlemi Başarısız',
                                showConfirmButton: true,
                                confirmButtonText: 'Tamam',
                                showCancelButton: false
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
