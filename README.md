# vip-go-sandbox

To make this work as magically as possible, I have this in my ssh config (only relevant directives shown) in addition to the standard Host block

```
# only add this config when NOT using Transmit app. YMMV, adjust as needed.
Match Host YOUR_HOST exec "[[ ! $__CFBundleIdentifier = 'com.panic.Transmit' ]]"
  RequestTTY force
  RemoteCommand bash <(curl -s "https://url-to-this/self-installer.sh") && bash -l
```
