# Hyla Project Manager

## Quick Intro

Hyla is a highly modular project manager. At it's core, it will basically only allow you to create, edit, and delete projects. Everything else will be built into plugins. I will be ditributing a packages Hyla with the plugins that are most useful to me, but everyone seems to have slightly different needs for a project manager, Hyla should accommodate everyone nicely (eventually). Because of the need for flexibility, Hyla will require both CouchDB and RabbitMQ. I feel like these two dependencies will greatly improve Hyla's ability to adapt to everyone's needs.

## Installation

I don't want to spend a lot of effort on the installation components so early on in Hyla's development, so in order to install and contribute to the code, you will need to adapt a little to my development process. Assuming you have CouchDB installed, you should be able to get up and running quickly. RabbitMQ will be a dependency soon, but isn't at the moment.

The application is initially set to function from the url `http://dev.vm/hyla`. You can alter this in the `.htaccess` and `kohana/application/bootstrap.php` files but it's simpler if you add an entry to your `/etc/hosts` file instead in order to make `http://dev.vm/hyla` point to your copy of hyla.

1. clone the repository
1. alter `kohana/application/config/couchdb.php` as needed (preferred if you adjust your /etc/hosts file instead)
1. if altering the `couchdb.php` config, make sure to adjust `kohana/modules/hyla/couchapp/.couchapprc` as well.
1. create a `hyla` database on your CouchDB server
1. `cd` into `kohana/modules/hyla/couchapp` and run `couchapp push` (install couchapp if needed)