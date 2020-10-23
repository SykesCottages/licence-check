<?php

namespace SykesCottages\LicenceCheck;

use InvalidArgumentException;

class Composer extends Checker
{
    public function validate($licenceJson)
    {
        $licences    = [];
        $licenceJson = json_decode($licenceJson);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }
        
        foreach ($licenceJson->dependencies as $name => $dependency) {
            $licences[$name] = $dependency->license;
        }

        return $this->checkLicences($licences);
    }

    public function getDefaultOutput()
    {
        return shell_exec('composer licenses --format=json');
    }
}
