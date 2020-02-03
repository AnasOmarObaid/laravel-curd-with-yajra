<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>get client By Api</title>

    {{-- bootstrap file --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    {{-- font awsom  --}}
    <link rel="stylesheet" href="{{asset('public/fontawesome-free/css/all.min.css')}}">
</head>
<div class="container">
    <section class="content">
        <h2 class="text-center"
            style="margin-top: 40px;color: #616161;font-family: cursive;font-weight: 600;margin-bottom:50px ;font-size: x-large;word-spacing: -2px;">
            Laravel 6 curd using ajax And Featch Posts By Api</h2>
        <table class="table table-bordered table-striped text-center" id="postTable">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Post Title</th>
                    <th>Post Body</th>
                    <th>Add By</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>

        {{-- btn to add new post --}}
        <button type="button" id="btnPostModal" class="btn btn-success" data-toggle="modal"><i
                class="fas fa-plus fa-fw"></i> New Post</button>


        {{-- popup for create new post--}}
        <div class="modal fade" tabindex="-1" id="postModal" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="postTitle">Create Post</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" id="postForm">
                        <div class="modal-body">
                            @csrf
                            <span id="postResult"></span>
                            <div class="form-group">
                                <label for="exampleTitlePost">Post Title</label>
                                <input type="text" class="form-control" name='title' id="exampleTitlePost"
                                    placeholder="Enter Post Title">
                            </div>
                            <div class="form-group">
                                <label>Post Body</label>
                                <textarea class="form-control" style="height:130px" name='body'
                                    placeholder="Enter Post Body"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Post</button>
                    </form>
                </div>
            </div>
        </div>
</div>

</section>{{-- end section --}}
</div>{{-- end container --}}

{{-- jquery file --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
{{--  bootstrap js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

{{-- ajax code --}}
<script>
    $(document).on('ready', function(){
        
         // ajax setup
         $.ajaxSetup({
                headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                 'x-api-key' : 'abx12cr42ak42js21s@eka!kd*md@ma4kw#mw%58!sa',
                 'Content-Type': 'application/json'
                }
            }); //-- end ajax setup
    
        // ajax to featch client api
        $.ajax({
            method: 'GET',
            url: 'http://api.com/Laravel/Api/api/post',
            cache:false,
            dataType:'json',
            processData:false,
            timeout:20000,
            username:'mostfa@gmail.com',
            password:'123123123',
            success:function(posts){ 
                var html = '';
               // console.log(posts.data[0].post_title);
               if(posts.status){
               if(posts.data.length==0){
                $('#postTable').remove();
                var post = `<div class='alert alert-danger'>
                Soory There Is No Posts
                </div>`;
                $('.content').append(post);
               }
               for(var i= 0; i<posts.data.length; ++i){
                 html += `<tr>
                 <th scope="row">${i+1}</th>
                 <td>${posts.data[i].post_title}</td>
                 <td>${posts.data[i].post_body}</td>
                 <td>${posts.data[i].add_by}</td>
                 <td>${posts.data[i].created_at}</td>
                 <td>${posts.data[i].updated_at}</td>
                 <td>
                 <button class ='btn btn-info btn-sm btn-block' data-id='${posts.data[i].post_id}' style='margin-bottom:5px'>Edit Post</button>
                 <form class='form-inline'>
                    <button type ='submit'class ='btn btn-danger btn-sm btn-sm btn-block'>Delete Post</button>
                 </form>
                 </td>
                 </tr>`;
                }//-- end for

                $('#tableBody').append(html);
               }//-- end if
               
            },//-- end success
            error:function(xhr, status, error){
               $('.posts').html('<p class = "alert alert-danger">'+ error +'</p>');
            }//-- end error
        });//-- end featch client api

        // open moal to create post
        $('#btnPostModal').on('click', function(){
            $('#postModal').modal('show');
        });

        // ajax to create post
        $('#postForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                method: "POST",
                url: "http://api.com/Laravel/Api/api/post",
                headers: {
                    "Authorization": "Basic " + btoa('nesma@gmail.com' + ":" + '123123123')
                },
                traditional:true,
                processData: false,
                mimeType: "multipart/form-data",
                contentType: 'application/json',
                data: {
                    'title' : 'test title22222',
                    'body'  : 'test test test test test',
                },
                success:function(info){
                   
                      console.log(info);
                    
                },
                error:function(error){
                    // Unauthorized
                    if(error.status == 401){
                        console.log(error.statusText);

                    }
                    // required faild
                    if(error.status == 422){
                        console.log('error input');
                        console.log(error);
                    }
                }
            });//-- end ajax
        });//-- end submit

  });//-- end docuement ready

</script>

<body>
</body>

</html>