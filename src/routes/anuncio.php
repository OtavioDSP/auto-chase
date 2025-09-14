<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="../php/global/global.php" method="POST">
        
        <h1>Cor - Adicionar Cor</h1>
        <input type="text" placeholder="Cor" name="cor_desc">

        <h1>Marca - Adicionar Marca</h1>
        <input type="text" placeholder="Marca" name="marca_desc">
        
        <h1>Modelo - Adicionar Modelo</h1>
        <input type="text" placeholder="Modelo" name="modelo_desc">
        <input type="text" id="modelo_ano" name="modelo_ano" pattern="\d{4}" maxlength="4" required placeholder="Ano">
        <input type="text" placeholder="FIPE" name="modelo_fipe">
        
        <h1>Chassi - Adicionar Chassi</h1>
        <input type="text" placeholder="Chassi" name="chassi_desc">

        <h1>Combustivel - Adicionar Combustivel</h1>
        <input type="text" placeholder="Combustivel" name="comb_desc">
      

        <input type="submit" value="Enviar" name="enviar_informacoes">
    </form>
    

    
</body>
</html>