@extends('admin.app')
@section('content')

    <div class="page-heading">
        <h3>Üyeler</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Üye Listesi
            </div>
            <div class="card-body" style="overflow: auto">
                <table class="table table-responsive" id="membersTable" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Üye İsim-Soyisim</th>
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

        let packageTable = $('#membersTable').DataTable({
            order: [
                [1, 'ASC']
            ],
            processing: true,
            serverSide: true,
            ajax: '{!! route('fetchMenu') !!}',
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

    </script>

@endsection
