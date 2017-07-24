<?php

$json = json_decode(file_get_contents("json/carrefour.json"));
$query = [];
foreach ($json as $shop)
	{
	$notused = "{$shop->field_pdv_citta_value} {$shop->field_pdv_indirizzo_value}";
	$start = 0;
	$end = intval(strlen($shop->title) - strlen($notused)) - 2;
	$title_clean = addslashes(substr($shop->title, $start, $end));

	$sql = "";
	$field_pdv_citta_value = addslashes($shop->field_pdv_citta_value);
	$field_pdv_indirizzo_value = addslashes($shop->field_pdv_indirizzo_value);
	$field_pdv_cap_value = addslashes($shop->field_pdv_cap_value);
	$field_pdv_provincia_value = addslashes($shop->field_pdv_provincia_value);
	$field_pdv_citta_value = addslashes($shop->field_pdv_citta_value);
	$field_pdv_regione_value = addslashes($shop->field_pdv_regione_value);
	$field_pdv_lng_value = addslashes($shop->field_pdv_lng_value);
	$field_pdv_lat_value = addslashes($shop->field_pdv_lat_value);
	$field_pdv_insegna_value = addslashes($shop->field_pdv_insegna_value);

	$sql = "REPLACE  INTO shops ('{$field_pdv_insegna_value}','{$field_pdv_citta_value}', '{$field_pdv_indirizzo_value}', '{$field_pdv_cap_value}',NULL,'{$field_pdv_provincia_value}','{$field_pdv_regione_value}',109, '{$field_pdv_lng_value}', '{$field_pdv_lat_value}', '{$shop->nid}', '{$shop->url}', NULL, '{$field_pdv_insegna_value}','carrefour')
				SELECT shops.name, shops.city, shops.address,shops.postalcode,shops.province,shops.province2,shops.region,shops.nation_id,shops.logitude,shops.latitude,shops.idremote,shops.urlremote,shops.jsondataremote,shops.typemarket ,shops.groupmarket
				WHERE shops.idremote = {$shop->nid};";
	array_push($query, $sql);
	}
echo join("\n", $query);
