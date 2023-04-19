search_engine :

Le moteur de recherche est un projet qui vous permet de chercher un mot-clé et trouver les fichiers correspondants. Vous pouvez également afficher tous les fichiers existants dans la base de données.

Comment utiliser le projet:
La page principale du projet est index.php. Vous pouvez taper un mot-clé dans le champ de recherche et appuyer sur "Rechercher maintenant" pour obtenir les fichiers qui contiennent le mot-clé. Vous pouvez également cliquer sur le bouton "Afficher tous les fichiers" pour afficher tous les fichiers existants dans la base de données.

Le dossier sources contient tous les fichiers texte que vous souhaitez inclure dans la recherche, et le fichier stopwords contient les mots vides à exclure de la recherche.

Le fichier fill_database.php permet de remplir la base de données avec les fichiers et les mots correspondants. Vous pouvez l'exécuter une fois pour remplir la base de données initiale.

Structure des fichiers:
index.php: page principale du projet
fill_database.php: code pour remplir la base de données
sources/: dossier contenant tous les fichiers texte à inclure dans la recherche
stopwords: fichier contenant les mots vides à exclure de la recherche
connect.php: fichier de connexion à la base de données
style.css: feuille de style pour le projet

Comment exécuter le projet :
1- Clonez le dépôt à l'aide de la commande git clone https://github.com/lydiatrabelsi/search_engine.git
2- Démarrez un serveur local (par exemple, en utilisant WAMP, XAMPP, MAMP, etc.)
3- Importer la base de donnée
4- Configurez la connexion à la base de données dans le fichier connect.php
5- Executer index.php sur votre localhost (temps de chargement lors du remplissage de la bdd)
6- Ecrire un mot clé exemple : ( algorithmique, programmation, HTML ...) 