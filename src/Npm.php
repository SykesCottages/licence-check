<?php


namespace SykesCottages\LicenceCheck;


class Npm extends Checker
{

    const NAME = 2;
    const LICENCE = 5;

    public function validate($licenceCsv)
    {

        $licences = array_map(
            function($line) {
                return str_getcsv($line);
            },
            explode("\n", ($licenceCsv))
        );

        $output = [];
        foreach ($licences as $licence) {
            if (!empty($licence[self::NAME])) {
                $parsed = $this->parseLicence($licence[self::LICENCE]);
                $output[$licence[self::NAME]] = $parsed;
            }
        }

        $this->checkLicences($output);

    }

    public function getDefaultOutput()
    {
        return shell_exec('license-report --output=csv');
    }

    protected function parseLicence($licence)
    {
        $licence = str_replace([
                '(',
                ')'
            ],
            '',
            $licence
        );

        $licence = explode(' AND ', $licence);
        return $licence;
    }
}

