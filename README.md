# Hyla Project Manager

## Quick Intro

Hyla is a highly modular project manager. At it's core, it will basically only allow you to create, edit, and delete projects. Everything else will be built into plugins. I will be distributing a packaged Hyla with the plugins that are most useful to me, but as everyone seems to have slightly different needs for a project manager, Hyla should accommodate everyone nicely (eventually). Because of the need for flexibility, Hyla will require both CouchDB and RabbitMQ. I feel like these two dependencies will greatly improve Hyla's ability to adapt to everyone's needs.

## Installation

I don't want to spend a lot of effort on the installation components so early on in Hyla's development, so in order to install and contribute to the code, you will need to adapt a little to my development process. Assuming you have CouchDB installed, you should be able to get up and running quickly. RabbitMQ will be a dependency soon, but isn't at the moment.

The application is initially set to function from the url `http://dev.vm/hyla`. You can alter this in the `.htaccess` and `kohana/application/bootstrap.php` files but it's simpler if you add an entry to your `/etc/hosts` file instead in order to make `http://dev.vm/hyla` point to your copy of hyla.

1. clone the repository
1. alter `kohana/application/config/couchdb.php` as needed (preferred if you adjust your /etc/hosts file instead)
1. if altering the `couchdb.php` config, make sure to adjust `kohana/modules/hyla/couchapp/.couchapprc` as well.
1. create a `hyla` database on your CouchDB server
1. `cd` into `kohana/modules/hyla/couchapp` and run `couchapp push` (install couchapp if needed)

## Using Procfile

Procfile is used to define background processes that need to be run along with the Hyla web interface. The file is at the root of the repository and currently contains an example entry. Hyla will be using background workers (written with Minion) for performing tasks independantly of the web interface. Common uses of worker processes is for offloading the sending of emails and the generation of PDFs so that the user is not waiting for these things to be done before being shown a page.

I have added the minion task `workers:test` which simply runs forever and does nothing. It's simply used as an example of how to define its dependency in a Procfile and how to use Foreman and Upstart in order to start the dependencies along with Hyla.

### Foreman

Foreman is used during development only and is an awesome tool to quickly start up all background processes and monitor their output. It is a tool written in Ruby so install it using `gem install foreman`. You can then start all the processes defined in the Procfile by running `foreman start` from the root of the Hyla repository. The output from all the processes started by Foreman will be combined and shown in the terminal. This is great for debugging background processes.

### Upstart

Upstart is used in Ubuntu for starting and stopping services. Since Hyla isn't ready for production yet, I won't waste time writing the tutorials for deploying it to the various platforms. Here is a great article about the process I am using though: [http://adam.heroku.com/past/2011/5/9/applying_the_unix_process_model_to_web_apps/]

I will update this section as soon as I feel it's worth deploying Hyla to a real server (soon!) In the meantime, use Foreman for development :)