<?php
  include 'connect.php';
  mysqli_set_charset($conn, "utf8");
  // Vider la table "files"
  $sql = "DELETE FROM files ";
  mysqli_query($conn, $sql);

  // Vider la table "words"
  $sql = "DELETE FROM words";
  mysqli_query($conn, $sql);

  // Chemin du dossier contenant les fichiers à ajouter
  $directory = "sources/";

  // Récupération de la liste des fichiers dans le dossier
  $files = scandir($directory);

  // Boucle sur chaque fichier
  foreach ($files as $file) {
    // Vérification si le fichier est un fichier régulier (et pas un dossier)
    if (is_file($directory . $file)) {
      // Insertion du fichier dans la table "files"
      $path = $directory . $file;
      $sql = "INSERT INTO files (path) VALUES ('$path')";
      mysqli_query($conn, $sql);
    }
  }

  // Chargement des stopwords
  $stopwords = file("stopwords.txt", FILE_IGNORE_NEW_LINES);

  // Récupération de tous les fichiers de la table "files"
  $sql = "SELECT * FROM files";
  $result = mysqli_query($conn, $sql);

  if ($result->num_rows > 0) {
    // Parcours des fichiers
    while($row = $result->fetch_assoc()) {
      // Récupération du contenu du fichier
      $filename = $row["path"];
      // Récupération du contenu du fichier avec l'encodage spécifié en UTF-8
      $file_contents = file_get_contents($filename);
      $file_contents = mb_convert_encoding($file_contents, 'UTF-8', mb_detect_encoding($file_contents));

      //mettre les mots en minuscule
      $file_contents = strtolower($file_contents);

      // Division du contenu en mots
      $words = preg_split('/\PL+/u', $file_contents, -1, PREG_SPLIT_NO_EMPTY);

      // Récupération des stopwords
      $stopwords = file_get_contents('stopwords.txt');
      $stopwords_array = preg_split('/\s+/', $stopwords);

      // Filtrage des mots
      $filtered_words = array();

      foreach ($words as $word) {
        // Vérification que le mot n'est pas un stopword et qu'il n'est pas une ponctuation
        if (!in_array($word, $stopwords_array)) {
          // Ajout du mot filtré à la liste des mots
          $filtered_words[] = $word;
        }
      }
      
      // Insertion des mots dans la table "words"
      foreach ($filtered_words as $word) {
        $sql = "INSERT INTO words (word) VALUES ('$word')";
        mysqli_query($conn, $sql);
      }
    }
  }
  // Récupération de tous les fichiers de la table "files"
  $sql = "SELECT * FROM files";
  $result = mysqli_query($conn, $sql);

  if ($result->num_rows > 0) {
    // Parcours des fichiers
    while($row = $result->fetch_assoc()) {
      // Récupération du contenu du fichier
      $filename = $row["path"];
      $file_contents = file_get_contents($filename);
      //mettre les mots en minuscule
      $file_contents = strtolower($file_contents);

      // Division du contenu en mots
      $words = preg_split('/\PL+/u', $file_contents, -1, PREG_SPLIT_NO_EMPTY);

      //recuperation des stopwords
      $stopwords = file_get_contents('stopwords.txt');
      $stopwords_array = preg_split('/\s+/', $stopwords);

      // Filtrage des mots
      $filtered_words = array();

      foreach ($words as $word) {
        // Vérification que le mot n'est pas un stopword, qu'il n'est pas une ponctuation et qu'il contient plus de 2 lettres
        if (!in_array($word, $stopwords_array) && !preg_match('/[\pP]/u', $word) && strlen($word) > 2) {
          // Ajout du mot filtré à la liste des mots
          $filtered_words[] = $word;
        }
      }

      // Récupération de l'id du fichier
      $file_id = $row["id"];

      // Récupération des mots existants dans la table "words" sans répétition
      $sql = "SELECT DISTINCT id, word FROM words";
      $result_words = mysqli_query($conn, $sql);

      if ($result_words->num_rows > 0) {
        // Parcours des mots existants dans la table "words"
        while ($row_word = $result_words->fetch_assoc()) {
          $word_id = $row_word["id"];
          $word = $row_word["word"];
          $occurrences = 0;

          // Calcul du nombre d'occurrences du mot dans le fichier
          foreach ($filtered_words as $filtered_word) {
            if ($word == $filtered_word) {
              $occurrences++;
            }
          }

          // Insertion du mot et de son nombre d'occurrences dans la table "words_files"
          if ($occurrences > 0) {
            $sql = "INSERT INTO words_files (word_id, file_id, occurrence) VALUES ('$word_id', '$file_id', '$occurrences')";
            mysqli_query($conn, $sql);
          }
        }
      }
    }
  }

  // Fermeture de la connexion à la base de données
  mysqli_close($conn);


?>