<html>
	<head>
		<title>Miniature</title>
	</head>
	<body>
		<div>
			<h1 class="titre">Miniature</h1>
		</div>
	<center>
	
	<?php
	
	// url du fichier qui contient les images
	$urlphoto = $_SERVER['HTTP_REFERER'].$_SERVER['PHP_SELF'];
	// nom du répertoire qui contient les images
	$nomRepertoire = "./photos/";
	
	$i = 0;
	$n = 1;
	if( is_dir($nomRepertoire) )
	{
	   $dossier = opendir($nomRepertoire);
		echo '<table width="100%" align="center"><tr>';
	   
		while( $Fichier = readdir($dossier) )
		{
		   if($Fichier != "." AND $Fichier != ".." AND (stristr($Fichier,'.gif') OR stristr($Fichier,'.JPG') OR stristr($Fichier,'.png') OR stristr($Fichier,'.bmp') OR stristr($Fichier,'.JPEG') OR stristr($Fichier,'.jpeg') OR stristr($Fichier,'.jpg')))
		   {
				echo '<td><a target="_blank" href="', $urlphoto, '/', $nomRepertoire,$Fichier, '">';
				echo '<img src="mini_img.php?img='.$nomRepertoire.$Fichier.'&amp;hauteur=300&amp;svg=0" ></a>';

				$tmp_nom = explode( ".", $Fichier );
				echo "<span class=\"nom\"> ".$tmp_nom[0]."</span></td>";
				$i++;
			}
			if( $i == ($n * 2) )
			{
				echo "</tr><tr>";
				$n++;
			}
		}  
		echo "</tr></table>";
		closedir($dossier);
	}
	else
	{
		echo " Le répertoire spécifié n'existe pas";
	}
	?>
	</center>
	</body>
</html>