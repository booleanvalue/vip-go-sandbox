#!/bin/bash

pushd ~

if [[ ! -d ~/mine/ ]]; then
  mkdir mine && pushd mine
  git clone git@github.com:trepmal/vip-go-sandbox.git && pushd vip-go-sandbox && bash install.sh && popd
elif [[ ! -d ~/mine/vip-go-sandbox ]]; then
  pushd mine
  git clone git@github.com:trepmal/vip-go-sandbox.git && pushd vip-go-sandbox && bash install.sh && popd
else
  pushd mine/vip-go-sandbox && bash install.sh
fi
popd

popd
