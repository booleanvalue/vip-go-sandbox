#!/bin/bash
#
# Simply install this repo
#

pushd ~ > /dev/null

# make ~/mine (if it doesn't exist)
if [[ ! -d ~/mine/ ]]; then
  mkdir mine
fi

# clone vip-go-sandbox into ~/mine (if it doesn't exist)
if [[ ! -d ~/mine/vip-go-sandbox ]]; then
  git clone git@github.com:trepmal/vip-go-sandbox.git mine/vip-go-sandbox
fi

# go into repo, run install, leave
pushd mine/vip-go-sandbox > /dev/null && bash install.sh && popd > /dev/null


popd > /dev/null
