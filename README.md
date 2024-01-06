# vip-go-sandbox

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
- _note: CLI commands added by this tool are only available when run from `~`_
- customizes prompt with sandbox flag, time, multisite indicator, app nice-name, environment, git changes summary
- adds a `.vimrc` with assorted vim customizations
- adds a `.mybashrc` with assorted shortcuts
- runs a few global `git config --global` commands 
