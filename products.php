<?php

//unkluderar template
include "template.php";



$products = ""; //tom variabel som tar emot databasinnehåll

//databasfråga hämtar alla produkter och sorterar på kategori(get-variablen)
$query = <<<END
	SELECT * FROM produkt
	WHERE Kategori = "{$_GET["category"]}"
END;

//kör databasfrågan
$res = $conn->query($query);

//kollar om det finns data och isåfall printar ut den
if($res->num_rows > 0) {
	while($row = $res->fetch_object()) {
		$productTitle = utf8_encode($row->ProduktNamn); //gör om produkt titel till utf-8 (åäö)
		$products .= <<<END
			<div class="product col-md-3">
				<div class="crop"><img class="productimg" src="{$row->imgUrl}" alt="product"></div>
				<div class="titlewrap"><h4>$productTitle</h4></div>
				<h6>LAGERSTATUS<div class="{$row->Lagerstatus} img-circle"></div></h6>
				<p class="price">{$row->Pris}kr</p>
				<a class="btn btn-success pull-left" href="productdetails.php?id={$row->ProduktID}">LÄS MER</a>
				<a class="btn btn-success pull-right" href="#">KÖP</a>
			</div>
END;
	}
}

//hämtar get variabel och gör den till stora bokstäver
$title = strtoupper($_GET["category"]);

//content
$content = <<<END
	<div id="content" class="container">
		<div id="products" class="col-md-10 col-centered">
			<h1 class="col-md-4 col-centered">$title</h1>
			$products 
		</div>
	</div>
END;

//printar ut alla element
echo $header;
echo $content;
echo $footer;

?>