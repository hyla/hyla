require_recipe "apt"

require_recipe "apache2"
require_recipe "apache2::mod_php5"
require_recipe "apache2::mod_rewrite"
require_recipe "apache2::mod_ssl"
require_recipe "apache2::mod_headers"

require_recipe "php"
require_recipe "php::module_curl"
require_recipe "php::module_fileinfo"
require_recipe "php::module_gd"
require_recipe "php::module_memcache"
require_recipe "php::module_mysql"
require_recipe "php::module_sqlite3"

require_recipe "rabbitmq"
require_recipe "couchdb"

web_app "localhost" do
  server_name "localhost"
  docroot "/var/www/hyla"
end

gem_package "compass" do
  action :install
  version "0.11.5"
  provider Chef::Provider::Package::Rubygems
end

gem_package "foreman" do
  action :install
  version "0.26.1"
  provider Chef::Provider::Package::Rubygems
end