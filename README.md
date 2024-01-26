# vip-go-sandbox

Customizations for my sandboxes.

To make this work as magically as possible, I have this in my ssh config (only relevant directives shown) in addition to the standard Host block

```
# only add this config when NOT using Transmit app. YMMV, adjust as needed.
Match Host YOUR_HOST exec "[[ ! $__CFBundleIdentifier = 'com.panic.Transmit' ]]"
  RequestTTY force
  RemoteCommand bash <(curl -s "https://url-to-this/self-installer.sh") && bash -l
```
## What does this do on sandboxes?

- installs [option-cache](https://github.com/trepmal/option-cache-cli/) WP-CLI command
- installs `wp network list` CLI command (from [Misc WP CLI](https://github.com/trepmal/misc-wp-cli))
- installs `wp site update` CLI command (from [Misc WP CLI](https://github.com/trepmal/misc-wp-cli))
- installs `wp cron-control debug` CLI command (from [Misc WP CLI](https://github.com/trepmal/misc-wp-cli))
- sets `WP_CLI_CONFIG_PATH` to load our custom config which makes above commands available. It is also to inherit from the main config on sandboxes
- customizes prompt with sandbox flag, time, multisite indicator, app nice-name, environment, git changes summary
- adds a `.vimrc` with assorted vim customizations
- adds a `.mybashrc` with assorted shortcuts
- runs a few global `git config --global` commands 
