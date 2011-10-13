class synvm {
	include web
}

class web {
	package {"apache2": ensure => present}
	package {"php5": ensure => present}
	package {"php5-cli": ensure => present}
	package {"php5-common": ensure => present}
	package {"php5-curl": ensure => present}
	package {"php5-dev": ensure => present}
	package {"php5-mcrypt": ensure => present}
	package {"php5-xdebug": ensure => present}

	service { "apache2":
		ensure  => running,
		require => Package["apache2"],
	}
}

include synvm