<?php

namespace app;

use DateTime;
use PDO;
use pdo\PDOParam;
use stdClass;
use utilities\DefaultsProvider;

class MagazineController
{
	protected DefaultsProvider $provider;
	function __construct(DefaultsProvider $provider)
	{
		$this->provider = $provider;
	}

	function showInputForm()
	{
		$magazinesQuery = 'SELECT DISTINCT magazine FROM magazines';
		$pdoWrapper = $this->provider->getPDOWrapper();

		$magazinesQuery = 'SELECT DISTINCT magazine FROM magazines';
		$pdoWrapper->setQuery($magazinesQuery);
		$pdoWrapper->doQuery();
		$magazinesResult = $pdoWrapper->getResultArray();

		$twig = $this->provider->getTwig();
		echo $twig->render('add-magazine.html', ['magazines' => $magazinesResult]);
	}
	function addMagazine()
	{
		$magazineInfo = $this->validateMagazine();
		if (!$magazineInfo) {
			$retVal = new stdClass();
			$retVal->error = 'magazine info missing';
			return $retVal;
		}
		$pdoWrapper = $this->provider->getPDOWrapper();

		$insertMagazineParams = [];
		$insertMagazineQuery = 'INSERT INTO magazines SET magazine = :magazine, issue_date = :issueDate, issue_title = :issueTitle, quantity = 1 ON DUPLICATE KEY UPDATE quantity = quantity + 1';
		$insertMagazineParams = [
			new PDOParam(':magazine', $magazineInfo->magazine, PDO::PARAM_STR),
			new PDOParam(':issueDate', $magazineInfo->issueDate, PDO::PARAM_STR),
			new PDOParam(':issueTitle', $magazineInfo->issueTitle, PDO::PARAM_STR)
		];
		$pdoWrapper->setQuery($insertMagazineQuery);
		$pdoWrapper->prepareQuery();
		$pdoWrapper->bindParameters($insertMagazineParams);
		$pdoWrapper->executePreparedStatement();
	}

	private function validateMagazine()
	{
		if (empty($_POST['magazine'])) {
			return false;
		}
		if (empty($_POST['issue_date'])) {
			return false;
		}
		$retVal = new stdClass();
		$retVal->magazine = $_POST['magazine'];
		$retVal->issueDate = $_POST['issue_date'];
		$retVal->issueTitle = $_POST['issue_title'] ?? '';
		return $retVal;
	}

	// spiegelbilder -> 
	function viewMagazines()
	{
		$magazinesQuery = 'SELECT * FROM magazines';
		$pdoWrapper = $this->provider->getPDOWrapper();
		$pdoWrapper->doQuery($magazinesQuery);
		$magazinesResult = $pdoWrapper->getResultArray();
		$twig = $this->provider->getTwig();
		$magazines = [];
		foreach ($magazinesResult as $magazine) {
			$magazines[] = $this->populateMagazine($magazine);
		}
		echo $twig->render('magazines.html', ['magazines' => $magazines]);
	}

	function populateMagazine(array $magazine): stdClass
	{
		$mag = new stdClass();
		$magazineDate = new DateTime($magazine['issue_date']);
		$mag->date = $magazineDate->format('d.M.y');
		$mag->title = $magazine['issue_title'];
		if ($magazine['magazine'] === 'Spiegel') {
			$week = $magazineDate->format('W');
			$year = $magazineDate->format('Y');
			$mag->imageSrc = "https://cdn.magazin.spiegel.de/EpubDelivery/image/title/sp/$year/$week/500";
		}
		return $mag;
	}
}
