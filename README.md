mongolib_ci
===========

A simple connection library for using MongoDB in Code Igniter

Installation:
Add Mongolib.php to application/libraries
Add mongo_config.php to application/config
Add <code>$config['mongo_config'] = 'mongo_db.localhost.php';</code> to application/config/config.php

Usage:
Create a subclass in application/models for your Mongo Collection which extends Mongolib.
Set your dbName and collName variables in your subclass.
In your controller, load your model ($this->load->model('MyMongoModel')),
then use the native PHP Mongo driver methods to interact with the collection ($this->MyMongoModel->collection->insert($data)).

See the PHP Mongo Driver docs for method list: http://us.php.net/manual/en/class.mongo.php
