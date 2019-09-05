<?php

if( isset( $_GET['img'] ) )
{
	$image = new Mini();
	$image->loadSetting( $_GET['img'] );
	$image->getImage( $_GET['img'] );
}

/*
*	class Mini
*
*	param entree :
*					$_GET['img'] 	 : path de l'image  					ex : ./photos/image1.jpg
*					$_GET['hauteur'] : hauteur finale de l'image  			ex : 300 ( px )
*					$_GET['largeur'] : largeur finale de l'image  			ex : 300 ( px )
*					$_GET['svg'] 	 : creation physique de la miniature	ex : 0 : affiche / 1 : sauve / 2 : les deux
*					

*	exemple : 
*					echo '<img src="mini_img.php?img=./photos/image1.jpg&amp;hauteur=300&amp;svg=0" >';
*/
class Mini
{
	private $_nom;
	private $_extension;
	private $_dossier;
	private $_hauteur;
	private $_largeur;
	private $_hauteur_new;
	private $_largeur_new;
	private $_ratio;
	
	private $_dossier_mini = "./mini/";
	
	
	public function afficheSetting( )
	{
		echo "param   : ".$this->_nom;
		echo "<br>param   : ".$this->_extension;
		echo "<br>param   : ".$this->_dossier;
		echo "<br>param   : ".$this->_hauteur;
		echo "<br>param   : ".$this->_largeur;
		echo "<br>param   : ".$this->_hauteur_new;
		echo "<br>param   : ".$this->_largeur_new;
		echo "<br>param   : ".$this->_ratio;
	}
	
	public function loadSetting( $picture )
	{
		$img = imagecreatefromjpeg( $picture );
		
		list($width, $height) = getimagesize( $picture );
		$this->_hauteur = $height;
		$this->_largeur = $width;
		$this->_ratio = $width / $height;
		
		if( isset( $_GET['hauteur'] ) )
		{
			$this->_hauteur_new = $_GET['hauteur'] ;
			$tmp_taille = explode( ".", $this->_ratio * $_GET['hauteur'] ) ;
			$this->_largeur_new = $tmp_taille[0] ;
		}
		if( isset( $_GET['largeur'] ) )
		{
			$this->_largeur_new = $_GET['largeur'] ;
			$tmp_taille = explode( ".", $_GET['largeur'] / $this->_ratio) ;
			$this->_hauteur_new = $tmp_taille[0] ;
		}

		$tmp_nom = explode( ".", $picture );
		$this->_extension = $tmp_nom[2];
		
		$tmp_nom = explode( "/", $picture );
		for($i = 0; $i < count($tmp_nom)-1; $i++)
		{
			$this->_dossier .= $tmp_nom[$i]."/";
		}
		$tmp_nom = explode( ".", $tmp_nom[count($tmp_nom)-1] );
		$this->_nom = $tmp_nom[0];
	}
	
	public function getImage( $picture )
	{
		$this->loadSetting( $picture );
		
		header ("Content-type: image/jpeg");
		$img = imagecreatefromjpeg( $picture );
		$thumb = imagecreatetruecolor($this->_largeur_new, $this->_hauteur_new);
		imagecopyresized($thumb, $img, 0, 0, 0, 0, $this->_largeur_new, $this->_hauteur_new, $this->_largeur, $this->_hauteur );

		if( isset( $_GET['svg'] ) )
		{
			if( $_GET['svg'] == 0 )
			{
				// on affiche l'image sans enregistrer
				Imagejpeg( $thumb );
				// on vide la mémoire
				Imagedestroy( $thumb );
			}
			if( $_GET['svg'] == 1 )
			{
				Imagejpeg( $thumb, $this->_dossier_mini."mini_".$this->_nom.".jpeg" );
			}
			if( $_GET['svg'] == 2 )
			{
				Imagejpeg( $thumb, $this->_dossier_mini."mini_".$this->_nom.".jpeg" );
				Imagejpeg( $thumb );
				Imagedestroy( $thumb );
			}
		}
	}
}

?>