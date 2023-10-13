<?php
session_start();
$dir = './';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body{
            background-color: burlywood;
        }
        .navbar{
            margin: auto;            
            width: 75%;
            border: 3px solid green;
            padding: 20px;
            background-color: bisque;
        }
        .button{
            background-color: beige ;
            height: 30px;
        }
        #txtarea{
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size: 20px;

        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">

    <form method="post"> 
        <input type="submit" name="button1" class="button" value="Abrir" /> 
          
        <input type="submit" name="button2" class="button" value="Guardar" /> 

        <input type="submit" name="button3" class="button" value="Guardar nuevo">
    
    </nav>

    <div id="wrap" style="height: 94vh; display: flex; justify-content: space-around ">

      <textarea id="txtarea" style="width: 75%; height: 100%;" name="comments" ><?php
      if (isset($_POST['archivo'])){
        //echo $_POST['archivo'];
        $myfile = fopen($_POST['archivo'], "r") or die("Unable to open file!");
        echo fread($myfile,filesize($_POST['archivo']));
        $_SESSION = $_POST;
        fclose($myfile);
      } elseif (isset($_POST['button3']) && $_POST['button3'] == 'Guardar nuevo'){
        echo "Ingrese el nombre del archivo";
      } else{
        $myfile = fopen("./txt/nuevo.txt", "r") or die("Unable to open file!");
        echo fread($myfile,filesize("./txt/nuevo.txt"));
        fclose($myfile);
      }
      ?></textarea>
      </form>


    <?php
        if(array_key_exists('button1', $_POST)) { 
            button1(); 
        } 
        else if(array_key_exists('button2', $_POST)) { 
            button2(); 
        }  
        else if(array_key_exists('button3', $_POST)) { 
            button3(); 
        } 
        //Codigo para mostrar la lista de txt
        function button1() { 
            
/*             if (isset($_POST['button1']) && str_contains($_POST['button1'],'.txt')) {
                $_POST['archivo']=$_POST['button1'];
                $_POST['archivo'];
            } else { */

            if (isset($_POST['button1']) && $_POST['button1']=='Abrir') {
                $dir = glob('./*');
                //print_r($dir);
            } else {
                //echo $_POST['button1'];
                $dir =glob($_POST['button1'].'/*');
                //print_r($dir);
            }

            // Get an array of the directory contents using scandir()
            echo '<form method="post">';
            echo '<input type="submit" name="button1" class="button" value=".">'.'<br>';
            foreach($dir as $file) {
                if (!str_contains($file,".php" && !str_contains($file,".php") && !str_contains($file,".txt"))) {
                    $nombre = $file;
                    echo '<input type="submit" name="button1" class="button" value='.$nombre.'>'.'<br>';
                } else if (!str_contains($file,".php" && str_contains($file,".txt"))){
                    $nombre = $file;
                    echo '<input type="submit" name="archivo" class="button" value='.$nombre.'>'.'<br>';
                }

            }
            echo '</form>';}
        //} 
        //Codigo para sobreescribir txt:
        function button2() {
            if (isset($_SESSION['archivo']) && str_contains($_SESSION['archivo'],".txt")){
            $comments= $_POST['comments'];
            $myfile = fopen($_SESSION['archivo'], "w") or die("Unable to open file!");
            fwrite($myfile, $comments);
            fclose($myfile);
            $_SESSION = array();
            header("Location:pruebas.php");

            } else if(isset($_SESSION['archivo']) && !str_contains($_SESSION['archivo'],".txt")) {

                $files = scandir($GLOBALS["dir"]);
                echo '<form method="post">';
                foreach($files as $file) {
                    $nombre = $file;
                    echo '<input type="submit" name="button1" class="button" value='.$nombre.'>'.'<br>';
                }
                echo '</form>';

            }
        }
        
        function button3(){
                $comments= $_POST['comments'];
                $_SESSION['mensaje'] = $comments;                
                echo '<form method="post"><div><input type="text" name="crear" class="button">'.'<br>';
                echo '<input type="submit" class="button" value="Crear">'.'<br></div></form>';
            


        }
        
    ?>

    
    <?php
if (isset($_POST['crear'])) {
    $nombre= $_POST['crear'];
    $myfile = fopen("./txt/".$nombre.".txt", "w") or die("Unable to open file!");
    $txt = $_SESSION['mensaje'];
    fwrite($myfile, $txt);
    fclose($myfile);
    $_SESSION =array();
    echo "<br>creado exitosamente";
}


if (isset($_POST['archivo'])) {
    $archivo=$_POST['archivo'];
    //print_r($_POST);    
    echo "El archivo abierto es: ".$_SESSION['archivo']."<br><br>";
    echo "Ruta del txt: ".$archivo;
}
?>

</div>
</body>
</html>
