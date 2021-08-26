#!/bin/bash
yes | cp -rf ~/mine/vip-go-sandbox/mu-plugins/00-sandbox-helper.php /var/www/wp-content/mu-plugins/.

alias logs="tail -F /tmp/php-errors -F /chroot/tmp/php-errors"
alias run-crons="wp site list --path=/chroot/var/www --field=url | xargs -I URL wp --path=/chroot/var/www cron event run --due-now --url=URL"

git config --global user.email "kailey.lampert@automattic.com"
git config --global user.name "Kailey Lampert"

# self-update
git -C ~/mine/vip-go-sandbox/ pull > /dev/null

export WP_CLI_PACKAGES_DIR='/root/mine/wpcli-packages'
mkdir -p $WP_CLI_PACKAGES_DIR

#if [ ! -d /mine/vip-go-sandbox/tools/vip-cli/dist ]; then
#	pushd /mine/vip-go-sandbox/tools/vip-cli
#	npm install
#	npm run build
#	popd
#fi

# don't check if files exist so they'll always get updated when this script runs
cp .prompt ~/.prompt
echo 'source ~/.prompt' >> ~/.bashrc
cp .vimrc ~/.vimrc
