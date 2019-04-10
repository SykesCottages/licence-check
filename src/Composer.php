<?php


namespace SykesCottages\LicenceCheck;


class Composer extends Checker
{
    private $depth = 10;

    public function validate($licenceJson)
    {
        $licenceJson = json_decode(
            $licenceJson,
            false,
            $this->depth,
            JSON_THROW_ON_ERROR
        );

        $licences = [];
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

