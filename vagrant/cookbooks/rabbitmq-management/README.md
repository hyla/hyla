# Description

Installs the rabbitmq-management plugin and dependencies and tells rabbitmq-server to restart.

# Requirements

Opscode cookbooks:

* rabbitmq

Platform:

Any platform supported by the Opscode rabbitmq cookbook.

Services:

* rabbitmq-server v2.7.0 (or greater)

The rabbitmq cookbook (as of version 1.3.0) does not provide a service definition for rabbitmq-server, so you will need to add something like this to it:

```ruby
service "rabbitmq-server" do
  stop_command "/usr/sbin/rabbitmqctl stop"
  action [:enable, :start]
end
```

This should become unnecessary once [COOK-585](http://tickets.opscode.com/browse/COOK-585) is closed and merged.

# Usage

Add `recipe[rabbitmq-management]` to a run list.

# License & Author

Author: J.D. Hollis (<http://densityofspace.com>)

Copyright: 2011, J.D. Hollis

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
