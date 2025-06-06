#!/bin/bash
#
# Install our stuff
#

## mu-plugins
yes | cp -rf ~/mine/vip-go-sandbox/mu-plugins/00-sandbox-helper.php /var/www/wp-content/mu-plugins/.

if [ ! -f /var/www/wp-content/mu-plugins/http-concat/concat-utils.php.original ]; then
  mv /var/www/wp-content/mu-plugins/http-concat/concat-utils.php /var/www/wp-content/mu-plugins/http-concat/concat-utils.php.original
  yes | cp -rf ~/mine/vip-go-sandbox/mu-plugins/concat-utils.php /var/www/wp-content/mu-plugins/http-concat/concat-utils.php
fi

if [ ! -f /var/www/wp-content/mu-plugins/http-concat/cssconcat.php.original ]; then
  mv /var/www/wp-content/mu-plugins/http-concat/cssconcat.php /var/www/wp-content/mu-plugins/http-concat/cssconcat.php.original
  yes | cp -rf ~/mine/vip-go-sandbox/mu-plugins/cssconcat.php /var/www/wp-content/mu-plugins/http-concat/cssconcat.php
fi

if [ ! -f /var/www/wp-content/mu-plugins/http-concat/jsconcat.php.original ]; then
  mv /var/www/wp-content/mu-plugins/http-concat/jsconcat.php /var/www/wp-content/mu-plugins/http-concat/jsconcat.php.original
  yes | cp -rf ~/mine/vip-go-sandbox/mu-plugins/jsconcat.php /var/www/wp-content/mu-plugins/http-concat/jsconcat.php
fi

#if [ ! -d /var/www/wp-content/mu-plugins/sandbox-wp-debugger/ ]; then
#  git clone git@github.com:Automattic/sandbox-wp-debugger.git /var/www/wp-content/mu-plugins/sandbox-wp-debugger
#  pushd /var/www/wp-content/mu-plugins/sandbox-wp-debugger > /dev/null
#  git checkout emrikol/custom-sandbox-wp-debugger
#  popd > /dev/null
#fi

# ~/.go-sandbox.json is a file on your local
#
# {
#   "git_config_user.name": "",
#   "git_config_user.email": ""
# }
#
# ~/.go-sandbox.json is copied from local to remote via
# the LocalCommand directive in your ~/.ssh/config
#
# e.g.
#  PermitLocalCommand yes
#  LocalCommand scp ~/.go-sandbox.json %h:~/.
#
if [ -f ~/.go-sandbox.json ]; then
  git_user_email=$(jq -r '.["git_config_user.email"]' < ~/.go-sandbox.json)
  git_user_name=$(jq -r '.["git_config_user.name"]' < ~/.go-sandbox.json)
  if [[ ! -z $git_user_email ]]; then
    git config --global --replace-all user.email "$git_user_email"
  fi
  if [[ ! -z $git_user_name ]]; then
    git config --global --replace-all user.name "$git_user_name"
  fi
  git config --global pull.rebase false
fi


# self-update
git -C ~/mine/vip-go-sandbox/ pull --rebase > /dev/null

# don't check if files exist so they'll always get updated when this script runs
cp .prompt ~/.prompt
cp .vimrc ~/.vimrc
cp .mybashrc ~/.mybashrc
cp wp-cli-global.yml ~/wp-cli-global.yml

# ensure line break
echo '' >> ~/.bashrc

if [[ ! $(cat ~/.bashrc | grep mybashrc) ]]; then
  echo 'source ~/.mybashrc' >> ~/.bashrc
fi
if [[ ! $(cat ~/.bashrc | grep prompt) ]]; then
  echo 'source ~/.prompt' >> ~/.bashrc
fi

if [[ ! $(cat ~/.bashrc | grep 'cd ~/') ]]; then
  echo 'cd ~/' >> ~/.bashrc
fi

source ~/.bashrc
