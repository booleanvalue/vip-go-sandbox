#!/bin/bash
yes | cp -rf ~/mine/vip-go-sandbox/mu-plugins/00-sandbox-helper.php /var/www/wp-content/mu-plugins/.


git config --global user.email "kailey.lampert@automattic.com"
git config --global user.name "Kailey Lampert"

# self-update
git -C ~/mine/vip-go-sandbox/ pull --rebase > /dev/null

#if [ ! -d /mine/vip-go-sandbox/tools/vip-cli/dist ]; then
#	pushd /mine/vip-go-sandbox/tools/vip-cli
#	npm install
#	npm run build
#	popd
#fi

# don't check if files exist so they'll always get updated when this script runs
cp .prompt ~/.prompt
cp .vimrc ~/.vimrc
cp .mybashrc ~/.mybashrc
cp wp-cli.yml ~/wp-cli.yml

# ensure line break
echo '' >> ~/.bashrc

if [[ ! $(cat ~/.bashrc | grep mybashrc) ]]; then
  echo 'source ~/.mybashrc' >> ~/.bashrc
fi
if [[ ! $(cat ~/.bashrc | grep prompt) ]]; then
  echo 'source ~/.prompt' >> ~/.bashrc
fi

source ~/.bashrc
