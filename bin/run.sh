#!/usr/bin/env bash


for ((n=0;n<$2;n++)); do php tests/statistical.php $1; done
