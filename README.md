# check_dokuwiki

This is a monitoring plugin for [icinga](https://www.icinga.com) to check the [Dokuwiki](https://www.dokuwiki.org) update status.


### Requirements
You need to run this check on the same host where Dokuwiki is installed.


### Usage
Try the plugin at the command line like this:
```
/usr/bin/php ./check_dokuwiki.php -p /path/to/dokuwiki/
```

You can define the icinga2 check command as follows:
```
/* Define check command for check_dokuwiki */
object CheckCommand "dokuwiki" {
  import "plugin-check-command"
  command = [ LocalPluginDir + "/check_dokuwiki.php" ]

  arguments = {
    "-p" = {
      "required" = true
      "value" = "$dw_path$"
    }
  }
}
```


### Changelog
* 2017-03-10: check if doku.php exists in given path
* 2017-03-09: initial public release


### Contributors
* [nbuchwitz](https://github.com/nbuchwitz)


### License
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
