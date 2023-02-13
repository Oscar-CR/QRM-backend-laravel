<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subida de archivos</title>
</head>
<body>
{!! Form::open(['route' => 'api.updateFiles', 'enctype' => 'multipart/form-data']) !!}
    
    <div class="container">
        <div class="card">
            <p>Order id(no se muestra al usuario,se toma de la orden)</p>
            {!!  Form::text('id') !!}
        </div>
        <div class="card">
            <p>XML</p>
            {!! Form::file('xml', ['class' => 'form-control']) !!}
        </div>

        <div class="card">
            <p>PDF</p>
            {!! Form::file('pdf', ['class' => 'form-control']) !!}
        </div> 
    </div>    

    {!! Form::submit('Guardar', ['name' => 'submit']) !!}
            
{!! Form::close() !!}


</body>
</html>