<!DOCTYPE html>
<html>
    <head>
        <title>Mostrar Agencias</title>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <!--<div class="title">Agencias</div>-->
            </div>
            
            <form name="formulario">
                <input type="text" maxlength="10" name="nombre" />
                <input type="submit" name="buscar" value="Buscar" />
            </form>
            <div id="resultado"></div>

            <br><br>Lista de Agencias {{ $ciudad }} 
            (PostgreSQL - Servidor Desarrollo 3):  <br><br>
            Código:     Nombre: <br>
            @foreach ($resultado as $d)
             {{ '      ' . $d->codagencia. '      '.$d->nombre }} <br>
            @endforeach
            <br>Total Registros: {{ $total_reg }}
        </div>
    </body>
</html>
