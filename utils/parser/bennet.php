<?php
// Create a DOM object from a string
//$html = str_get_html('<html><body>Hello!</body></html>');
// Create a DOM object from a URL
//$html = file_get_html('http://www.google.com/');
// Create a DOM object from a HTML file
//$html = file_get_html('test.htm');


class Shop
	{
	public $id;
	public $name;
	public $city;
	public $address;
	public $postalcode;
	public $province;
	public $province2;
	public $region;
	public $nation_id;
	public $logitude;
	public $latitude;
	public $idremote;
	public $urlremote;
	public $jsondataremote;
	public $typemarket;
	public $groupmarket;
	public $account_id;
	public $logo;
	public $phone;
	}


error_reporting(E_ALL);
ini_set("display_errors", 1);
//http://simplehtmldom.sourceforge.net/manual_api.htm
include "lib/simple_html_parser/simple_html_dom.php";

$html = file_get_html("data/bennet.html");
//echo "<h1>START</h1>";
$tag = "script";
$elements = $html->find($tag);
$n_elements = count($elements);
//echo "<h3>elements: {$n_elements}</h3>";
echo "<pre>";
$shops = [];
foreach ($elements as $element)
	{
	//echo var_dump($element). '<hr>';
	//find function load()

	preg_match('/function[ ]{1,}load\(\)/', $element, $matchs);

	if ($matchs)
		{
		//preso lo script, prelevo i market di gmap
		// var number_0085='<div name="Acqui....';
		//var number_([0-9]+)[ ]?='([\-:;\\\'\.\?/\+\&\,<>\w =\"\(\)\{\}_]+)';
		$number = null;
		preg_match_all("/var number_([0-9]+)[ ]?='([:;\\\'\.\? \/ \+\&\, <> \w = \"\(\)\{\}_\-@]+)';/",
			$element,
			$numbers);
		//		var_dump($numbers);
		if (count($numbers) < 1)
			{
			die("\$numbers è vuoro");
			}

		$ids = $numbers[1];
		$vars = $numbers[2];
		foreach ($ids as $key => $id)
			{
			$shop = [];
			//$id = id bennet
			$shop["id"] = $id;
			$shop["groupmarket"] = "bennet";

			//			echo "{$key}=>{$id}" . PHP_EOL;
			//			echo "<hr>" . htmlentities($vars[$key]) . "<hr>";
			$dom = str_get_html(stripslashes($vars[$key]));
			$shop["html"] = $vars[$key];
			/*
			<div name="Acqui Terme (AL)" title="Acqui Terme (AL)" class="googleMapsBoubble">
				<h2 style="margin-bottom: 0; text-transform: initial">
					<a href=\'schedaIpermercato.aspx?idIper=0085\'>Acqui Terme (AL)</a>
				</h2>
				<p class="text-primary">
					<strong></strong>
				</p>
				<p>Stradale Savona. 90/92. 15011 Acqui Terme AL. Italia</p>
				<p class="mbottom-none">Tel: +390144311422</p><p>Servizio Clienti: 800236638</p>
				<p class="mbottom-half">
					<a href=\'schedaIpermercato.aspx?idIper=0085\' class="button button-primary">Scheda ipermercato</a>
					<a id=\'lnkPath_0085\' href=\'https://www.bennet.com/ipermercati/cercaIpermercato.aspx?ric=2&idIper=0085\' class="button button-secondary">Ottieni indicazioni</a>
				</p>
				<div style=\'display:none\' class=\'iter\' id=\'pnlPath_0085\'>Da:
					<input id=\'txtPath_0085\' type=\'text\' onkeydown=processAddressKeyDown(event,\'btn_0085\'); />
					<input id=\'btn_0085\' type=\'button\' value=\'Vai\' onclick=\'openPath(this);\'/>
					<input id=\'hiLocation_0085\' type=\'hidden\' value=\'44.6771497007,8.4449450898\'/>
					<input id=\'hiAddress_0085\' type=\'hidden\' value=\'Acqui Terme (AL)\'/>
				</div>
			</div>
			//===================================================
			var number_0096='
			<div name="Castelvetro Piacentino (PC)" title="Castelvetro Piacentino (PC)" class="googleMapsBoubble">
				<div class=\'logoBoubble\'>
					<figure>
						<img alt=\'Castelvetro Piacentino (PC)\' src=\'https://www.bennet.com//resources/img/contents/ipermercati/loghi-ipermercati/BENN0096_s.gif\' />
					</figure>
				</div>
				<h2 style="margin-bottom: 0; text-transform: initial">
					<a href=\'schedaIpermercato.aspx?idIper=0096\'>Castelvetro Piacentino (PC)</a>
				</h2>
				<p class="text-primary">
					<strong>Centro Commerciale Verbena</strong>
				</p>
				<p>Località Fornace. 1. 29010 Castelvetro Piacentino PC. Italia</p>
				<p class="mbottom-none">Tel: +390523825184</p><p>Servizio Clienti: 800236638</p>
				<p class="mbottom-half">
					<a href=\'schedaIpermercato.aspx?idIper=0096\' class="button button-primary">Scheda ipermercato</a>
					<a id=\'lnkPath_0096\' href=\'https://www.bennet.com/ipermercati/cercaIpermercato.aspx?ric=2&idIper=0096\' class="button button-secondary">Ottieni indicazioni</a>
				</p>
				<div style=\'display:none\' class=\'iter\' id=\'pnlPath_0096\'>Da:
					<input id=\'txtPath_0096\' type=\'text\' onkeydown=processAddressKeyDown(event,\'btn_0096\'); />
					<input id=\'btn_0096\' type=\'button\' value=\'Vai\' onclick=\'openPath(this);\'/>
					<input id=\'hiLocation_0096\' type=\'hidden\' value=\'45.0948644506,9.9763845663\'/>
					<input id=\'hiAddress_0096\' type=\'hidden\' value=\'Castelvetro Piacentino (PC)\'/>
				</div>
			</div>';

			*/
			//name
			$shop["name"] = ucfirst("{$shop["groupmarket"]}");
			$node_name = $dom->find("p > strong", 0);
			$name = $dom->find("p > strong", 0)->plaintext;
			$shop["name"] = addslashes((($name) ? $name : $shop["name"]));
			//city = Acqui Terme (AL)
			$city = $dom->find("div", 0)->getAttribute("name");
			preg_match("/([\w \'\-\.]+)[ ]?\(?([A-Z]{2}|)\)?/", $city, $data);
			$shop["city"] = addslashes(trim($data[1]));
			//======== address
			$node_address = $node_name->parent()->next_sibling();
			$address = strtolower(trim($node_address->plaintext));
			preg_match("/^([a-z \'_\-]+)\.? ([0-9\\/\w]+)\.?/",
				$address,
				$address_matchs);
			//			print_r($address_matchs);
			$shop["address"] = addslashes("{$address_matchs[1]} {$address_matchs[2]}");
			//======== postalcode

			preg_match("/ ([0-9]{5}) /", $node_address->plaintext, $postals);
			$shop["postalcode"] = (!@$postals[1]) ? "000000" : $postals[1];
			//			if(!$postals[1]){
			//			die($node_address->plaintext);
			//			}
			//======== province
			//======== province2
			if ($data[2])
				{
				$shop["province2"] = trim($data[2]);
				}
			else
				{
				#provo dall'address
				preg_match("/ ([A-Z]{2})\.? /", trim($node_address->plaintext), $province2_matchs);
				if ($province2_matchs[1])
					{
					$shop["province2"] = trim($province2_matchs[1]);
					}
				}

			//======== region
			//======== nation_id
			$shop["nation_id"] = 109;
			//======== latitude+logitude
			$LatLnt = $dom->getElementsById("hiLocation_{$shop["id"]}", 0)->getAttribute("value");

			if ($LatLnt)
				{
				$cardinals = explode(",", $LatLnt);
				$shop["latitude"] = $cardinals[0];
				$shop["logitude"] = $cardinals[1];
				}
			//======== idremote
			$shop["idremote"] = $shop["id"];
			//======== urlremote
			$url = $dom->find("h2", 0);
			if ($url)
				{
				$shop["urlremote"] = $url->find("a", 0)->getAttribute("href");
				$baseUrl = "https://www.bennet.com";
				$shop["urlremote"] = "{$baseUrl}/{$shop["urlremote"]}";
				}
			//======== jsondataremote
			//======== typemarket
			$shop["typemarket"] = $shop["groupmarket"];
			//======== /groupmarket
			//======== account_id
			//======== logo
			$shop["logo"] = $figure = null;
			$figure = $dom->find("figure", 0);
			if ($figure)
				{
				$shop["logo"] = $figure->first_child()->getAttribute("src");
				}
			array_push($shops, $shop);
			//			if ($shop["id"] == "0040")
			//				{
			//				echo "<h3>DATA {$shop["id"]}=>{$shop["name"]}</h3>";
			//				echo "**{$node_address->plaintext}**";
			//				print_r($shop);
			//				die();
			//				}
			}
		}

	}
