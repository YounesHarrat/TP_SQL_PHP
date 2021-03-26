<?php
    $user = 'visiteur';
    $pass = 'root';
    $db = 'animaux';
    $host = '127.0.0.1';

    $conn = new mysqli($host, $user, $pass, $db, 3306) or die("Unable to connect");
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $pdo = new PDO('mysql:host=localhost; dbname='. $db, $user, $pass);
    $select = $pdo->query('SELECT * FROM animaux.chien');
    $select = $select->fetchAll(PDO::FETCH_OBJ);

    function select() {
        global $pdo;
        $select = $pdo->query('SELECT * FROM animaux.chien');
        $select = $select->fetchAll(PDO::FETCH_OBJ);
        return $select;
    }
    


    function add($nom,$type) {
        global $pdo;
        $AjoutChien = $pdo->prepare("INSERT INTO animaux.chien (`nom`, `type`) VALUE (?,?) ");
        $AjoutChien->bindParam(1,$nom);
        $AjoutChien->bindParam(2,$type);
        $AjoutChien->execute();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <?php    
            foreach($select as $key => $value) {
        ?>
        <li>          
                id: <?= $value->ID ?>, 
                nom : <?= $value->nom ?>, 
                race : <?= $value->type ?>.
        </li>
        <?php
                }
        ?>
    </ul>
    <div>
        <h1>Ajouter un Chien</h1>
        <form action="" method="POST">
            <label>Nom</label>
            <input type="text" name="nom" />
            <label>Race</label>
            <input type="text" name="type" />
            <input type="submit" value="Add Chien" />
        </form>
    </div>
</body>
</html>

<?php 


$verif1 = isset($_REQUEST['nom']) && !empty($_REQUEST['nom']) ;
$verif2 = isset($_REQUEST['type']) && !empty($_REQUEST['type']);

if ( isset($_REQUEST['nom']) && !empty($_REQUEST['nom']) ) {
    global $nom;
    $nom = $_REQUEST['nom'];
}

if ( isset($_REQUEST['type']) && !empty($_REQUEST['type']) ) {
    global $type;
    $type = $_REQUEST['type'];
}

if ( $verif1 && $verif2 ) {
    add($_REQUEST['nom'],$_REQUEST['type']);
    $select = select();
}

?>