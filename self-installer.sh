#!/bin/bash

cd ~

if [[ ! -d ~/mine/ ]]; then
  mkdir mine && cd mine
  git clone git@github.com:trepmal/vip-go-sandbox.git && cd vip-go-sandbox && bash install.sh
elif [[ ! -d ~/mine/vip-go-sandbox ]]; then
  cd mine
  git clone git@github.com:trepmal/vip-go-sandbox.git && cd vip-go-sandbox && bash install.sh
else
  cd mine/vip-go-sandbox && bash install.sh
fi