$_shops = [];
foreach ($shops as $datashop)
	{
	$data = json_decode(json_encode($datashop), false);
	$shop = new Shop;
	foreach ($data as $key => $value)
		{
		$shop->$key = $value;
		}

	//	echo "<h3>{$shop->id}</h3>";
	if (!$shop->id)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->id</p>");
		}
	if (!$shop->idremote)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->idremote</p>");
		}
	if (!$shop->name)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->name</p>");
		}
	if (!$shop->groupmarket)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->groupmarket</p>");
		}
	if (!$shop->nation_id)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->nation_id</p>");
		}
	if (!$shop->city)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->city</p>");
		}
	if (!$shop->postalcode)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->postalcode</p>");
		}
	if (!$shop->province2)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->province2</p>");
		}
	if (!$shop->typemarket)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->typemarket</p>");
		}
	if (!$shop->latitude)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->latitude</p>");
		}
	if (!$shop->logitude)
		{
		print_r($shop);
		die("<p style='color:red'>\$shop->logitude</p>");
		}
	unset($shop->html);
	array_push($_shops, $shop);
	}
$query = [];
foreach ($_shops as $shop)
	{
	//	$shop->logo=($shop->logo)?$shop->logo:"NULL";
	$sql = "INSERT INTO shops 
					(name, city, address,postalcode,province,province2,region,nation_id,logitude,latitude,idremote,urlremote,jsondataremote,typemarket ,groupmarket,logo)
				VALUES
					('{$shop->name}',
					'{$shop->city}',
					'{$shop->address}',
					'{$shop->postalcode}',
					NULL,
					'{$shop->province2}',
					NULL,
					109, 
					'{$shop->logitude}', 
					'{$shop->latitude}',
					'{$shop->idremote}',
					'{$shop->urlremote}',
					NULL,
					'{$shop->typemarket}',
					'{$shop->groupmarket}',
					'{$shop->logo}')
				ON DUPLICATE KEY UPDATE 
				name='{$shop->name}',
				city='{$shop->city}',
				address='{$shop->address}',
				postalcode='{$shop->postalcode}',
				province2='{$shop->province2}',
				region=NULL,
				logitude='{$shop->logitude}',
				latitude='{$shop->latitude}',
				urlremote='{$shop->urlremote}',
				typemarket='{$shop->typemarket}',
				logo='{$shop->logo}';			
	";
	array_push($query, $sql);
	}
echo join("\n", $query);

?>