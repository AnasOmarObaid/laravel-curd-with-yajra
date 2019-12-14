<!DOCTYPE html>
<header>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laravel 5.8 - DataTables Server Side Processing using Ajax</title>
    {{-- bootstrap file --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    {{--  datatable file --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    {{-- font awsom  --}}
    <link rel="stylesheet" href="{{asset('public/fontawesome-free/css/all.min.css')}}">
    <!--load all styles -->
</header>
<div class=" container">
    <section class="content">
        <h2 class="text-center"
            style="margin-top: 40px;color: #616161;font-family: cursive;font-weight: 600;margin-bottom:50px ;font-size: x-large;word-spacing: -2px;">
            Laravel 6 DataTables Server Processing curd using ajax</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="user_table">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>
            <div style="margin:10px 0 20px 0" id="createModel">
                <button type="button" class="btn btn-info create-client" id="create-client" data-toggle="modal"
                    data-target="#exampleModalLabel"> <i class="fas fa-user-plus fa-fw"></i> Add client</button>
            </div>
        </div>
    </section>
</div>

{{-- Model --}}
<div class="modal fade" id="formModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="overflow:auto">
            <div class="modal-header">
                <h5 class="modal-title" id="custom-title">Add New Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeForm">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form-result"></span>
                <form id="formClient" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-4">First Name</label>
                        <div class="col-md-12">
                            <input type="text" name="first_name" class="form-control" id="first_name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Last Name</label>
                        <div class="col-md-12">
                            <input type="text" name="last_name" class="form-control" id="last_name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Email</label>
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control" id="email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">phone</label>
                        <div class="col-md-12">
                            <input type="tel" name="phone" class="form-control" id="phone" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Add Iamge</label>
                        <div class="custom-file col-md-12">
                            <label class="custom-file-label" for="image" style="margin:0 11px">Choose iamge...</label>
                            <input type="file" class="custom-file-input" id="image" name="image">
                        </div>
                    </div>

                    <input type="submit" class="btn btn-block btn-success" name="create_clent" id="action"
                        value="Create Client" />
                    <div class="area-image"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>{{-- /.Model --}}


{{-- delete model --}}

<!-- Modal -->
<div class="modal fade" id="confirmDelate" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are You Sure To Delete This Client ? That will Loase The Data For This Client!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="confirmDelateBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

{{-- /.delete model --}}

<body>

    {{-- jquery file --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

    {{-- datatable file --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js">
    </script>

    {{--  bootstrap js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    {{-- ajax code --}}
    <script>
        $(document).ready(function(){
            var clientId = 0;
            $('#user_table').DataTable({
                "lengthMenu": [[5, 10, 20, -1], [5, 10, 15, "All"]],
                "order":[[0,'desc']],
                'processing':true,
                'serverSide':true,
                'ajax':{
                    'url': "{{route('client.index')}}"
                },
                'columns':[

                    {
                        'data': 'id',
                        'name' : 'id',
                        render: function(data, type, full, meta){
                            /*
                            data: return acual data from table,
                            type: return the status of data,
                            full: return the full information from the table like first name and last name ...
                            meta: return the information this data in class and show the url
                            */
                         return "<span>" +  (meta.row+1) + "</span>";
                        }
                    },
                    {
                        'data': "image",
                        'name': "image",
                        render : function(data, type, full, meta){
                            return "<img src ={{URL::to('/')}}/public/images/" + data + " width = '70' class = 'img-thumbnail' /> ";
                        },
                        'orderable':false
                    },
                    {
                        'data': "first_name",
                        'name': "first_name"
                    },
                    {
                        'data': "last_name",
                        'name': "last_name"
                    },
                    {
                        'data': "first_name" ,
                        'name': "first_name",
                        render: function(data, type, full, meta){
                            return "<span> " +  full.first_name + ' ' + full.last_name + " </span>";
                        }

                    },

                    {
                        'data': "email",
                        'name': "email"
                    },

                    {
                        'data': "phone",
                        'name': "phone"
                    },
                    {
                        'data': "action",
                        'name': "action",
                        'orderable': false
                    }
                ]
            });//-- end data table

            // ajax setup
            $.ajaxSetup({
                headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); //-- end ajax setup

            // start create client model
            $('#createModel').on('click', function(){
                $('#formModel').modal('show');
            });//-- end create client model

            // start edit data client
            $(document).on('click', '.edit', function(){
                $('#form-result').html('');
                $('#custom-title').html('Edit Client Inforamtion');
                var id = $(this).data('id');
                $('#action').val('Edit Client');
               // $('#formModel').modal('show');
                $.ajax({
                    url: "client/" + id + "/edit",
                    dataType: "json",
                    success:function(html){
                        if(html.status == true){
                            $('#first_name').val(html.data.first_name);
                            $('#last_name').val(html.data.last_name);
                            $('#email').val(html.data.email);
                            $('#phone').val(html.data.phone);
                            clientId = html.data.id;
                            $('.area-image').html('');
                            var src = "{{URL::to('/')}}/public/images/" + html.data.image;
                            var areaImage = `<img src = "${src}"  width = '90' class = 'img-thumbnail' />`;
                            $('.area-image').append(areaImage);
                            $('#formModel').modal('show');  // open model
                        }// -- end if statment
                    },
                });//-- end ajax methoad
            }); //-- end edit data client

            // start form Client [create|update]
            $('#formClient').on('submit', function(e){
                e.preventDefault();
                if($('#action').val() == 'Create Client'){
                   $.ajax({
                        url :  "{{ route('client.store') }}",
                        method : 'POST',
                        data : new FormData(this),
                        contentType:false,
                        cache:false,
                        processData:false,
                        dataType:'json',
                        success:function(data){
                            var html = '';

                            if(data.errors){
                                html = "<div class = 'alert alert-danger'>";
                                for(var x in data.errors){
                                    html += "<p>" +  data.errors[x] + "</p>";
                                }
                                html += "</div>";
                            } //-- end if statment

                            if(data.success){
                                html = "<div class = 'alert alert-success'><p> " +  data.success + " </p></div>";
                                $('#formClient')[0].reset(); // clear the table
                                $('#user_table').DataTable().ajax.reload(); // reload the table
                            }//-- end if statment

                            $('#form-result').html(html); // span result
                        }//-- end success methoad

                   }); // -- end create ajax methoad

                } //-- end create client btn

                // start update client btn
                if($('#action').val() == 'Edit Client'){
                    $.ajax({
                        url: "client/update/"+clientId,
                        method: "POST",
                        data : new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success:function(data){
                            var html = '';
                            console.log(data.test);
                            if(data.errors){
                                html = "<div class = 'alert alert-danger'>";
                                for(var x in data.errors){
                                    html += "<p>" +  data.errors[x] + "</p>";
                                }
                                html += "</div>";
                            } //-- end error if statment

                            if(data.success){
                                html = "<div class = 'alert alert-success'><p> " +  data.success + " </p></div>";

                                $('#user_table').DataTable().ajax.reload(); // reload the table
                            }//-- end success if statment

                            $('#form-result').html(html); // span result
                        }
                    });//-- end update ajax methoad

                }//-- end edit client btn

            }); //-- end form client craete[create|update]

            // open delete model
            var clientIdDelete ;
            $(document).on('click', '.delete', function(){
                $('#confirmDelate').modal('show');
                clientIdDelete = parseInt($(this).data('id'));
            });// end dlete model

            // form client delete
            $('#confirmDelateBtn').on('click', function(){
               $.ajax({
                    url: "client/destroy/"+clientIdDelete,
                    method:"DELETE",
                    beforeSend:function(){
                        $('#confirmDelateBtn').text('Deleting......');
                    },
                    success:function(data){
                        $('#user_table').DataTable().ajax.reload(); // reload the table
                        setTimeout(function(){
                            $('#confirmDelateBtn').text('Delete');
                            $('#confirmDelate').modal('hide');
                        }, 1000);
                    }
               });
            });
        }); //-- end document model
    </script>

</body>

</html>