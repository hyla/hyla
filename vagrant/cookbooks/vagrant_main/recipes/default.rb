node.set["apache"]["user"] = "vagrant"
node.set["apache"]["group"] = "vagrant"

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

package "couchapp"
package "php5-xdebug"

apt_repository "php-amqp" do
  uri "http://ppa.launchpad.net/managedit/php-extensions/ubuntu"
  distribution "oneiric"
  components ["main"]
  key "F9E66E70"
  keyserver "keyserver.ubuntu.com"
  action :add
end
package "php5-amqp"

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

template "couchdb/local.ini" do
  owner "couchdb"
  group "couchdb"
  mode 0664
  path "/etc/couchdb/local.ini"
  source "couchdb.local.ini.erb"
end

service "couchdb" do
  action [ :enable, :start ]
end
service "apache2" do
  action :restart
end

remote_file "/usr/bin/wkhtmltopdf" do
  source "http://zeelot.s3.amazonaws.com/cookbook-files/wkhtmltopdf-amd64-0.9.9"
  group "root"
  owner "root"
  mode "0755"
  checksum "c1047cca6bce10d3d1cf7fed4520f2f2be5be5176cba73cf550d0f87f530df3e"
end