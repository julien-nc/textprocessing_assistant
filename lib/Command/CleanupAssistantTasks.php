<?php

// SPDX-FileCopyrightText: Sami Finnilä <sami.finnila@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\TpAssistant\Command;

use Exception;
use OC\Core\Command\Base;
use OCA\TpAssistant\AppInfo\Application;
use OCA\TpAssistant\Db\TaskMapper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanupAssistantTasks extends Base {
	public function __construct(
		private TaskMapper $taskMapper,
	) {
		parent::__construct();
	}

	protected function configure() {
		$maxIdleTimeSetting = Application::DEFAULT_ASSISTANT_TASK_IDLE_TIME;
		$this->setName('assistant:task_cleanup')
			->setDescription('Cleanup assistant tasks')
			->addArgument(
				'max_age',
				InputArgument::OPTIONAL,
				'The max idle time (in seconds)',
				$maxIdleTimeSetting
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$maxAge = intval($input->getArgument('max_age'));

		if ($maxAge < 1) {
			$output->writeln('Invalid value for max_age: ' . $maxAge);
			return 1;
		}

		$output->writeln('Cleanning up assistant tasks older than ' . $maxAge . ' seconds.');
		try {
			$cleanedUp = $this->taskMapper->cleanupOldTasks($maxAge);
		} catch (Exception $e) {
			$output->writeln('Error: ' . $e->getMessage());
			return 1;
		}

		$output->writeln('Deleted ' . $cleanedUp . ' idle tasks.');
		return 0;
	}
}
