<?php
/**
 * User: luca.bottoni
 * Date: 26/07/2017
 * Time: 15:11
 * To change this template use File | Settings | File Templates.
 */

namespace Ehc;


interface AbstractParserShop
	{
	/**
	 * @param null $url  url da contattare per recuperare i dati
	 * @param null $data data grezzo da passare a this->parseRawData
	 * @return mixed
	 */
	public function getRawData($url = null, $data = null);

	/**
	 * elabora la risposra di this->getRawData
	 *
	 * @param null $rawdata
	 * @return mixed
	 */
	public function parseRawData($rawdata = null);

	/**
	 * riceve un model cakephp shop da introdurre nel db
	 *
	 * @param object model shop
	 * @return mixed
	 */
	public function setShop($shop);

	public function getShop($id);

	public function updateShops();
	}


class parserShop implements AbstractParserShop
	{
	public function getRawData($url = null, $data = null)
		{
		}

	public function parseRawData($rawdata = null)
		{
		}

	public function setShop($shop)
		{
		}

	public function getShop($id)
		{
		}

	public function updateShops()
		{
		}
	}