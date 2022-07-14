#!/bin/bash

export USER_ID=`id -u`

if [ "$1" == "fix" ];
  then
    docker run --rm --user=$USER_ID -it -v $PWD:/app zedsh/php-lint-fix php-cs-fixer fix
  else
    docker run --rm -it --user=$USER_ID -v $PWD:/app zedsh/php-lint-fix php-cs-fixer fix --dry-run --diff
fi

