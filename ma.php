<?php
include('conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Title </title>
    <link rel="stylesheet" href="css/x.css" type="text/css">
</head>

<body>
    <?php
    include('pim.php');    
    include('side.php');
    ?>
        <div id="alles">
            <div class="mip">
                <h2>Kies het aantal menu's:</h2>
                <form method="post">
                    <select name="aantal">
        <option></option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
        <option>6</option>
        <option>7</option>
        <option>8</option>
        <option>9</option>
        <option>10</option>
    </select>
                    <input type="submit" name="namen" value="selecteren">
                </form>
                <hr>
                <?php
    if(isset($_POST["namen"])) {
        if($_POST["aantal"] === "") {
            echo "U heeft nog niets geselecteerd.<br>";
            exit();
        }
        
        echo "<br> Vul hier de namen in van de menu's:<br><br>";
        $aantal = $_POST["aantal"];
        ?>
                    <form method="post">

                        <div class="namen">
                            <?php
        
        $namen = [];
        for($i = 0; $i<$aantal; $i++) {
            $a = $i+1;
            $b = "Menunaam ".$a." <input type='text' name='mn[]' placeholder='<type hier uw tekst>'><br>";
            echo $b;
            $namen[] = $b;
      }
        ?>
                        </div>
                        <?php
        $_SESSION['namen'] = $namen;
        ?>
                            <br>
                            <input type="submit" name="menu" value="selecteren">
                    </form>
                    <br>
                    <?php
        }
      if(isset($_POST["menu"])) {
          if($_POST['mn'] === "") {
            echo "U heeft nog niets ingevuld.";
            exit();
        }
          
        $c = count($_POST['mn']);  
        $d = $_POST['mn'];
        $_SESSION['mn'] = $d;
        $_SESSION['menu'] = $c;
          $i=0;
 foreach ($_SESSION['mn']??[] as $path) {  
     $i++;
     if($_POST['mn'] === "") {
            echo "U heeft nog niets ingevuld.";
            exit();
        }
    }
    }
    if(isset($_SESSION['mn'])) {
        echo "U heeft gekozen voor: <br><br>";
                  $i=0;
        ?>
                        <div class="namen">
                            <?php
         foreach ($_SESSION['mn']??[] as $path) {
             if($path === "") {
        echo "U heeft nog niet alle velden ingevuld.";
        exit();
     } else {
     $i++;
      $c = "Menunaam ".$i." ".$path."<br>";
             echo $c;
             }
         }
    }
    ?>
                        </div>
                        <hr>
                        <h2>Kies de afbeeldingen voor uw menu('s)</h2>
                        <p>U kunt alleen .jpeg, .jpg en .png bestanden uploaden.<br> U kunt geen grotere bestanden dan 2mb uploaden. <br> U kunt hier niet meer bestanden uploaden dan het aantal menunamen. U kunt bij overige afbeeldingen nog meer bestanden uploaden.</p>
                        <form method="post" enctype="multipart/form-data">
                            <input type="file" name="upload[]" multiple>
                            <input type="submit" name="submit" value="upload"><br>
                        </form>
                        <hr>
                        <?php
if (isset($_POST['submit'])) {

    // count number of uploaded files
    $total = count($_FILES['upload']['name']);
    $nummer = $_SESSION['menu'];

    // prepare array to store uploaded images in
    $images = [];

    if ($total > $nummer) {
            echo "U kunt niet meer bestanden uploaden dan het aantal menu's";
            exit();
        }
    // Loop through each file
    for ($i=0; $i < $total; $i++) {
        //Get the temp file path
        $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
        $fileName = $_FILES['upload']['name'][$i];
        $fileTmpName = $_FILES['upload']['tmp_name'][$i];
        $fileSize = $_FILES['upload']['size'][$i];
        $fileError = $_FILES['upload']['error'][$i];
        $fileType = $_FILES['upload']['type'][$i];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpeg', 'jpg', 'png');
        
        if (false == in_array($fileActualExt, $allowed)) {
            echo 'U kunt dit type bestand niet uploaden.';
            continue;
        }

        if ($fileError !== 0) {
            echo 'Er is een fout opgetreden tijdens het uploaden van uw bestand(en). Probeert u het nogmaals. Neem bij blijvende problemen contact met ons op.';
            continue;
        }


        if ($fileSize >= 2000000) {
            echo 'Uw bestand is te groot.';
            continue;
        }

        // we passed all tests, continue processing the image

        $fileNameNew = uniqid('', true).".".$fileActualExt;
        $fileDestination = 'upload/'.$fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);
        $images[] = $fileDestination;
    }

    // store images in session
    $_SESSION['images'] = $images;
}
                ?>
                            <div class="fotos">
                                <?php
            if (isset($_SESSION['images'])) 
            {
                $o = count($_SESSION['images']);

                if($_SESSION['menu'] > $o ) {
                    echo "Het aantal menu's komt niet overeen met het aantal menu afbeelding. <br> Verander het aantal menu's of het aantal afbeeldingen";
                } else {
                $nummer = 1;
                foreach ($_SESSION['images']??[] as $path) {
                    $teller = $nummer++;
                echo 'Gekozen afbeelding Menunaam '.$teller.': <img src="'.$path.'" width="100" height="100">';
                }
                }
            }
    ?>
                            </div>

                            <div id="volgende">
                                <a href="oa.php"><img src="img/volgende.jpg"></a>
                            </div>
                            <div id="vorige">
                                <a href="icoon.php"><img src="img/vorige.jpg"></a>
                            </div>
            </div>
        </div>
</body>

</html>
