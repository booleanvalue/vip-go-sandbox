#!/bin/bash

pushd ~ > /dev/null

if [[ ! -d ~/mine/ ]]; then
  mkdir mine && pushd mine > /dev/null
  git clone git@github.com:trepmal/vip-go-sandbox.git && pushd vip-go-sandbox > /dev/null && bash install.sh && popd > /dev/null
elif [[ ! -d ~/mine/vip-go-sandbox ]]; then
  pushd mine > /dev/null
  git clone git@github.com:trepmal/vip-go-sandbox.git && pushd vip-go-sandbox > /dev/null && bash install.sh && popd > /dev/null
else
  pushd mine/vip-go-sandbox > /dev/null && bash install.sh
fi
popd > /dev/null

popd > /dev/null
