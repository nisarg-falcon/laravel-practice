<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Image Upload</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="card mr-5 ml-5 mt-5">
        <div class="card-header">
            Image Upload
        </div>
        <div class="card-body">
            <form action="{{ route('image.upload.submit') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                @error('image')    
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @if(Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-success">{{ Session::get('error') }}</div>
                @endif
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="image" id="image" class="custom-file-input">
                        <label for="image" class="single-label custom-file-label">Choose File</label>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mr-5 ml-5 mt-5">
        <div class="card-header">
            Multiple Image Upload
        </div>
        <div class="card-body">
            <form action="{{ route('multi.image.upload.submit') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                @error('multi_image')    
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @if(Session::has('multi-success'))
                    <div class="alert alert-success">{{ Session::get('multi-success') }}</div>
                @endif
                @if(Session::has('multi-error'))
                    <div class="alert alert-success">{{ Session::get('multi-error') }}</div>
                @endif
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="multi_images[]" id="multi_image" class="custom-file-input" multiple>
                        <label for="multi_image" class="multi-label custom-file-label">Choose File</label>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mr-5 ml-5 mt-5">
        <div class="card-header">
            Image Table
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($images as $image)
                        <tr>
                            <td>{{ $image->image_name }}</td>
                            <td><img src="/{{ $image->image_url }}" height="100px" width="100px" alt="{{ $image->image_name }}"></td>
                            <td><a href="{{ route('image.download',$image->image_name) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                              </svg></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $('#multi_image').change(function(){;
            $('.multi-label').empty();
            Array.from($(this)[0].files).forEach(function(item, index){
                $('.multi-label').append(item.name+",");
            });
        });
        $('#image').change(function(){
            $('.single-label').text($(this)[0].files[0].name);
        });
    </script>
</body>
</html>