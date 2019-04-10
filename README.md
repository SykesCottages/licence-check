# Licence Check

This is a package which allows checking that all of the dependencies of a project conform to an agreed set of licences.

## Guide
To run a basic check with no options install the checker

`composer require sykescottages/licence-check`

to run 

`./vendor/bin/licence-check`

This will by default check the current working directories composer for valid licences.

To customise the licences accepted pass `-l` / `--licence` as a command line option eg

`./vendor/bin/licence-check --licence YourLicence`

or to pass a file containing valid licences

`./vendor/bin/licence-check --licenceFile file.txt`

You can ignore certain packages with the `-i` / `--ignoreFile` flag to pass a file or `--ignore` for a single package


## NPM

This can also check NPM, you will need to install the licence check (globally to make it easier)

`sudo npm install -g license-report`

then call the same binary as above with a seperate flag

`./vendor/bin/licence-check --type Npm`

The flags documented above work in the same way

## Running from any directory

To run from any directory you need to provide input on `STDIN`. This is expected to be JSON for composer and csv for NPM
