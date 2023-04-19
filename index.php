<!DOCTYPE html>
<HTML>
    <head>
        <title> Search engine in PHP</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

        <form action="" method="post">

            <img src="Search.png" alt="logo" class ="logo">
            <input type="text" name="user_query" size="80" class="search" placeholder="write something to search"/>
            <input type="submit" name="search" value="Search Now" class="send_data" />
            <input type="submit" name="show_all" value="Show All Files" class="show_all" />

        
        </form>
        
        <div class="result">
            <?php
                include 'connect.php';
                function is_table_empty($table_name) {
                    include 'connect.php';
                    $sql = "SELECT COUNT(*) as count FROM $table_name";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    return ($row['count'] == 0);
                }

                if (is_table_empty('files')) {
                    include 'fill_database.php';
                }
            
                // Vérification que le formulaire a été soumis
                if(isset($_POST['search'])) {
            
                    // Récupération du mot entré par l'utilisateur
                    $word = $_POST['user_query'];
                    echo $word;

                    // Requête pour récupérer les fichiers qui contiennent le mot
                    $sql = "SELECT DISTINCT files.path, words_files.occurrence FROM files INNER JOIN words_files ON files.id = words_files.file_id INNER JOIN words ON words_files.word_id = words.id WHERE words.word = '$word'";
                        
                    $result = mysqli_query($conn, $sql);
                
                    echo '<h2> Resultat de votre recherche : ';
                    if(mysqli_num_rows($result) == 0) {
                        echo "<p>Désolé, nous ne trouvons pas ce que vous cherchez. Veuillez essayer de chercher autre chose.</p>";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<p><a href='{$row['path']}' target='_blank'>" . pathinfo($row['path'], PATHINFO_FILENAME) . "</a>(" . $row['occurrence'] . ")" . "</p>";
                        }
                    }
                }

                if (isset($_POST['show_all'])) {
                    $sql="SELECT * FROM `files` ";
                    $result = mysqli_query($conn, $sql);
                    echo '<table>';
                    echo '<tr><th>File ID</th><th>Path</th></tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['path'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    
                    
                }
            
            ?>
        </div>
    </body>
</HTML>