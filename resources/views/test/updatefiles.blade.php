<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subida de archivos</title>
</head>
<body>
{!! Form::open(['route' => 'test.update-files-store', 'enctype' => 'multipart/form-data']) !!}
    
    <div class="container">
        <div class="card">
            
            {!! Form::file('xml', ['class' => 'form-control']) !!}
        </div>

        <!-- <div class="card">
            {!! Form::label('image', 'PDF') !!}
            {!! Form::file('image', ['class' => 'form-control']) !!}
        </div> -->
    </div>    

    {!! Form::submit('Guardar', ['name' => 'submit']) !!}
            
{!! Form::close() !!}


</body>
</html>