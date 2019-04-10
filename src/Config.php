<?php
namespace SykesCottages\LicenceCheck;

use GetOpt\GetOpt;
use GetOpt\Option;

class Config
{
    /**
     * @var GetOpt
     */
    protected $getOpt;

    public function __construct()
    {
        $this->setArguments();
    }

    public function parseArguments($argumentLine)
    {
        $this->getOpt->process($argumentLine);
    }

    public function getArgument($argument)
    {
        return (array) $this->getOpt->getOption($argument);
    }

    protected function setArguments()
    {
        $licenseOption = new Option('l', 'licence', GetOpt::MULTIPLE_ARGUMENT);
        $licenseOption->setDescription(
            'Add a license to accept'
        );

        $baseFile = new Option('f', 'licenceFile', GetOpt::REQUIRED_ARGUMENT);
        $baseFile->setDescription(
            'Add a file to import from as a base'
        );
        $baseFile->setDefaultValue(__DIR__ . '/ValidLicences.txt');

        $ignoreFile = new Option('i', 'ignoreFile', GetOpt::MULTIPLE_ARGUMENT);
        $ignoreFile->setDescription(
            'Add a file for packages to ignore - add a comment with a #'
        );

        $ignorePackage = new Option(null, 'ignore', GetOpt::MULTIPLE_ARGUMENT);
        $ignorePackage->setDescription(
            'Add a file for packages to ignore - add a comment with a #'
        );

        $type = new Option('t', 'type', GetOpt::REQUIRED_ARGUMENT);
        $type->setDescription(
            'Check Composer / Npm file'
        );
        $type->setDefaultValue('Composer');

        $type->setValidation(function ($name) {
            return in_array($name, ['Composer','Npm']);
        });

        $this->getOpt = new GetOpt([
            $licenseOption,
            $baseFile,
            $ignoreFile,
            $ignorePackage,
            $type,
        ]);
    }
}
