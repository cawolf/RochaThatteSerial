# Rocha Thatte (serial)
Implementation of the Rocha-Thatte algorithm in a single thread.

[![Build Status](https://travis-ci.org/cawolf/RochaThatteSerial.svg?branch=master)](https://travis-ci.org/cawolf/RochaThatteSerial)
[![Packagist](https://img.shields.io/packagist/v/cawolf/rocha-thatte-serial.svg?maxAge=2592000)](https://packagist.org/packages/cawolf/rocha-thatte-serial)
[![Packagist](https://img.shields.io/packagist/l/cawolf/rocha-thatte-serial.svg?maxAge=2592000)](https://packagist.org/packages/cawolf/rocha-thatte-serial)


### Installation

    composer require cawolf/rocha-thatte-serial
    
### Usage

Instantiate the class `Cawolf\RochaThatte\Cycle` and call the function `detect(Fhaculty\Graph\Graph $graph)` on a graph 
object to detect cycles in a directed Graph.
