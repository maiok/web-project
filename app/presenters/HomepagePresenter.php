<?php

namespace App\Presenters;

use Elasticsearch\ClientBuilder;
use Nette;
use Nette\Neon\Exception;
use Throwable;

class HomepagePresenter extends Nette\Application\UI\Presenter
{
	/**
	 * @var ClientBuilder
	 */
	private $client;

	/** @var string Index name */
	protected $indexName = 'my_first_index';

	protected function startup()
	{
		parent::startup();
		$this->client = ClientBuilder::create()->build();
	}

	public function handleCreateIndex()
	{
		// asociativne pole dat potrebnych pre vytvorenie indexu
		$params = [
			'index' => $this->indexName,
			'body'  => [
				'settings' => [
					'number_of_shards'   => 2,
					'number_of_replicas' => 0
				]
			]
		];

		try {
			$response = $this->client->indices()->create($params);
			print_r($response);
		} catch (Throwable $e) {
			print_r($e->getMessage());
		}
	}

	public function handleRemoveIndex()
	{
		$deleteParams = [
			'index' => $this->indexName
		];

		try {
			$response = $this->client->indices()->delete($deleteParams);
			print_r($response);
		} catch (Throwable $e) {
			print_r($e->getMessage());
		}

	}

}
