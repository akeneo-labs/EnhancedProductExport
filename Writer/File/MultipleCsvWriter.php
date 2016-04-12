<?php

namespace Pim\Bundle\EnhancedConnectorBundle\Writer\File;

use Akeneo\Component\Batch\Job\RuntimeErrorException;
use Pim\Component\Connector\Writer\File\CsvProductWriter;

class MultipleCsvWriter extends CsvProductWriter
{
    public function getPath()
    {
        if (null === $this->resolvedFilePath) {
            $resolved = $this->filePathResolver->resolve($this->filePath, $this->filePathResolverOptions);
            $targetDirectory = dirname($resolved);
            $stepName = $this->stepExecution->getStepName();
            $foo = $this->stepExecution->getJobExecution()->getJobInstance()->getJob()->getStep($this->stepExecution->getStepName());
            file_put_contents('/tmp/jml.log', print_r(get_class($foo), true));
            $filepath = sprintf('%s/%s.csv', $targetDirectory, $stepName);
            $this->resolvedFilePath = $filepath;
        }

        return $this->resolvedFilePath;
    }

    protected function createCsvFile()
    {
        $filepath = $this->getPath();

        if (false === $file = fopen($filepath, 'w')) {
            throw new RuntimeErrorException('Failed to open file %path%', ['%path%' => $filepath]);
        }

        return $file;
    }
}
