<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Thought Mail</title>
</head>
<body>
<div class="container align-content-center  text-center" >
        <div class="mt-5">
            <form action="{{route('setPassword',['id' =>$id])}}" method="post">
                @csrf
                <h3>Set your password</h3>
                <p>Your password must be minimum 6 characters</p>
                <div>
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <p class='text-danger'>{{$errors->first('password')}}</p>
                </div>
                <div class="mt-3">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirmPassword">
                    <p class='text-danger'>{{$errors->first('confirmPassword')}}</p>
                </div>
                <button class="w-25 mt-3">Set your account password</button>
            </form>
        </div>
</div>
</body>
</html>

